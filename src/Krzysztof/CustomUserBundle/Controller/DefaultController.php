<?php

namespace Krzysztof\CustomUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Krzysztof\CustomUserBundle\Form\Type\CustomUserType;
use Krzysztof\CustomUserBundle\Form\Model\Registration;
use Krzysztof\CustomUserBundle\Entity\CustomUser;


class DefaultController extends Controller
{
    public function registerAction()
    {
        $user = new CustomUser();
        $form = $this->createForm(new CustomUserType(), array('action' => $this->generateUrl('account_create'), 'user' => $user));

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            $data = $form->getData();

            if ($form->isValid()) {
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($data['password'], null);
                $user->setUsername($data['username']);
                $user->setPassword($password);
                $user->setEmail(($user->getUsername() . "@mail"));
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($user);
                $em->flush();
                return $this->redirect("http://localhost:8000/app_dev.php/customuser/Tina");
            }
        }

        return $this->render(
            'KrzysztofCustomUserBundle:Account:register.html.twig',
            array('form' => $form->createView())
        );
    }

    public function indexAction($name)
    {
        return $this->render('KrzysztofCustomUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
