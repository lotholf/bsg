<?php

namespace Bsg\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\UserInterface;
use Bsg\GameBundle\Model\Game;
use Bsg\GameBundle\Model\GameQuery;
use Bsg\GameBundle\Model\GamePlayer;
use Bsg\GameBundle\Model\GamePlayerQuery;

class GameController extends Controller
{
    public function newGameAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $userInGame = GamePlayerQuery::findIfUserIsAlreadyInGame($user);

        if(!$userInGame)
        {
            $game = new Game();
            $game
                ->setFuel(8)
                ->setFood(8)
                ->setMorale(10)
                ->setPopulation(12)
                ->setDistance(0)
                ->setJump(0)
                ->setIsCompleted(false)
            ;

            $game->save();

            $gamePlayer = new GamePlayer();
            $gamePlayer
                ->setGame($game)
                ->setUser($user)
            ;

            $gamePlayer->save();

            return $this->render('BsgGameBundle:Game:index.html.twig', array('game' => $game));
        }
        else
        {
            $this->get('session')->setFlash(
                'error',
                'Vous avez déjà une partie en cours.'
            );
            $currentGameId = GameQuery::findCurrentGameWithUser($user)->getId();
            return $this->render('BsgGameBundle:Home:index.html.twig', array('userInGame' => $userInGame, 'currentGameId' => $currentGameId));
        }
    }

    public function joinGameAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $userInGame = GamePlayerQuery::findIfUserIsAlreadyInGame($user);

        if(!$userInGame)
        {
            // Retrieve a not full game
            $game = GameQuery::findGameNotFull();

            if ($game) {
                // Add the player in the game
                $gamePlayer = new GamePlayer();
                $gamePlayer
                    ->setGame($game)
                    ->setUser($user)
                ;

                $gamePlayer->save();

                return $this->render('BsgGameBundle:Game:index.html.twig', array('game' => $game));
            } else {
                $this->get('session')->setFlash(
                    'error',
                    "Il n'y a actuellement aucune partie avec de la place."
                );
                return $this->render('BsgGameBundle:Home:index.html.twig', array('userInGame' => $userInGame, 'currentGameId' => null));
            }
        }
        else
        {
            $this->get('session')->setFlash(
                'error',
                'Vous avez déjà une partie en cours.'
            );
            $currentGameId = GameQuery::findCurrentGameWithUser($user)->getId();
            return $this->render('BsgGameBundle:Home:index.html.twig', array('userInGame' => $userInGame, 'currentGameId' => $currentGameId));
        }
    }

    public function resumeGameAction($gameId)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $currentGame = GameQuery::findCurrentGameWithUser($user);
        if($currentGame) {
            if($currentGame->getId() == $gameId) {
                return $this->render('BsgGameBundle:Game:index.html.twig', array('game' => $currentGame));
            }

            $this->get('session')->setFlash(
                'error',
                "Vous essayez de rejoindre une partie qui n'est pas la votre."
            );

            return $this->render('BsgGameBundle:Home:index.html.twig', array('userInGame' => true, 'currentGameId' => $currentGame->getId()));
        } else {
            $this->get('session')->setFlash(
                'error',
                "Vous essayez de rejoindre une partie alors que vous n'en avez aucune en cours."
            );

            return $this->render('BsgGameBundle:Home:index.html.twig', array('userInGame' => false, 'currentGameId' => null));
        }
    }
}
