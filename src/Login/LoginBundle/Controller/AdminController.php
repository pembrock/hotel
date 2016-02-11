<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 11.02.2016
 * Time: 23:06
 */

namespace Login\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Login\LoginBundle\Entity\Users;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LoginLoginBundle:Users');
        $session = new Session();
        if($session->has('login')){
            $login = $session->get('login');
            $email = $login->getEmail();
            $password = $login->getPassword();
            $user = $repository->findOneBy(array('email' => $email, 'password' => $password));
            if ($user) {
                //return $this->render('LoginLoginBundle:Pages:login.html.twig', array('name' => $user->getName()));
                return $this->render('LoginLoginBundle:Pages:index.html.twig', array('userName' => $user->getName()));
            }
        }
        else
            return $this->redirectToRoute('login_login_homepage');
    }
}