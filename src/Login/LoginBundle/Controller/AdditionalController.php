<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 17.02.2016
 * Time: 23:40
 */

namespace Login\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Login\LoginBundle\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Login\LoginBundle\Entity\AdditionalService;
use Login\LoginBundle\Controller\SecurityController;

class AdditionalController extends SecurityController
{
    public function indexAction()
    {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            $services = $em->getRepository('LoginLoginBundle:AdditionalService')->findAll();
            return $this->render('LoginLoginBundle:Pages:additional.html.twig', array('options' => $this->_commonOptions, 'services' => $services));
        }
    }

    public function editAction($id) {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('LoginLoginBundle:AdditionalService')->find($id);

            if ($repository) {
                return $this->render('LoginLoginBundle:Pages:additionalEdit.html.twig', array('options' => $this->_commonOptions, 'service' => $repository));
            } else
                return $this->render('LoginLoginBundle:Pages:additionalEdit.html.twig', array('options' => $this->_commonOptions));
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
                $isActive = $request->get('isactive');
                $repository = $em->getRepository('LoginLoginBundle:AdditionalService');
                $service = $repository->find($id);
                if (!$service) {
                    $service = new AdditionalService();
                    $service->setOrderby(0);
                }

                $service->setTitle($title);
                $service->setDescription($description);
                $service->setIsactive($isActive == 1 ? 1 : 0);

                $em->persist($service);
                $em->flush();
                if ($service->getOrderby() == 0) {
                    $ordby = $em->getRepository('LoginLoginBundle:AdditionalService')->findOneBy(array(), array('orderby' => 'DESC'));
                    $service->setOrderby($ordby->getOrderby() + 1);
                    $em->persist($service);
                    $em->flush();
                }
                $insert_id = $service->getId();


                return $this->redirectToRoute('admin_admin_additional_edit', array('id' => $insert_id), 301);
            }
        }
    }

    public function delAction($id)
    {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            $service = $em->getRepository('LoginLoginBundle:AdditionalService')->find($id);
            $em->remove($service);
            $em->flush();

            return $this->redirectToRoute('admin_admin_additional');
        }
    }

}