<?php

namespace Login\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Login\LoginBundle\Entity\Users;
use Login\LoginBundle\Modals\Login;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller {

    public function indexAction(Request $request) {

        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LoginLoginBundle:Users');

        if ($request->getMethod() == "POST") {
            $session->clear();
            $email = $request->get('email');
            $password = $request->get('password');
            $remember = $request->get('remember');


            $user = $repository->findOneBy(array('email' => $email, 'password' => $password));
            if ($user) {
                if ($remember == 'remember-me')
                {
                    $login = new Login();
                    $login->setEmail($email);
                    $login->setPassword($password);
                    $session->set('login', $login);

                }
                return $this->redirectToRoute('admin_admin_homepage');
            }
                return $this->render('LoginLoginBundle:Pages:login.html.twig');
        } else {

            if($session->has('login')){
                $login = $session->get('login');
                $email = $login->getEmail();
                $password = $login->getPassword();
                $user = $repository->findOneBy(array('email' => $email, 'password' => $password));
                if ($user) {
                    //return $this->render('LoginLoginBundle:Pages:login.html.twig', array('name' => $user->getName()));
                    return $this->redirectToRoute('admin_admin_homepage');
                }
            }

            return $this->render('LoginLoginBundle:Pages:login.html.twig');
        }
    }

    public function logoutAction(Request $request){
        $session = new Session();
        $session->clear();
        return $this->render('LoginLoginBundle:Pages:login.html.twig');
    }
}
