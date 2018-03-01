<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Barrutia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Barrutium controller.
 *
 * @Route("admin/barrutia")
 */
class BarrutiaController extends Controller
{
    /**
     * Lists all barrutium entities.
     *
     * @Route("/", name="admin_barrutia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $barrutiak = $em->getRepository('AppBundle:Barrutia')->findAll();

        $deleteForms = array();
        foreach ($barrutiak as $barrutia) {
            $deleteForms[$barrutia->getId()] = $this->createDeleteForm($barrutia)->createView();
        }

        return $this->render('barrutia/index.html.twig', array(
            'barrutiak' => $barrutiak,
            'deleteforms' => $deleteForms,
        ));
    }

    /**
     * Creates a new barrutium entity.
     *
     * @Route("/new", name="admin_barrutia_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $barrutium = new Barrutia();
        $form = $this->createForm('AppBundle\Form\BarrutiaType', $barrutium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($barrutium);
            $em->flush();

            return $this->redirectToRoute( 'admin_barrutia_index' );
        }

        return $this->render('barrutia/new.html.twig', array(
            'barrutium' => $barrutium,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing barrutium entity.
     *
     * @Route("/{id}/edit", name="admin_barrutia_edit")
     * @Method({"GET", "POST"})
     * @param Request  $request
     * @param Barrutia $barrutium
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Barrutia $barrutium)
    {
        $deleteForm = $this->createDeleteForm($barrutium);
        $editForm = $this->createForm('AppBundle\Form\BarrutiaType', $barrutium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_barrutia_edit', array('id' => $barrutium->getId()));
        }

        return $this->render('barrutia/edit.html.twig', array(
            'barrutium' => $barrutium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a barrutium entity.
     *
     * @Route("/{id}", name="admin_barrutia_delete")
     * @Method("DELETE")
     * @param Request  $request
     * @param Barrutia $barrutium
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Barrutia $barrutium)
    {
        $form = $this->createDeleteForm($barrutium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($barrutium);
            $em->flush();
        }

        return $this->redirectToRoute('admin_barrutia_index');
    }

    /**
     * Creates a form to delete a barrutium entity.
     *
     * @param Barrutia $barrutium The barrutium entity
     *
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Barrutia $barrutium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_barrutia_delete', array('id' => $barrutium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
