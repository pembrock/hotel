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
                $newUser = new Users();
                $newUser->setLogin("pembrock@gmail.com");
                $newUser->setPassword(md5("12345"));
                $newUser->setName("Pembrock");
                $em->persist($newUser);
                $em->flush();
                
                return $this->render('LoginLoginBundle:Pages:login.html.twig', array('name' => $user->getName()));
            }
                return $this->render('LoginLoginBundle:Pages:login.html.twig');
        } else {
            return $this->render('LoginLoginBundle:Pages:login.html.twig');
        }
    }

}
