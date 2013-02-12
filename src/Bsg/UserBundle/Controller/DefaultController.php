<?php

namespace Bsg\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BsgUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
