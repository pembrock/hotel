<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 16.02.2016
 * Time: 23:55
 */

namespace Login\LoginBundle\Controller;


use Login\LoginBundle\Entity\Rooms;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Login\LoginBundle\Controller\SecurityController;
class RoomsController extends SecurityController
{
    public function indexAction()
    {
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

                $repository = $em->getRepository('LoginLoginBundle:Hotel');
                $rooms = $repository->find($id);
                if (!$rooms) {
                    $rooms = new Rooms();
                    $rooms->setOrderby(0);
                }

                $rooms->setTitle($title);
                $rooms->setDescription($description);

                $em->persist($rooms);
                $em->flush();
                if ($rooms->getOrderby() == 0) {
                    $ordby = $em->getRepository('LoginLoginBundle:Rooms')->findOneBy(array(), array('orderby' => 'DESC'));
                    $rooms->setOrderby($ordby->getOrderby() + 1);
                    $em->persist($rooms);
                    $em->flush();
                }
                $insert_id = $rooms->getId();


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
            $hotel = $em->getRepository('LoginLoginBundle:Hotel')->find($id);
            $em->remove($hotel);
            $em->flush();

            return $this->redirectToRoute('admin_admin_homepage');
        }
    }

}