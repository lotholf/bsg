<?php

namespace Bsg\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BsgGameBundle:Default:index.html.twig', array('name' => $name));
    }
}
