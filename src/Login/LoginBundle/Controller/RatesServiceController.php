<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 18.02.2016
 * Time: 0:33
 */

namespace Login\LoginBundle\Controller;


class RatesServiceController extends SecurityController
{
    public function indexAction()
    {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
//            $em = $this->getDoctrine()->getManager();
//            $services = $em->getRepository('LoginLoginBundle:AdditionalService')->findAll();
            return $this->render('LoginLoginBundle:Pages:ratesService.html.twig', array('options' => $this->_commonOptions));
        }
    }
}