<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 15.02.2016
 * Time: 21:26
 */

namespace Login\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class SecurityController extends Controller
{
    public $_commonOptions;

    protected function checkUserAuth() {
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $repository = $em->getRepository('LoginLoginBundle:Users');
        if ($session->has('login')) {
            $login = $session->get('login');
            $email = $login->getEmail();
            $password = $login->getPassword();
            $user = $repository->findOneBy(array('email' => $email, 'password' => $password));
            if ($user) {
                $this->_commonOptions['userName'] = $user->getName();
                return true;
            } else
                return false;
        }
    }
}