<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MiscController extends Controller
{

    /**
     * @return Response
     * @Route("/{dbversion}/contact", name="contact")
     */
    public function startpageAction($dbversion){
        $twig_parameter = array(
            'type' => 'contact',
            'dbversion' => $dbversion
        );
        return $this->render('misc/contact.html.twig', $twig_parameter);
    }
}
