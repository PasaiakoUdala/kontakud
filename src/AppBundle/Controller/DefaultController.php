<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Barrutia;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction( Request $request )
    {
        return $this->redirectToRoute( 'admin_arreta_index' );
    }

    /**
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function barrutiaAction( Request $request )
    {
        $data = array();
        $form = $this->createFormBuilder( $data )
                     ->add( 'barrutia', EntityType::class, array(
                         'label'     => 'frm.barrutia.non.zaude',
                         'choice_translation_domain' => 'messages',
                         'placeholder' => 'Aukeratu...',
                         'required' => true,
                         'class' => 'AppBundle:Barrutia',
                     ) )
                     ->add('Onartu eta sartu', SubmitType::class, array(
                         'label'     => 'frm.barrutia.onartu',

                     ) )
                     ->getForm();

        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();

            $user = $this->getUser();

            $barrutiaid = $form[ "barrutia" ]->getData()->getId();

            $em = $this->getDoctrine()->getManager();
            $barrutia = $em->getRepository( 'AppBundle:Barrutia' )->find( $barrutiaid );
            if ($barrutia) {
                $user->setBarrutia( $barrutia );
                $em->persist( $user );
                $em->flush();
                return $this->redirectToRoute( 'homepage' );
            }
        }

        return $this->render( 'default/choose_barrutia.html.twig', array(
            'form' => $form->createView(),
        ) );

    }


}
