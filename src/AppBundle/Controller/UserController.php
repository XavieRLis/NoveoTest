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
     * @var EntityRepository
     */
    private $userRepo;
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @Route("/", name="users_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $entities = $this->userRepo->findAll();       

        return new Response($this->serializer->serialize($entities, 'json'));
    }

    /**
     * @Route("/create", name="users_create")     
     */
    public function createAction(Request $request)
    {
        
        $entity = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $this->em->persist($entity);
        $this->em->flush($entity);        
        
        return new Response();
    }

    /**
     * @param User $user
     * @return Response
     * @Route("/{id}", name="users_show")
     */
    public function showAction(User $user)
    {
       
        $entity = $this->serializer->serialize($user, 'json');
        return new Response($entity);
    }
    /**
     * @param User $user
     * @return Response
     * @Route("/{id}/modify", name="users_modify")
     */
    public function updateAction(Request $request, User $user)
    {

        
        $entity = $this->serializer->deserialize($request->getContent(), User::class, 'json');         
        $this->em->persist($entity);
        $this->em->flush($entity);
        return new Response();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->userRepo = $this->getDoctrine()->getRepository('AppBundle:User');
        $this->serializer = $this->get('jms_serializer');

        $this->em = $this->getDoctrine()->getEntityManager();
    }
}
