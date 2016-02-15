<?php

/**
 * Created by PhpStorm.
 * User: пїЅпїЅпїЅпїЅпїЅпїЅ
 * Date: 11.02.2016
 * Time: 23:06
 */

namespace Login\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Login\LoginBundle\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Login\LoginBundle\Entity\Hotel;

class AdminController extends Controller {

    public $_commonOptions;
    
    public function __construct() {
    
        //parent:__construct();
        //var_dump($this->getDoctrine());
//        if (!$this->checkUserAuth())
//            return $this->redirectToRoute('login_login_homepage');
        //$this->getDoctrine();
    }

    public function indexAction() {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            $hotels = $em->getRepository('LoginLoginBundle:Hotel')->findAll();
            return $this->render('LoginLoginBundle:Pages:main.html.twig', array('options' => $this->_commonOptions, 'hotels' => $hotels));
        }
    }

    public function editAction($id) {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('LoginLoginBundle:Hotel')->find($id);
            if ($repository) {
                return $this->render('LoginLoginBundle:Pages:hotelEdit.html.twig', array('options' => $this->_commonOptions, 'hotels' => $repository));
            } else
                return $this->render('LoginLoginBundle:Pages:hotelEdit.html.twig', array('options' => $this->_commonOptions));
        }
    }

    public function saveAction(Request $request) {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            if ($request->getMethod() == "POST") {
                $id = $request->get('id');
                $title = $request->get('title');
                $description = $request->get('description');
                $repository = $em->getRepository('LoginLoginBundle:Hotel');
                $hotel = $repository->find($id);
                if (!$hotel) {
                    $hotel = new Hotel();
                    $hotel->setOrderby(0);
                }

                $hotel->setTitle($title);
                $hotel->setDescription($description);

                $em->persist($hotel);
                $em->flush();
                if ($hotel->getOrderby() == 0) {
                    $ordby = $em->getRepository('LoginLoginBundle:Hotel')->findOneBy(array(), array('orderby' => 'DESC'));
                    $hotel->setOrderby($ordby->getOrderby() + 1);
                    $em->persist($hotel);
                    $em->flush();
                }
                $insert_id = $hotel->getId();


                return $this->redirectToRoute('admin_admin_hotels_edit', array('id' => $insert_id), 301);
            }
        }
    }
    
    public function delAction($id)
    {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            $hotel = $em->getRepository('LoginLoginBundle:Hotel')->find($id);
            $em->remove($hotel);
            $em->flush();
            
            return $this->redirectToRoute('admin_admin_homepage');
        }
    }

    private function checkUserAuth() {
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
