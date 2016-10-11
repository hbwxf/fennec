<?php

namespace AppBundle\Controller;

use AppBundle\Controller\API\Listing\OverviewController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

class StartpageController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)
    {
        $default_db = $this->getParameter('default_db');
        return $this->redirectToRoute('startpage', array('dbversion' => $default_db));
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/{dbversion}/startpage", name="startpage")
     */
    public function startpageAction(Request $request, $dbversion){
        $oc = $this->get('app.api.listing.overview');
        $overview = $oc->execute($dbversion, $request->getSession());
        $twig_parameter = array(
            'type' => 'startpage',
            'overview' => $overview,
            'title' => 'Welcome',
            'dbversion' => $dbversion
        );
        if($request->hasSession()){
            $session = $request->getSession();
            if($session->has('user') && array_key_exists('nickname', $session->get('user'))){
                $twig_parameter['user'] = $session->get('user')['nickname'];
            }
        }
        return $this->render('startpage/index.html.twig', $twig_parameter);
    }
}
