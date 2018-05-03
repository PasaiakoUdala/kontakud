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
            $tramiteak           = $em->getRepository( 'AppBundle:Tramite' )->findAllByFilterForm( $data );
            $top         = $em->getRepository( 'AppBundle:Tramite' )->topTramites($data);
            $topZerbikat = $em->getRepository( 'AppBundle:Tramite' )->topZerbikat($data);
            $ArretakGroupByMonth             = $em->getRepository( 'AppBundle:Arreta' )->findAllGroupByMonth($data);
            $TramiteakGroupByMonth           = $em->getRepository( 'AppBundle:Tramite' )->findAllGroupByMonth($data);
            $arretaPresentzialakGroupByMonth = $em->getRepository( 'AppBundle:Arreta' )->findAllPresentzialakGroupByMonth($data);
            $arretaTelefonozGroupByMonth     = $em->getRepository( 'AppBundle:Arreta' )->findAllTelefonozGroupByMonth($data);
        } else {
            $arretak            = $em->getRepository( 'AppBundle:Arreta' )->findAll();
            $tramiteak           = $em->getRepository( 'AppBundle:Tramite' )->findAll();
            $top         = $em->getRepository( 'AppBundle:Tramite' )->topTramites();
            $topZerbikat = $em->getRepository( 'AppBundle:Tramite' )->topZerbikat();
            $ArretakGroupByMonth             = $em->getRepository( 'AppBundle:Arreta' )->findAllGroupByMonth();
            $TramiteakGroupByMonth           = $em->getRepository( 'AppBundle:Tramite' )->findAllGroupByMonth();
            $arretaPresentzialakGroupByMonth = $em->getRepository( 'AppBundle:Arreta' )->findAllPresentzialakGroupByMonth();
            $arretaTelefonozGroupByMonth     = $em->getRepository( 'AppBundle:Arreta' )->findAllTelefonozGroupByMonth();

        }


        $arretakDonibane    = array_filter( $arretak, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getSacbarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getSacbarrutia() ), 'DON' ) !== false );
            }
        } );
        $arretakAntxo       = array_filter( $arretak, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getSacbarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getSacbarrutia() ), 'ANT' ) !== false );
            }
        } );
        $arretakTrintxerpte = array_filter( $arretak, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getSacbarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getSacbarrutia() ), 'TRIN' ) !== false );
            }
        } );

        $tramiteakDonibane   = array_filter( $tramiteak, function ( $tramite ) {
            /** @var Tramite $tramite */
            if ( $tramite->getArreta() !== null ) {
                if ( $tramite->getArreta()->getSacbarrutia() !== null ) {
                    return ( strpos( strtoupper( $tramite->getArreta()->getSacbarrutia() ), 'DON' ) !== false );
                }
            }
        } );
        $tramiteakAntxo      = array_filter( $tramiteak, function ( $tramite ) {
            /** @var Tramite $tramite */
            if ( $tramite->getArreta() !== null ) {
                if ( $tramite->getArreta()->getSacbarrutia() !== null ) {
                    return ( strpos( strtoupper( $tramite->getArreta()->getSacbarrutia() ), 'ANT' ) !== false );
                }
            }
        } );
        $tramiteakTrintxerpe = array_filter( $tramiteak, function ( $tramite ) {
            /** @var Tramite $tramite */
            if ( $tramite->getArreta() !== null ) {
                if ( $tramite->getArreta()->getSacbarrutia() !== null ) {
                    return ( strpos( strtoupper( $tramite->getArreta()->getSacbarrutia() ), 'TRIN' ) !== false );
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
            if ( $arreta->getSacbarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getSacbarrutia() ), 'DON' ) !== false );
            }
        } );
        $arretaPresentzialakAntxo = array_filter( $arretaPresentzialak, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getSacbarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getSacbarrutia() ), 'ANT' ) !== false );
            }
        } );
        $arretaPresentzialakTrintxerpe = array_filter( $arretaPresentzialak, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getSacbarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getSacbarrutia() ), 'TRIN' ) !== false );
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
            if ( $arreta->getSacbarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getSacbarrutia() ), 'DON' ) !== false );
            }
        } );
        $arretaTelefonozAntxo = array_filter( $arretaTelefonoz, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getSacbarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getSacbarrutia() ), 'ANT' ) !== false );
            }
        } );
        $arretaTelefonozTrintxerpe = array_filter( $arretaTelefonoz, function ( $arreta ) {
            /** @var Arreta $arreta */
            if ( $arreta->getSacbarrutia() !== null ) {
                return ( strpos( strtoupper( $arreta->getSacbarrutia() ), 'TRIN' ) !== false );
            }
        } );


        return $this->render( 'grafikak/index.html.twig', array(
            'arretak'                         => $arretak,
            'arretakDonibane'                 => count( $arretakDonibane ),
            'arretakAntxo'                    => count( $arretakAntxo ),
            'arretakTrintxerpte'              => count( $arretakTrintxerpte ),
            'tramiteak'                       => $tramiteak,
            'tramiteakDonibane'               => count( $tramiteakDonibane ),
            'tramiteakAntxo'                  => count( $tramiteakAntxo ),
            'tramiteakTrintxerpe'             => count( $tramiteakTrintxerpe ),
            'arretaPresentzialak'             => count( $arretaPresentzialak ),
            'arretaPresentzialakDonibane'     => count( $arretaPresentzialakDonibane ),
            'arretaPresentzialakAntxo'        => count( $arretaPresentzialakAntxo ),
            'arretaPresentzialakTrintxerpe'   => count( $arretaPresentzialakTrintxerpe ),
            'arretaTelefonoz'                 => count( $arretaTelefonoz ),
            'arretaTelefonozDonibane'         => count( $arretaTelefonozDonibane ),
            'arretaTelefonozAntxo'            => count( $arretaTelefonozAntxo ),
            'arretaTelefonozTrintxerpe'       => count( $arretaTelefonozTrintxerpe ),
//            'users'                           => $users,
//            'kanalak'                         => $kanalak,
//            'barrutiak'                       => $barrutiak,
            'top'                             => $top,
            'topZerbikat'                     => $topZerbikat,
            'ArretakGroupByMonth'             => $ArretakGroupByMonth,
            'TramiteakGroupByMonth'           => $TramiteakGroupByMonth,
            'arretaPresentzialakGroupByMonth' => $arretaPresentzialakGroupByMonth,
            'arretaTelefonozGroupByMonth'     => $arretaTelefonozGroupByMonth,
            'form'                            => $form->createView(),

        ) );
    }


}
