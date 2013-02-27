<?php

namespace Bsg\GameBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'game' table.
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
class GameTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Bsg.GameBundle.Model.map.GameTableMap';

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
        $this->setName('game');
        $this->setPhpName('Game');
        $this->setClassname('Bsg\\GameBundle\\Model\\Game');
        $this->setPackage('src.Bsg.GameBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('NAME', 'Name', 'VARCHAR', false, 40, null);
        $this->addColumn('FUEL', 'Fuel', 'INTEGER', false, null, null);
        $this->addColumn('FOOD', 'Food', 'INTEGER', false, null, null);
        $this->addColumn('MORALE', 'Morale', 'INTEGER', false, null, null);
        $this->addColumn('POPULATION', 'Population', 'INTEGER', false, null, null);
        $this->addColumn('DISTANCE', 'Distance', 'INTEGER', false, null, null);
        $this->addColumn('JUMP', 'Jump', 'INTEGER', false, null, null);
        $this->addColumn('IS_COMPLETED', 'IsCompleted', 'BOOLEAN', false, 1, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('GamePlayer', 'Bsg\\GameBundle\\Model\\GamePlayer', RelationMap::ONE_TO_MANY, array('id' => 'game_id', ), null, null, 'GamePlayers');
    } // buildRelations()

} // GameTableMap
