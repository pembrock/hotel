<?php

namespace Login\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Login\LoginBundle\Entity\Users;

class DefaultController extends Controller {

    public function indexAction(Request $request) {
        if ($request->getMethod() == "POST") {
            $login = $request->get('login');
            $password = $request->get('password');

            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('LoginLoginBundle:Users');
            $user = $repository->findOneBy(array('login' => $login, 'password' => $password));
            if ($user) {
                return $this->render('LoginLoginBundle:Pages:login.html.twig', array('name' => $user->getName()));
            }
        } else {
            return $this->render('LoginLoginBundle:Pages:login.html.twig');
        }
    }

}
