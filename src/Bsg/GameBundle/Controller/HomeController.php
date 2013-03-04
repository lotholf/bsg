<?php

namespace Bsg\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\UserInterface;
use Bsg\GameBundle\Model\GamePlayerQuery;
use Bsg\GameBundle\Model\GameQuery;

class HomeController extends Controller
{
    public function indexAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $userIsAlreadyInGame = GamePlayerQuery::findIfUserIsAlreadyInGame($user);

        if ($userIsAlreadyInGame) {
            $currentGameId = GameQuery::findCurrentGameWithUser($user)->getId();
        } else {
            $currentGameId = null;
        }

        return $this->render('BsgGameBundle:Home:index.html.twig', array('userInGame' => $userIsAlreadyInGame, 'currentGameId' => $currentGameId));
    }
}
