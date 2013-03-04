<?php

namespace Bsg\GameBundle\Model;

use Bsg\GameBundle\Model\om\BaseGamePlayerQuery;

class GamePlayerQuery extends BaseGamePlayerQuery
{
    public static function findIfUserIsAlreadyInGame($user)
    {
        $userInGame = GamePlayerQuery::create()
            ->filterByUser($user)
            ->useGameQuery()
                ->filterByIsCompleted(false)
            ->endUse()
            ->findOne()
        ;

        return is_object($userInGame) && $userInGame instanceof GamePlayer;
    }
}
