<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Arreta;
use AppBundle\Entity\Tramite;
use AppBundle\Form\searchFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Kanala controller.
 *
 * @Route("admin/grafikak")
 */
class ChartsController extends Controller
{
    /**
     * @Route("/", name="welcome")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction( Request $request )
    {
        $em = $this->getDoctrine()->getManager();


        $form = $this->createForm( 'AppBundle\Form\searchFormType', null, array(
            'action' => $this->generateUrl( 'welcome' ),
            'method' => 'GET',
        ) );

        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {

            $data    = $form->getData();
            $arretak = $em->getRepository( 'AppBundle:Arreta' )->findAllByFilterForm( $data );


        }

        $arretak            = $em->getRepository( 'AppBundle:Arreta' )->findAll();
        $arretakDonibane    = array_filter( $arretak, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getBarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getBarrutia() ), 'DON' ) !== false );
            }
        } );
        $arretakAntxo       = array_filter( $arretak, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getBarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getBarrutia() ), 'ANT' ) !== false );
            }
        } );
        $arretakTrintxerpte = array_filter( $arretak, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getBarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getBarrutia() ), 'TRIN' ) !== false );
            }
        } );


        $tramiteak           = $em->getRepository( 'AppBundle:Tramite' )->findAll();
        $tramiteakDonibane   = array_filter( $tramiteak, function ( $tramite ) {
            /** @var Tramite $tramite */
            if ( $tramite->getArreta() !== null ) {
                if ( $tramite->getArreta()->getBarrutia() !== null ) {
                    return ( strpos( strtoupper( $tramite->getArreta()->getBarrutia() ), 'DON' ) !== false );
                }
            }
        } );
        $tramiteakAntxo      = array_filter( $tramiteak, function ( $tramite ) {
            /** @var Tramite $tramite */
            if ( $tramite->getArreta() !== null ) {
                if ( $tramite->getArreta()->getBarrutia() !== null ) {
                    return ( strpos( strtoupper( $tramite->getArreta()->getBarrutia() ), 'ANT' ) !== false );
                }
            }
        } );
        $tramiteakTrintxerpe = array_filter( $tramiteak, function ( $tramite ) {
            /** @var Tramite $tramite */
            if ( $tramite->getArreta() !== null ) {
                if ( $tramite->getArreta()->getBarrutia() !== null ) {
                    return ( strpos( strtoupper( $tramite->getArreta()->getBarrutia() ), 'TRIN' ) !== false );
                }
            }
        } );


        $arretaPresentzialak = array_filter( $arretak, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getKanala() !== null ) {
                return ( strpos( strtoupper( $arreta->getKanala()->getName() ), 'PRESE' ) !== false );
            }
        } );

        $arretaPresentzialakDonibane = array_filter( $arretaPresentzialak, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getBarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getBarrutia() ), 'DON' ) !== false );
            }
        } );

        $arretaPresentzialakAntxo = array_filter( $arretaPresentzialak, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getBarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getBarrutia() ), 'ANT' ) !== false );
            }
        } );

        $arretaPresentzialakTrintxerpe = array_filter( $arretaPresentzialak, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getBarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getBarrutia() ), 'TRIN' ) !== false );
            }
        } );


        $arretaTelefonoz = array_filter( $arretak, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getKanala() !== null ) {
                return ( strpos( strtoupper( $arreta->getKanala()->getName() ), 'TELE' ) !== false );
            }
        } );

        $arretaTelefonozDonibane = array_filter( $arretaTelefonoz, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getBarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getBarrutia() ), 'DON' ) !== false );
            }
        } );

        $arretaTelefonozAntxo = array_filter( $arretaTelefonoz, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getBarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getBarrutia() ), 'ANT' ) !== false );
            }
        } );

        $arretaTelefonozTrintxerpe = array_filter( $arretaTelefonoz, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getBarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getBarrutia() ), 'TRIN' ) !== false );
            }
        } );


        $top = $em->getRepository( 'AppBundle:Tramite' )->topTramites();
        $topZerbikat = $em->getRepository( 'AppBundle:Tramite' )->topZerbikat();


        $users     = $em->getRepository( 'AppBundle:User' )->findAll();
        $kanalak   = $em->getRepository( 'AppBundle:Kanala' )->findAll();
        $barrutiak = $em->getRepository( 'AppBundle:Barrutia' )->findAll();

        return $this->render( 'grafikak/index.html.twig', array(
            'arretak'                       => $arretak,
            'arretakDonibane'               => count( $arretakDonibane ),
            'arretakAntxo'                  => count( $arretakAntxo ),
            'arretakTrintxerpte'            => count( $arretakTrintxerpte ),
            'tramiteak'                     => $tramiteak,
            'tramiteakDonibane'             => count( $tramiteakDonibane ),
            'tramiteakAntxo'                => count( $tramiteakAntxo ),
            'tramiteakTrintxerpe'           => count( $tramiteakTrintxerpe ),
            'arretaPresentzialak'           => count( $arretaPresentzialak ),
            'arretaPresentzialakDonibane'   => count( $arretaPresentzialakDonibane ),
            'arretaPresentzialakAntxo'      => count( $arretaPresentzialakAntxo ),
            'arretaPresentzialakTrintxerpe' => count( $arretaPresentzialakTrintxerpe ),
            'arretaTelefonoz'               => count( $arretaTelefonoz ),
            'arretaTelefonozDonibane'       => count( $arretaTelefonozDonibane ),
            'arretaTelefonozAntxo'          => count( $arretaTelefonozAntxo ),
            'arretaTelefonozTrintxerpe'     => count( $arretaTelefonozTrintxerpe ),
            'users'                         => $users,
            'kanalak'                       => $kanalak,
            'barrutiak'                     => $barrutiak,
            'top'                           => $top ,
            'topZerbikat'                           => $topZerbikat ,
            'form' => $form->createView(),
        ) );
    }


}
