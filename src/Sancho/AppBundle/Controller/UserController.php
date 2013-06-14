<?php

namespace Sancho\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sancho\AppBundle\Entity\User;
use Sancho\AppBundle\Form\UserRegistrationType;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserController extends Controller
{
    /**
     * @Route("/signup")
     * @Method("GET")
     * @Template
     */
    public function newAction()
    {
        $entity = new User();
        $form = $this->createForm(new UserRegistrationType(), $entity);

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/signup")
     * @Method("POST")
     * @Template("SanchoAppBundle:User:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new User();
        $form = $this->createForm(new UserRegistrationType(), $entity);

        $form->bind($request);
        if ($form->isValid()) {
            $userManager = $this->get('sancho_app.user_manager');
            $userManager->createUser($entity);

            $token = new UsernamePasswordToken($entity, null, 'main', array('ROLE_USER'));
            $this->get('security.context')->setToken($token);

            $this->get('session')->getFlashBag()->add('success', 'Welcome to the Sample App!');
            return $this->redirect($this->generateUrl('sancho_app_user_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("users/{id}")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SanchoAppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return array('entity' => $entity);
    }
}
