<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/groups", name="groups")
 */
class GroupController extends Controller
{

    /**
     * @Route("/", name="groups_index")
     * @Method("GET")
     * @return Response
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Group');
        $serializer = $this->get('jms_serializer');

        $entities = $repository->findAll();

        return new Response($serializer->serialize($entities, 'json'));
    }

    /**
     * @param Request $request
     * @Route("/create", name="groups_create")
     * @return Response
     */
    public function createAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        
        $entity = $serializer->deserialize($request->getContent(), Group::class, 'json');
        $em->persist($entity);
        $em->flush();
        
        return new Response();
    }

    /**
     * @param Group $group
     * @return Response
     * @Route("/{id}", name="groups_show")
     */
    public function showAction(Group $group)
    {
        $serializer = $this->get('jms_serializer');

        $entity = $serializer->serialize($group, 'json');
        return new Response($entity);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/{id}/modify", name="groups_modify")
     */
    public function updateAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();

        $entity = $serializer->deserialize($request->getContent(), Group::class, 'json');
        $em->persist($entity);
        $em->flush();
        return new Response();
    }
}
