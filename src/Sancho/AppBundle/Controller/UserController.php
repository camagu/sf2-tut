<?php

namespace Sancho\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sancho\AppBundle\Entity\User;
use Sancho\AppBundle\Form\UserRegistrationType;

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
            $encoder = $this->get('security.encoder_factory')
                ->getEncoder($entity);

            $password = $encoder->encodePassword($entity->getPlainPassword(), $entity->getSalt());
            $entity->setPassword($password);

            $em = $this->getDoctrine()
                ->getManager();

            $em->persist($entity);
            $em->flush();

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
