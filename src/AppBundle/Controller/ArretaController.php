<?php

namespace AppBundle\Controller;

use AppBundle\Datatables\ArretaDatatable;
use AppBundle\Entity\Arreta;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Sg\DatatablesBundle\Datatable\DatatableInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
     * @param Request $request
     *
     * @return Response
     * @throws \Exception
     */
    public function indexAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $isAjax = $request->isXmlHttpRequest();

        /** @var User $user */
        $user = $this->getUser();
        $arretakGaurDenak=[];

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $arretas = $em->getRepository( 'AppBundle:Arreta' )->findAllFetched();

            $users = $em->getRepository( 'AppBundle:User' )->findLangileak();
            $arretakGaur = $em->getRepository( 'AppBundle:Arreta' )->findGaurkoArretaKopurua();

        } else {
            $arretas = $em->getRepository('AppBundle:Arreta')->findMyAll($user->getId());
            $users = $em->getRepository( 'AppBundle:User' )->findLangileak($user->getId());
            $arretakGaur = $em->getRepository( 'AppBundle:Arreta' )->findGaurkoArretaKopurua($user->getId());
            $arretakGaurDenak = $em->getRepository( 'AppBundle:Arreta' )->findGaurkoArretaKopurua();
        }

        /** @var DatatableInterface $datatable */
        $datatable = $this->get('sg_datatables.factory')->create(ArretaDatatable::class);
        $datatable->buildDatatable();

        if ($isAjax) {
            $responseService = $this->get('sg_datatables.response');
            $responseService->setDatatable($datatable);

            $datatableQueryBuilder = $responseService->getDatatableQueryBuilder();

            /** @var \Doctrine\ORM\QueryBuilder $qb */
            $qb = $datatableQueryBuilder->getQb();

            if ( ! $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                $qb->andWhere('user.id = :userid');
                $qb->setParameter('userid', $user->getId());
            }


            return $responseService->getResponse();
        }


        $deleteForms = array();
        /** @var Arreta $a */
        foreach ($arretas as $a) {
            $deleteForms[$a->getId()] = $this->createDeleteForm($a)->createView();
        }


        return $this->render('arreta/index.html.twig', array(
            'arretas' => $arretas,
            'datatable' => $datatable,
            'deleteforms' => $deleteForms,
            'users' => $user,
            'arretakGaur' => $arretakGaur[0],
            'arretakGaurDenak' => $arretakGaurDenak,
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
     * @Route("/{id}/edit", name="admin_arreta_edit", options = {"expose" = true})
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
            'method' => 'POST',
        ]);
        $editForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository( 'AppBundle:Result' )->findAll();

        if($request->isXmlHttpRequest()) {
            //$this->getDoctrine()->getManager()->flush();
            $amaia = $arretum->getAmaitu();
            if ( !isset($amaia) && ($arretum->getIsclosed()==true) ) {
                $arretum->setAmaitu( new \DateTime() );
                $sec = strtotime($arretum->getAmaitu()->format("Y-m-d H:i:s")) - strtotime( $arretum->getCreated()->format('Y-m-d H:i:s')) ;
                $arretum->setSegunduak( $sec );
            }
            $em->persist( $arretum );
            $em->flush();

            return new JsonResponse(array('message' => 'Success!'), 200);
        } else if ($editForm->isSubmitted() && $editForm->isValid()) {

            $amaia = $arretum->getAmaitu();
            if ( !isset($amaia) && ($arretum->getIsclosed()==true) ) {
                $arretum->setAmaitu( new \DateTime() );
                $sec = strtotime($arretum->getAmaitu()->format("Y-m-d H:i:s")) - strtotime( $arretum->getCreated()->format('Y-m-d H:i:s')) ;
                $arretum->setSegunduak( $sec );
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
     * Bulk delete action.
     *
     * @param Request $request
     *
     * @Route("/bulk/delete", name="arreta_bulk_delete")
     * @Method("POST")
     *
     * @return Response
     */
    public function bulkDeleteAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();
        if ($isAjax) {
            $choices = $request->request->get('data');
            $token = $request->request->get('token');
            if (!$this->isCsrfTokenValid('multiselect', $token)) {
                throw new AccessDeniedException('The CSRF token is invalid.');
            }
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('AppBundle:Arreta');
            foreach ($choices as $choice) {
                $entity = $repository->find($choice['id']);
                $em->remove($entity);
            }
            $em->flush();
            return new Response('Success', 200);
        }
        return new Response('Bad Request', 400);
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
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
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
