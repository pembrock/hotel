<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of checkAuthManager
 *
 * @author k.pasikuta
 */

namespace Login\LoginBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class checkAuthManager {

    /**
     * @var EntityManager
     */
    public $em;

    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }

    public function checkUserAuth() {
        $session = new Session();
        $repository = $this->em->getRepository('LoginLoginBundle:Users');
        if ($session->has('login')) {
            $login = $session->get('login');
            $email = $login->getEmail();
            $password = $login->getPassword();
            $user = $repository->findOneBy(array('email' => $email, 'password' => $password));
            if ($user) {
                return true;
            } else
                return false;
        }
    }

}
