<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Result;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Result controller.
 *
 * @Route("admin/result")
 */
class ResultController extends Controller
{
    /**
     * Lists all result entities.
     *
     * @Route("/", name="admin_result_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $results = $em->getRepository('AppBundle:Result')->findAll();

        $deleteForms = array();
        foreach ($results as $r) {
            $deleteForms[$r->getId()] = $this->createDeleteForm($r)->createView();
        }

        return $this->render('result/index.html.twig', array(
            'results' => $results,
            'deleteforms' => $deleteForms,
        ));
    }

    /**
     * Creates a new result entity.
     *
     * @Route("/new", name="admin_result_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $result = new Result();
        $form = $this->createForm('AppBundle\Form\ResultType', $result);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($result);
            $em->flush();

            return $this->redirectToRoute('admin_result_index');
        }

        return $this->render('result/new.html.twig', array(
            'result' => $result,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing result entity.
     *
     * @Route("/{id}/edit", name="admin_result_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Result $result)
    {
        $deleteForm = $this->createDeleteForm($result);
        $editForm = $this->createForm('AppBundle\Form\ResultType', $result);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_result_index');
        }

        return $this->render('result/edit.html.twig', array(
            'result' => $result,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a result entity.
     *
     * @Route("/{id}", name="admin_result_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Result $result)
    {
        $form = $this->createDeleteForm($result);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($result);
            $em->flush();
        }

        return $this->redirectToRoute('admin_result_index');
    }

    /**
     * Creates a form to delete a result entity.
     *
     * @param Result $result The result entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Result $result)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_result_delete', array('id' => $result->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
