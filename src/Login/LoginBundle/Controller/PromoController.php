<?php

/**
 * Created by PhpStorm.
 * User: ������
 * Date: 18.02.2016
 * Time: 0:56
 */

namespace Login\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Login\LoginBundle\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Login\LoginBundle\Entity\Promo;

class PromoController extends SecurityController {

    public function indexAction() {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            $promo = $em->getRepository('LoginLoginBundle:Promo')->findAll();
            return $this->render('LoginLoginBundle:Pages:promo.html.twig', array('options' => $this->_commonOptions, 'promo' => $promo));
        }
    }

    public function editAction($id) {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('LoginLoginBundle:Promo')->find($id);

            if ($repository) {
                return $this->render('LoginLoginBundle:Pages:promoEdit.html.twig', array('options' => $this->_commonOptions, 'promo' => $repository));
            } else
                return $this->render('LoginLoginBundle:Pages:promoEdit.html.twig', array('options' => $this->_commonOptions));
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
                $text = $request->get('text');
                $isActive = $request->get('isactive');
                $date = explode(' - ', $request->get('reservation'));
                $repository = $em->getRepository('LoginLoginBundle:Promo');
                $promo = $repository->find($id);
                if (!$promo) {
                    $promo = new Promo();
//                    $promo->setOrderby(0);
                }

                $startTs = new \DateTime($date[0] . ' 00:00:00');
                $stopTs = new \DateTime($date[1] . ' 23:59:59');
                $promo->setTitle($title);
                $promo->setText($text);
                $promo->setIsactive($isActive == 1 ? 1 : 0);
                $promo->setStartTs($startTs);
                $promo->setStopTs($stopTs);
                $em->persist($promo);
                $em->flush();

                $insert_id = $promo->getId();


                return $this->redirectToRoute('admin_admin_promo_edit', array('id' => $insert_id), 301);
            }
        }
    }

    public function delAction($id) {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            $promo = $em->getRepository('LoginLoginBundle:Promo')->find($id);
            $em->remove($promo);
            $em->flush();

            return $this->redirectToRoute('admin_admin_promo');
        }
    }

}
