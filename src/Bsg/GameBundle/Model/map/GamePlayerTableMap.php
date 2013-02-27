<?php

namespace Bsg\GameBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'game_player' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Bsg.GameBundle.Model.map
 */
class GamePlayerTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Bsg.GameBundle.Model.map.GamePlayerTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('game_player');
        $this->setPhpName('GamePlayer');
        $this->setClassname('Bsg\\GameBundle\\Model\\GamePlayer');
        $this->setPackage('src.Bsg.GameBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('GAME_ID', 'GameId', 'INTEGER', 'game', 'ID', true, null, null);
        $this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'fos_user', 'ID', true, null, null);
        $this->addForeignKey('CHARACTER_ID', 'CharacterId', 'INTEGER', 'character', 'ID', false, null, null);
        $this->addColumn('IS_AMIRAL', 'IsAmiral', 'BOOLEAN', false, 1, null);
        $this->addColumn('IS_PRESIDENT', 'IsPresident', 'BOOLEAN', false, 1, null);
        $this->addColumn('IS_CAG', 'IsCag', 'BOOLEAN', false, 1, null);
        $this->addColumn('IS_ALIVE', 'IsAlive', 'BOOLEAN', false, 1, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Game', 'Bsg\\GameBundle\\Model\\Game', RelationMap::MANY_TO_ONE, array('game_id' => 'id', ), null, null);
        $this->addRelation('User', 'FOS\\UserBundle\\Propel\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
        $this->addRelation('Character', 'Bsg\\GameBundle\\Model\\Character', RelationMap::MANY_TO_ONE, array('character_id' => 'id', ), null, null);
    } // buildRelations()

} // GamePlayerTableMap
