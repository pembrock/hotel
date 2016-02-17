<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 18.02.2016
 * Time: 0:56
 */

namespace Login\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Login\LoginBundle\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Login\LoginBundle\Entity\Promo;

class PromoController extends SecurityController
{
    public function indexAction()
    {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            $promo = $em->getRepository('LoginLoginBundle:Promo')->findAll();
            return $this->render('LoginLoginBundle:Pages:promo.html.twig', array('options' => $this->_commonOptions, 'promo' => $promo));
        }
    }

}