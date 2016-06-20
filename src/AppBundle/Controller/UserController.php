<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/users", name="users")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="users_index")
     * @Method("GET")
     * @return Response
     */
    public function indexAction()
    {
        $serializer = $this->get('jms_serializer');
        $repository =  $this->getDoctrine()->getRepository('AppBundle:User');
        $entities = $repository->findAll();       

        return new Response($serializer->serialize($entities, 'json'));
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/create", name="users_create")     
     */
    public function createAction(Request $request)
    {
        $em  = $this->getDoctrine()->getManager();
        $serializer = $this->get('jms_serializer');

        $entity = $serializer->deserialize($request->getContent(), User::class, 'json');

        $em->persist($entity);
        $em->flush();
        
        return new Response();
    }

    /**
     * @param User $user
     * @return Response
     * @Route("/{id}", name="users_show")
     */
    public function showAction(User $user)
    {
        $serializer = $this->get('jms_serializer');
        $entity = $serializer->serialize($user, 'json');
        return new Response($entity);
    }
    /**
     * @param Request $request 
     * @return Response
     * @Route("/{id}/modify", name="users_modify")
     */
    public function updateAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $em  = $this->getDoctrine()->getManager();
        
        $entity = $serializer->deserialize($request->getContent(), User::class, 'json');
        $em->persist($entity);
        $em->flush();
        
        return new Response();
    }
}
