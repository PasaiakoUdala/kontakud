<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Arreta;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Arretum controller.
 *
 * @Route("admin/arreta")
 */
class ArretaController extends Controller
{
    /**
     * Lists all arretum entities.
     *
     * @Route("/", name="admin_arreta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $this->getUser();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $arretas = $em->getRepository('AppBundle:Arreta')->findBy(
                array(),
                array('id' => 'desc')
            );
        } else {
            $arretas = $em->getRepository('AppBundle:Arreta')->findMyAll($user->getId());
        }

        $deleteForms = array();
        foreach ($arretas as $a) {
            $deleteForms[$a->getId()] = $this->createDeleteForm($a)->createView();
        }

        return $this->render('arreta/index.html.twig', array(
            'arretas' => $arretas,
            'deleteforms' => $deleteForms,
        ));
    }

    /**
     * Arreta bilatzeila filtrokin
     *
     * @Route("/bilatu", name="admin_arreta_find")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function findAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $hasi = $request->request->get('data_hasi');
        $fin = $request->request->get('data_amaitu');
        $egoera = $request->request->get('egoera');


        $arretas = $em->getRepository( 'AppBundle:Arreta' )->bilatzailea( $hasi, $fin, $egoera );

        $deleteForms = array();
        foreach ($arretas as $a) {
            $deleteForms[$a->getId()] = $this->createDeleteForm($a)->createView();
        }

        return $this->render('arreta/index.html.twig', array(
            'arretas' => $arretas,
            'deleteforms' => $deleteForms,
        ));
    }

    /**
     * Creates a new arretum entity.
     *
     * @Route("/new", name="admin_arreta_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $arreta = new Arreta();
        $arreta->setUser( $user );
        $arreta->setFetxa( new \DateTime() );
        $arreta->setSacbarrutia( $user->getBarrutia() );
        $em->persist( $arreta );
        $em->flush();


        return $this->redirectToRoute( 'admin_arreta_edit', array( 'id' => $arreta->getId()) );
    }

    /**
     * Finds and displays a arretum entity.
     *
     * @Route("/{id}", name="admin_arreta_show")
     * @Method("GET")
     * @param Arreta $arretum
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Arreta $arretum)
    {
        $deleteForm = $this->createDeleteForm($arretum);

        return $this->render('arreta/show.html.twig', array(
            'arretum' => $arretum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing arretum entity.
     *
     * @Route("/{id}/edit", name="admin_arreta_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Arreta  $arretum
     *
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Arreta $arretum)
    {
        $deleteForm = $this->createDeleteForm($arretum);
        $editForm = $this->createForm('AppBundle\Form\ArretaType', $arretum, [
            'action' => $this->generateUrl('admin_arreta_edit', array( 'id' => $arretum->getId())),
            'method' => 'POST'
        ]);
        $editForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository( 'AppBundle:Result' )->findAll();

        if($request->isXmlHttpRequest()) {
            //$this->getDoctrine()->getManager()->flush();
            $amaia = $arretum->getAmaitu();
            if ( !isset($amaia) && ($arretum->getIsclosed()==true) ) {
                $arretum->setAmaitu( new \DateTime() );
            }
            $em->persist( $arretum );
            $em->flush();

            return new JsonResponse(array('message' => 'Success!'), 200);
        } else if ($editForm->isSubmitted() && $editForm->isValid()) {

            $amaia = $arretum->getAmaitu();
            if ( !isset($amaia) && ($arretum->getIsclosed()==true) ) {
                $arretum->setAmaitu( new \DateTime() );
            }
            $em->persist( $arretum );
            $em->flush();

            return $this->redirectToRoute('admin_arreta_index');
        }

        return $this->render('arreta/edit.html.twig', array(
            'arreta' => $arretum,
            'results'=> $results,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a arretum entity.
     *
     * @Route("/{id}", name="admin_arreta_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Arreta  $arretum
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Arreta $arretum)
    {
        $form = $this->createDeleteForm($arretum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($arretum);
            $em->flush();
        }

        return $this->redirectToRoute('admin_arreta_index');
    }

    /**
     * Creates a form to delete a arretum entity.
     *
     * @param Arreta $arretum The arretum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Arreta $arretum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_arreta_delete', array('id' => $arretum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
