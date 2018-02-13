<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tramite;
use JMS\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tramite controller.
 *
 * @Route("admin/tramite")
 */
class TramiteController extends Controller
{
    /**
     * Lists all tramite entities.
     *
     * @Route("/", name="admin_tramite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tramites = $em->getRepository('AppBundle:Tramite')->findAll();

        return $this->render('tramite/index.html.twig', array(
            'tramites' => $tramites,
        ));
    }

    /**
     * Creates a new tramite entity.
     *
     * @Route("/new/{arretaid}", name="admin_tramite_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @param         $arretaid
     *
     * @return Response|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, $arretaid)
    {
        $em = $this->getDoctrine()->getManager();
        $arreta = $em->getRepository( 'AppBundle:Arreta' )->find( $arretaid );
        if (!$arreta) {
            throw $this->createNotFoundException();
        }
        $tramite = new Tramite();
        $tramite->setArreta( $arreta );
        $form = $this->createForm('AppBundle\Form\TramiteType', $tramite, [
            'action' => $this->generateUrl('admin_tramite_new', array('arretaid' => $arretaid)),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tramite);
            $em->flush();

            $serializer = $this->container->get('jms_serializer');
            $reports = $serializer->serialize($tramite, 'json');
            return new Response($reports); // should be $reports as $doctrineobject is not serialized

        } else if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tramite);
            $em->flush();

//            return $this->redirectToRoute('admin_arreta_edit', array('id' => $arreta->getId()), ['_fragment' => 'tramites']);
//            return $this->redirectToRoute(
//                $this->get('router')->generate('admin_arreta_edit', [
//                    '_fragment' => 'page'
//                ])
//            );
            return $this->redirect($this->generateUrl('admin_arreta_edit', array('id' => $arreta->getId())) . '#tramites');
        }

        return $this->render('tramite/new.html.twig', array(
            'tramite' => $tramite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tramite entity.
     *
     * @Route("/{id}", name="admin_tramite_show")
     * @Method("GET")
     */
    public function showAction(Tramite $tramite)
    {
        $deleteForm = $this->createDeleteForm($tramite);

        return $this->render('tramite/show.html.twig', array(
            'tramite' => $tramite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tramite entity.
     *
     * @Route("/{id}/edit", options={"expose"=true}, name="admin_tramite_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Tramite $tramite
     *
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Tramite $tramite)
    {
        $deleteForm = $this->createDeleteForm($tramite);
        $editForm = $this->createForm('AppBundle\Form\TramiteType', $tramite, [
            'action' => $this->generateUrl('admin_tramite_edit', array( 'id' => $tramite->getId())),
            'method' => 'POST'
        ]);
        $editForm->handleRequest($request);

        if($request->isXmlHttpRequest()) {
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(array('message' => 'Success!', 'tramite' =>json_encode($tramite)), 200);
        } else if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_tramite_edit', array('id' => $tramite->getId()));
        }

        return $this->render('tramite/edit.html.twig', array(
            'tramite' => $tramite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tramite entity.
     *
     * @Route("/{id}", name="admin_tramite_delete",  options = { "expose" = true })
     * @Method("DELETE")
     * @param Request $request
     * @param Tramite $tramite
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function deleteAction(Request $request, Tramite $tramite)
    {
        $form = $this->createDeleteForm($tramite);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tramite);
            $em->flush();


            return new JsonResponse(array('message' => 'Success!'), 200);

        } else if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tramite);
            $em->flush();
        }

        return $this->redirectToRoute('admin_tramite_index');
    }

    /**
     * Creates a form to delete a tramite entity.
     *
     * @param Tramite $tramite The tramite entity
     *
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Tramite $tramite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_tramite_delete', array('id' => $tramite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
