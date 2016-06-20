<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializationContext;

/**
 * @Route("/groups", name="groups")
 */
class GroupController extends Controller
{

    /**
     * @Route("/", name="groups_index")
     * @Method("GET")
     * @return JsonResponse
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Group');
        $serializer = $this->get('jms_serializer');

        $entities = $repository->findAll();

        return $this->sendResponse($serializer->serialize($entities, 'json', SerializationContext::create()->setGroups(array('list'))));
    }

    /**
     * @param Request $request
     * @Route("/create", name="groups_create")
     * @return JsonResponse
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        
        $entity = $serializer->deserialize($request->getContent(), Group::class, 'json');
        $em->persist($entity);
        $em->flush();
        
        return $this->sendResponse(null, 201, array(), false);
    }

    /**
     * @param Group $group
     * @return JsonResponse
     * @Route("/{id}", name="groups_show")
     * @Method("GET")
     */
    public function showAction(Group $group)
    {
        $serializer = $this->get('jms_serializer');

        $entity = $serializer->serialize($group, 'json', SerializationContext::create()->setGroups(array('list')));
        return $this->sendResponse($entity);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/{id}/modify", name="groups_modify")
     * @Method({"PUT", "PATCH"})
     */
    public function updateAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();

        $entity = $serializer->deserialize($request->getContent(), Group::class, 'json');
        $em->persist($entity);
        $em->flush();
        return $this->sendResponse(null, 200, array(), false);
    }

    private function sendResponse($data = null, $status = 200, $headers = array(), $json = true)
    {
        return new JsonResponse($data, $status, $headers, $json);
    }
}
