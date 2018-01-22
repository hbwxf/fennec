<?php

namespace AppBundle\Controller;

use AppBundle\API\Listing;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

class StartpageController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $default_db = $this->getParameter('dbal')['default_connection'];
        return $this->redirectToRoute('startpage', array('dbversion' => $default_db));
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/startpage", name="startpage")
     */
    public function startpageAction(Request $request, $dbversion){
        $oc = $this->container->get(Listing\Overview::class);
        $query = $request->query;
        $query->set('dbversion', $dbversion);
        $user = null;
        if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            $user = $this->get('security.token_storage')->getToken()->getUser();
        }
        $overview = $oc->execute($query, $user);
        $title = "Welcome";
        if($user !== null){
            $title .= " ".$user->getUsername();
        }
        $twig_parameter = array(
            'type' => 'startpage',
            'overview' => $overview,
            'title' => $title,
            'dbversion' => $dbversion
        );
        return $this->render('startpage/index.html.twig', $twig_parameter);
    }
}
