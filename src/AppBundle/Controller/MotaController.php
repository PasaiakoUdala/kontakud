<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mota;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Motum controller.
 *
 * @Route("admin/mota")
 */
class MotaController extends Controller
{
    /**
     * Lists all motum entities.
     *
     * @Route("/", name="admin_mota_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $motas = $em->getRepository('AppBundle:Mota')->findAll();

        return $this->render('mota/index.html.twig', array(
            'motas' => $motas,
        ));
    }

    /**
     * Creates a new motum entity.
     *
     * @Route("/new", name="admin_mota_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $motum = new Mota();
        $form = $this->createForm('AppBundle\Form\MotaType', $motum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($motum);
            $em->flush();

            return $this->redirectToRoute('admin_mota_show', array('id' => $motum->getId()));
        }

        return $this->render('mota/new.html.twig', array(
            'motum' => $motum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a motum entity.
     *
     * @Route("/{id}", name="admin_mota_show")
     * @Method("GET")
     */
    public function showAction(Mota $motum)
    {
        $deleteForm = $this->createDeleteForm($motum);

        return $this->render('mota/show.html.twig', array(
            'motum' => $motum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing motum entity.
     *
     * @Route("/{id}/edit", name="admin_mota_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Mota $motum)
    {
        $deleteForm = $this->createDeleteForm($motum);
        $editForm = $this->createForm('AppBundle\Form\MotaType', $motum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_mota_edit', array('id' => $motum->getId()));
        }

        return $this->render('mota/edit.html.twig', array(
            'motum' => $motum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a motum entity.
     *
     * @Route("/{id}", name="admin_mota_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Mota $motum)
    {
        $form = $this->createDeleteForm($motum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($motum);
            $em->flush();
        }

        return $this->redirectToRoute('admin_mota_index');
    }

    /**
     * Creates a form to delete a motum entity.
     *
     * @param Mota $motum The motum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Mota $motum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_mota_delete', array('id' => $motum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
