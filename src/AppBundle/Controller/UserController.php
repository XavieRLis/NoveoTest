<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @Route("/users", name="users")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="users_index")
     * @Method("GET")
     * @return JsonResponse
     */
    public function indexAction()
    {
        $serializer = $this->get('jms_serializer');
        $repository =  $this->getDoctrine()->getRepository('AppBundle:User');
        $entities = $repository->findAll();       

        return $this->sendResponse($serializer->serialize($entities, 'json'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/create", name="users_create") 
     * @Method("POST")    
     */
    public function createAction(Request $request)
    {
        $em  = $this->getDoctrine()->getManager();
        $serializer = $this->get('jms_serializer');

        $entity = $serializer->deserialize($request->getContent(), User::class, 'json');

        $em->persist($entity);
        $em->flush();
        
        return $this->sendResponse();
    }

    /**
     * @param User $user
     * @return JsonResponse
     * @Route("/{id}", name="users_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $serializer = $this->get('jms_serializer');
        $entity = $serializer->serialize($user, 'json');
        return $this->sendResponse($entity);
    }
    /**
     * @param Request $request 
     * @return JsonResponse
     * @Route("/{id}/modify", name="users_modify")
     * @Method({"PUT", "PATCH"})
     */
    public function updateAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $em  = $this->getDoctrine()->getManager();
        
        $entity = $serializer->deserialize($request->getContent(), User::class, 'json');
        $em->persist($entity);
        $em->flush();
        
        return $this->sendResponse();
    }
    
    private function sendResponse($data = null, $status = 200, $headers = array(), $json = true)
    {
        return new JsonResponse($data, $status, $headers, $json);
    }
}
