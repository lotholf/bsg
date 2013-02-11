<?php

namespace Bsg\GameBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'character' table.
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
class CharacterTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Bsg.GameBundle.Model.map.CharacterTableMap';

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
        $this->setName('character');
        $this->setPhpName('Character');
        $this->setClassname('Bsg\\GameBundle\\Model\\Character');
        $this->setPackage('src.Bsg.GameBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('NAME', 'Name', 'VARCHAR', false, 40, null);
        $this->getColumn('NAME', false)->setPrimaryString(true);
        $this->addColumn('POWER', 'Power', 'VARCHAR', false, 40, null);
        $this->addColumn('POWER_ONE_PER_GAME', 'PowerOnePerGame', 'VARCHAR', false, 40, null);
        $this->addColumn('DRAWBACK', 'Drawback', 'VARCHAR', false, 40, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

} // CharacterTableMap
