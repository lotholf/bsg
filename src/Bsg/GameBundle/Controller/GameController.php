<?php

namespace Bsg\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameController extends Controller
{
    public function indexAction($gameId)
    {
        return $this->render('BsgGameBundle:Game:index.html.twig', array('game_id' => $gameId));
    }
}
