<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Kanala;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Kanala controller.
 *
 * @Route("admin/kanala")
 */
class KanalaController extends Controller
{
    /**
     * Lists all kanala entities.
     *
     * @Route("/", name="admin_kanala_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $kanalas = $em->getRepository('AppBundle:Kanala')->findAll();

        $deleteForms = array();
        foreach ($kanalas as $kanala) {
            $deleteForms[$kanala->getId()] = $this->createDeleteForm($kanala)->createView();
        }

        return $this->render('kanala/index.html.twig', array(
            'kanalas' => $kanalas,
            'deleteforms' => $deleteForms,
        ));
    }

    /**
     * Creates a new kanala entity.
     *
     * @Route("/new", name="admin_kanala_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $kanala = new Kanala();
        $form = $this->createForm('AppBundle\Form\KanalaType', $kanala);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($kanala);
            $em->flush();

            return $this->redirectToRoute('admin_kanala_index');
        }

        return $this->render('kanala/new.html.twig', array(
            'kanala' => $kanala,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing kanala entity.
     *
     * @Route("/{id}/edit", name="admin_kanala_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Kanala $kanala)
    {
        $deleteForm = $this->createDeleteForm($kanala);
        $editForm = $this->createForm('AppBundle\Form\KanalaType', $kanala);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_kanala_index');
        }

        return $this->render('kanala/edit.html.twig', array(
            'kanala' => $kanala,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a kanala entity.
     *
     * @Route("/{id}", name="admin_kanala_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Kanala $kanala)
    {
        $form = $this->createDeleteForm($kanala);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($kanala);
            $em->flush();
        }

        return $this->redirectToRoute('admin_kanala_index');
    }

    /**
     * Creates a form to delete a kanala entity.
     *
     * @param Kanala $kanala The kanala entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Kanala $kanala)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_kanala_delete', array('id' => $kanala->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
