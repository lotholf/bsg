<?php

namespace Bsg\GameBundle\Model;

use Bsg\GameBundle\Model\om\BaseGameQuery;
use \PDO;

class GameQuery extends BaseGameQuery
{
    public static function findCurrentGameWithUser($user)
    {
        $game = GameQuery::create()
            ->filterByIsCompleted(false)
            ->useGamePlayerQuery()
                ->filterByUser($user)
            ->endUse()
            ->findOne()
        ;

        return $game;
    }

    public static function findGameNotFull()
    {
        $game = GameQuery::create()
            ->filterByIsCompleted(false)
            ->useGamePlayerQuery()
                ->groupByGameId()
                ->having('COUNT(game_player.USER_ID) < ?', 5, PDO::PARAM_INT)
            ->endUse()
            ->findOne()
        ;

        return $game;
    }
}
