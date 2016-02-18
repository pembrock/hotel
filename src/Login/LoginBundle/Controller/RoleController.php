<?php
/**
 * Created by PhpStorm.
 * User: k.pasikuta
 * Date: 16.02.2016
 * Time: 23:55
 */

namespace Login\LoginBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Login\LoginBundle\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Login\LoginBundle\Entity\Role;
use Login\LoginBundle\Controller\SecurityController;

class RoleController extends SecurityController
{


    //public $_commonOptions;

    public function __construct() {

    }

    public function indexAction() {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            $role = $em->getRepository('LoginLoginBundle:Role')->findAll();
            return $this->render('LoginLoginBundle:Pages:role.html.twig', array('options' => $this->_commonOptions, 'role' => $role));
        }
    }

    public function editAction($id) {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('LoginLoginBundle:Role')->find($id);

            if ($repository) {
                return $this->render('LoginLoginBundle:Pages:roleEdit.html.twig', array('options' => $this->_commonOptions, 'role' => $repository));
            } else
                return $this->render('LoginLoginBundle:Pages:roleEdit.html.twig', array('options' => $this->_commonOptions));
        }
    }

    public function saveAction(Request $request) {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            if ($request->getMethod() == "POST") {
                $id = $request->get('id');
                $name = $request->get('name');
                $descr = $request->get('descr');
                $isEnabled = $request->get('isactive');
                $sys = $request->get('sys');
                $repository = $em->getRepository('LoginLoginBundle:Role');
                $role = $repository->find($id);
                if (!$role) {
                    $role = new Role();
                    //$role->setOrderby(0);
                }

                $role->setName($name);
                $role->setDescr($descr);
                $role->setIsEnabled($isEnabled == 1 ? 1 : 0);
                $role->setSys($sys);

                $em->persist($role);
                $em->flush();
                
                $insert_id = $role->getId();


                return $this->redirectToRoute('admin_admin_role_edit', array('id' => $insert_id), 301);
            }
        }
    }

    public function delAction($id)
    {
        if (!$this->checkUserAuth())
            return $this->redirectToRoute('login_login_homepage');
        else {
            $em = $this->getDoctrine()->getManager();
            $role = $em->getRepository('LoginLoginBundle:Role')->find($id);
            $em->remove($role);
            $em->flush();

            return $this->redirectToRoute('admin_admin_role');
        }
    }

}