<?php

namespace Login\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $login = "test";
        $password = "test";
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LoginLoginBundle:Users');
        $user = $repository->findOneBy(array('login' => $login, 'password' => $password));
        if ($user) {
            return $this->render('LoginLoginBundle:Pages:login.html.twig', array('name' => $user->getName()));
        }
        else{
            return $this->render('LoginLoginBundle:Pages:index.html.twig', array('name' => "Login failed"));
        }
    }
}
