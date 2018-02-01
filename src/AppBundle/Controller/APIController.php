<?php

namespace AppBundle\Controller;

use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\API\Listing;
use AppBundle\API\Details;
use AppBundle\API\Delete;
use AppBundle\API\Upload;
use AppBundle\API\Mapping;
use AppBundle\API\Edit;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends Controller
{
    /**
     * List organisms.
     * You can provide a case-insensitive part of the scientific name or provide a limit.
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of organisms"
     * )
     * @SWG\Parameter(
     *     name="search",
     *     in="query",
     *     type="string",
     *     description="search term, part of the scientific name (case insensitive)"
     * )
     * @SWG\Parameter(
     *     name="limit",
     *     in="query",
     *     type="integer",
     *     description="max number of organisms to return"
     * )
     * @SWG\Tag(name="Listing")
     *
     * @Route("/api/listing/organisms/", name="api_listing_organisms", options={"expose"=true}, methods={"GET"})
     */
    public function listingOrganismsAction(Request $request){
        $organisms = $this->container->get(Listing\Organisms::class);
        $result = $organisms->execute($request->query->get('limit'), "%".$request->query->get('search')."%");
        return $this->createResponse($result);
    }

    /**
     * @param Request $request
     * @return Response $response
     * @Route("/api/listing/traits", name="api_listing_traits", options={"expose"=true})
     */
    public function listingTraitsAction(Request $request){
        $traits = $this->container->get(Listing\Traits::class);
        $result = $traits->execute($request->query->get('limit'), "%".$request->query->get('search')."%");
        return $this->createResponse($result);
    }

    /**
     * @param Request $request
     * @return Response $response
     * @Route("/api/details/traitEntries/", name="api_details_trait_entries", options={"expose"=true})
     */
    public function detailsTraitEntriesAction(Request $request){
        $traitEntries = $this->container->get(Details\TraitEntries::class);
        $result = $traitEntries->execute($request->query->get('trait_entry_ids'), $request->query->get('trait_format'));
        return $this->createResponse($result);
    }

    /**
     * @return Response $response
     * @Route("/api/listing/projects/", name="api_listing_projects", options={"expose"=true})
     */
    public function listingProjectsAction(){
        $projects = $this->container->get(Listing\Projects::class);
        $user = $this->getFennecUser();
        $result = $projects->execute($user);
        return $this->createResponse($result);
    }

    /**
     * @param Request $request
     * @return Response $response
     * @Route("/api/delete/projects/", name="api_delete_projects", options={"expose"=true})
     */
    public function deleteProjectsAction(Request $request){
        $projectId = $request->query->get('projectId');
        $deleteProjects = $this->container->get(Delete\Projects::class);
        $user = $this->getFennecUser();
        $result = $deleteProjects->execute($user, $projectId);
        return $this->createResponse($result);
    }

    /**
     * @param Request $request
     * @return Response $response
     * @Route("/api/upload/projects/", name="api_upload_projects", options={"expose"=true})
     */
    public function uploadProjectsAction(Request $request){
        $uploadProjects = $this->container->get(Upload\Projects::class);
        $user = $this->getFennecUser();
        $result = $uploadProjects->execute($user);
        return $this->createResponse($result);
    }

    /**
     * @param Request $request
     * @return Response $response
     * @Route("/api/details/traitsOfOrganisms/", name="api_details_traits_of_organisms", options={"expose"=true})
     */
    public function detailsTraitsOfOrganismsAction(Request $request){
        $traitDetails = $this->container->get(Details\TraitsOfOrganisms::class);
        $result = $traitDetails->execute($request->query->get('fennecIds'));
        return $this->createResponse($result);
    }

    /**
     * @param Request $request
     * @return Response $response
     * @Route("/api/details/traitOfProject/", name="api_details_trait_of_project", options={"expose"=true})
     */
    public function detailsTraitOfProjectAction(Request $request){
        $traitDetails = $this->container->get(Details\TraitOfProject::class);
        $result = $traitDetails->execute($request->query->get('fennecIds'));
        return $this->createResponse($result);
    }

    /**
     * @param Request $request
     * @return Response $response
     * @Route("/api/edit/updateProject/", name="api_edit_update_project", options={"expose"=true})
     */
    public function editUpdateProjectAction(Request $request){
        $updateProjects = $this->container->get(Edit\UpdateProject::class);
        $user = $this->getFennecUser();
        $result = $updateProjects->execute($request->query->get('projectId'), $request->query->get('biom'), $user);
        return $this->createResponse($result);
    }

    /**
     * @param Request $request
     * @return Response $response
     * @Route("/api/mapping/byDbxrefId/", name="api_mapping_byDbxrefId", options={"expose"=true})
     */
    public function mappingByDbxrefIdAction(Request $request){
        $mapping = $this->container->get(Mapping\ByDbxrefId::class);
        $result = $mapping->execute($request->query->get('ids'), $request->query->get('db'));
        return $this->createResponse($result);
    }

    /**
     * @param Request $request
     * @return Response $response
     * @Route("/api/mapping/byOrganismName/", name="api_mapping_byOrganismName", options={"expose"=true})
     */
    public function mappingByOrganismNameAction(Request $request){
        $mapping = $this->container->get(Mapping\ByOrganismName::class);
//        if(!$query->has('ids') || !is_array($query->get('ids')) || count($query->get('ids')) === 0 || !$query->has('db')){
//            return array();
//        }
        $result = $mapping->execute($request->query->get('ids'));
        return $this->createResponse($result);
    }

    /**
     * @param Request $request
     * @return Response $response
     * @Route("/api/listing/scinames/", name="api_listing_scinames", options={"expose"=true})
     */
    public function listingScinamesAction(Request $request){
        $listingScinames = $this->container->get(Listing\Scinames::class);
        $result = $listingScinames->execute($request->query->get('ids'));
        return $this->createResponse($result);
    }

    private function getFennecUser(){
        $user = null;
        if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            $user = $this->get('security.token_storage')->getToken()->getUser();
        }
        return $user;
    }

    private function createResponse($result){
        $response = $this->json($result);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}
