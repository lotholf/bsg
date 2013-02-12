<?php

namespace Bsg\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('BsgGameBundle:Home:index.html.twig');
    }
}
