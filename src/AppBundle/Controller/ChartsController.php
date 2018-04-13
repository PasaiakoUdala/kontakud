<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
        return $this->render( 'grafikak/index.html.twig' );
    }
}
