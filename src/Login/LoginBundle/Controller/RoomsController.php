<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 16.02.2016
 * Time: 23:55
 */

namespace Login\LoginBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Login\LoginBundle\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Login\LoginBundle\Entity\Rooms;
use Login\LoginBundle\Controller\SecurityController;

class RoomsController extends SecurityController
{


    //public $_commonOptions;

    public function __construct() {

    }

    public function indexAction() {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            $rooms = $em->getRepository('LoginLoginBundle:Rooms')->findAll();
            return $this->render('LoginLoginBundle:Pages:rooms.html.twig', array('options' => $this->_commonOptions, 'rooms' => $rooms));
        }
    }

    public function editAction($id) {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('LoginLoginBundle:Rooms')->find($id);

            if ($repository) {
                return $this->render('LoginLoginBundle:Pages:roomEdit.html.twig', array('options' => $this->_commonOptions, 'rooms' => $repository));
            } else
                return $this->render('LoginLoginBundle:Pages:roomEdit.html.twig', array('options' => $this->_commonOptions));
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
                $seats_count = $request->get('seatscount');
                $isActive = $request->get('isactive');
                $repository = $em->getRepository('LoginLoginBundle:Rooms');
                $room = $repository->find($id);
                if (!$room) {
                    $room = new Rooms();
                    $room->setOrderby(0);
                }

                $room->setTitle($title);
                $room->setDescription($description);
                $room->setSeatsCout($seats_count);
                $room->setIsactive($isActive == 1 ? 1 : 0);

                $em->persist($room);
                $em->flush();
                if ($room->getOrderby() == 0) {
                    $ordby = $em->getRepository('LoginLoginBundle:Rooms')->findOneBy(array(), array('orderby' => 'DESC'));
                    $room->setOrderby($ordby->getOrderby() + 1);
                    $em->persist($room);
                    $em->flush();
                }
                $insert_id = $room->getId();


                return $this->redirectToRoute('admin_admin_rooms_edit', array('id' => $insert_id), 301);
            }
        }
    }

    public function delAction($id)
    {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            $room = $em->getRepository('LoginLoginBundle:Rooms')->find($id);
            $em->remove($room);
            $em->flush();

            return $this->redirectToRoute('admin_admin_rooms');
        }
    }

}