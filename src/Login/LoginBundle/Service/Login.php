<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 16.02.2016
 * Time: 0:15
 */

namespace Login\LoginBundle\Service;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
class Login
{
    protected $em;

    public function __construct(EntityManager $em){
        $this->em = $em;
    }

    public function checkAction()
    {
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