<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Group;
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
 * @Route("/groups", name="groups")
 */
class GroupController extends Controller
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
     * @Route("/", name="groups_index")
     * @Method("GET")
     * @return Response
     */
    public function indexAction()
    {
        $entities = $this->userRepo->findAll();       

        return new Response($this->serializer->serialize($entities, 'json'));
    }

    /**
     * @param Request $request
     * @Route("/create", name="groups_create")
     * @return Response
     */
    public function createAction(Request $request)
    {
        
        $entity = $this->serializer->deserialize($request->getContent(), Group::class, 'json');
        $this->em->persist($entity);
        $this->em->flush($entity);        
        
        return new Response();
    }

    /**
     * @param Group $group
     * @return Response
     * @Route("/{id}", name="groups_show")
     */
    public function showAction(Group $group)
    {
       
        $entity = $this->serializer->serialize($group, 'json');
        return new Response($entity);
    }
    /**
     * @param Request $request
     * @return Response
     * @Route("/{id}/modify", name="groups_modify")
     */
    public function updateAction(Request $request)
    {
        $entity = $this->serializer->deserialize($request->getContent(), Group::class, 'json');
        $this->em->persist($entity);
        $this->em->flush($entity);
        return new Response();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->userRepo = $this->getDoctrine()->getRepository('AppBundle:Group');
        $this->serializer = $this->get('jms_serializer');

        $this->em = $this->getDoctrine()->getEntityManager();
    }
}
