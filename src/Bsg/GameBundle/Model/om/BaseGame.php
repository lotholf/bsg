<?php

namespace Bsg\GameBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Bsg\GameBundle\Model\Game;
use Bsg\GameBundle\Model\GamePeer;
use Bsg\GameBundle\Model\GamePlayer;
use Bsg\GameBundle\Model\GamePlayerQuery;
use Bsg\GameBundle\Model\GameQuery;

abstract class BaseGame extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Bsg\\GameBundle\\Model\\GamePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        GamePeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the fuel field.
     * @var        int
     */
    protected $fuel;

    /**
     * The value for the food field.
     * @var        int
     */
    protected $food;

    /**
     * The value for the morale field.
     * @var        int
     */
    protected $morale;

    /**
     * The value for the population field.
     * @var        int
     */
    protected $population;

    /**
     * The value for the distance field.
     * @var        int
     */
    protected $distance;

    /**
     * The value for the jump field.
     * @var        int
     */
    protected $jump;

    /**
     * The value for the is_completed field.
     * @var        boolean
     */
    protected $is_completed;

    /**
     * @var        PropelObjectCollection|GamePlayer[] Collection to store aggregation of GamePlayer objects.
     */
    protected $collGamePlayers;
    protected $collGamePlayersPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $gamePlayersScheduledForDeletion = null;

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [fuel] column value.
     *
     * @return int
     */
    public function getFuel()
    {
        return $this->fuel;
    }

    /**
     * Get the [food] column value.
     *
     * @return int
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * Get the [morale] column value.
     *
     * @return int
     */
    public function getMorale()
    {
        return $this->morale;
    }

    /**
     * Get the [population] column value.
     *
     * @return int
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * Get the [distance] column value.
     *
     * @return int
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Get the [jump] column value.
     *
     * @return int
     */
    public function getJump()
    {
        return $this->jump;
    }

    /**
     * Get the [is_completed] column value.
     *
     * @return boolean
     */
    public function getIsCompleted()
    {
        return $this->is_completed;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return Game The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = GamePeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Game The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = GamePeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [fuel] column.
     *
     * @param int $v new value
     * @return Game The current object (for fluent API support)
     */
    public function setFuel($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->fuel !== $v) {
            $this->fuel = $v;
            $this->modifiedColumns[] = GamePeer::FUEL;
        }


        return $this;
    } // setFuel()

    /**
     * Set the value of [food] column.
     *
     * @param int $v new value
     * @return Game The current object (for fluent API support)
     */
    public function setFood($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->food !== $v) {
            $this->food = $v;
            $this->modifiedColumns[] = GamePeer::FOOD;
        }


        return $this;
    } // setFood()

    /**
     * Set the value of [morale] column.
     *
     * @param int $v new value
     * @return Game The current object (for fluent API support)
     */
    public function setMorale($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->morale !== $v) {
            $this->morale = $v;
            $this->modifiedColumns[] = GamePeer::MORALE;
        }


        return $this;
    } // setMorale()

    /**
     * Set the value of [population] column.
     *
     * @param int $v new value
     * @return Game The current object (for fluent API support)
     */
    public function setPopulation($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->population !== $v) {
            $this->population = $v;
            $this->modifiedColumns[] = GamePeer::POPULATION;
        }


        return $this;
    } // setPopulation()

    /**
     * Set the value of [distance] column.
     *
     * @param int $v new value
     * @return Game The current object (for fluent API support)
     */
    public function setDistance($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->distance !== $v) {
            $this->distance = $v;
            $this->modifiedColumns[] = GamePeer::DISTANCE;
        }


        return $this;
    } // setDistance()

    /**
     * Set the value of [jump] column.
     *
     * @param int $v new value
     * @return Game The current object (for fluent API support)
     */
    public function setJump($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->jump !== $v) {
            $this->jump = $v;
            $this->modifiedColumns[] = GamePeer::JUMP;
        }


        return $this;
    } // setJump()

    /**
     * Sets the value of the [is_completed] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Game The current object (for fluent API support)
     */
    public function setIsCompleted($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_completed !== $v) {
            $this->is_completed = $v;
            $this->modifiedColumns[] = GamePeer::IS_COMPLETED;
        }


        return $this;
    } // setIsCompleted()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->fuel = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->food = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->morale = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->population = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->distance = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->jump = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->is_completed = ($row[$startcol + 8] !== null) ? (boolean) $row[$startcol + 8] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = GamePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Game object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(GamePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = GamePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collGamePlayers = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(GamePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = GameQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(GamePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                GamePeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->gamePlayersScheduledForDeletion !== null) {
                if (!$this->gamePlayersScheduledForDeletion->isEmpty()) {
                    GamePlayerQuery::create()
                        ->filterByPrimaryKeys($this->gamePlayersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->gamePlayersScheduledForDeletion = null;
                }
            }

            if ($this->collGamePlayers !== null) {
                foreach ($this->collGamePlayers as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = GamePeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . GamePeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(GamePeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`ID`';
        }
        if ($this->isColumnModified(GamePeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`NAME`';
        }
        if ($this->isColumnModified(GamePeer::FUEL)) {
            $modifiedColumns[':p' . $index++]  = '`FUEL`';
        }
        if ($this->isColumnModified(GamePeer::FOOD)) {
            $modifiedColumns[':p' . $index++]  = '`FOOD`';
        }
        if ($this->isColumnModified(GamePeer::MORALE)) {
            $modifiedColumns[':p' . $index++]  = '`MORALE`';
        }
        if ($this->isColumnModified(GamePeer::POPULATION)) {
            $modifiedColumns[':p' . $index++]  = '`POPULATION`';
        }
        if ($this->isColumnModified(GamePeer::DISTANCE)) {
            $modifiedColumns[':p' . $index++]  = '`DISTANCE`';
        }
        if ($this->isColumnModified(GamePeer::JUMP)) {
            $modifiedColumns[':p' . $index++]  = '`JUMP`';
        }
        if ($this->isColumnModified(GamePeer::IS_COMPLETED)) {
            $modifiedColumns[':p' . $index++]  = '`IS_COMPLETED`';
        }

        $sql = sprintf(
            'INSERT INTO `game` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`ID`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`NAME`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`FUEL`':
                        $stmt->bindValue($identifier, $this->fuel, PDO::PARAM_INT);
                        break;
                    case '`FOOD`':
                        $stmt->bindValue($identifier, $this->food, PDO::PARAM_INT);
                        break;
                    case '`MORALE`':
                        $stmt->bindValue($identifier, $this->morale, PDO::PARAM_INT);
                        break;
                    case '`POPULATION`':
                        $stmt->bindValue($identifier, $this->population, PDO::PARAM_INT);
                        break;
                    case '`DISTANCE`':
                        $stmt->bindValue($identifier, $this->distance, PDO::PARAM_INT);
                        break;
                    case '`JUMP`':
                        $stmt->bindValue($identifier, $this->jump, PDO::PARAM_INT);
                        break;
                    case '`IS_COMPLETED`':
                        $stmt->bindValue($identifier, (int) $this->is_completed, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        } else {
            $this->validationFailures = $res;

            return false;
        }
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            if (($retval = GamePeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collGamePlayers !== null) {
                    foreach ($this->collGamePlayers as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = GamePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getFuel();
                break;
            case 3:
                return $this->getFood();
                break;
            case 4:
                return $this->getMorale();
                break;
            case 5:
                return $this->getPopulation();
                break;
            case 6:
                return $this->getDistance();
                break;
            case 7:
                return $this->getJump();
                break;
            case 8:
                return $this->getIsCompleted();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Game'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Game'][$this->getPrimaryKey()] = true;
        $keys = GamePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getFuel(),
            $keys[3] => $this->getFood(),
            $keys[4] => $this->getMorale(),
            $keys[5] => $this->getPopulation(),
            $keys[6] => $this->getDistance(),
            $keys[7] => $this->getJump(),
            $keys[8] => $this->getIsCompleted(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->collGamePlayers) {
                $result['GamePlayers'] = $this->collGamePlayers->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = GamePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setFuel($value);
                break;
            case 3:
                $this->setFood($value);
                break;
            case 4:
                $this->setMorale($value);
                break;
            case 5:
                $this->setPopulation($value);
                break;
            case 6:
                $this->setDistance($value);
                break;
            case 7:
                $this->setJump($value);
                break;
            case 8:
                $this->setIsCompleted($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = GamePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setFuel($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setFood($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setMorale($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setPopulation($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setDistance($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setJump($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setIsCompleted($arr[$keys[8]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(GamePeer::DATABASE_NAME);

        if ($this->isColumnModified(GamePeer::ID)) $criteria->add(GamePeer::ID, $this->id);
        if ($this->isColumnModified(GamePeer::NAME)) $criteria->add(GamePeer::NAME, $this->name);
        if ($this->isColumnModified(GamePeer::FUEL)) $criteria->add(GamePeer::FUEL, $this->fuel);
        if ($this->isColumnModified(GamePeer::FOOD)) $criteria->add(GamePeer::FOOD, $this->food);
        if ($this->isColumnModified(GamePeer::MORALE)) $criteria->add(GamePeer::MORALE, $this->morale);
        if ($this->isColumnModified(GamePeer::POPULATION)) $criteria->add(GamePeer::POPULATION, $this->population);
        if ($this->isColumnModified(GamePeer::DISTANCE)) $criteria->add(GamePeer::DISTANCE, $this->distance);
        if ($this->isColumnModified(GamePeer::JUMP)) $criteria->add(GamePeer::JUMP, $this->jump);
        if ($this->isColumnModified(GamePeer::IS_COMPLETED)) $criteria->add(GamePeer::IS_COMPLETED, $this->is_completed);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(GamePeer::DATABASE_NAME);
        $criteria->add(GamePeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Game (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setFuel($this->getFuel());
        $copyObj->setFood($this->getFood());
        $copyObj->setMorale($this->getMorale());
        $copyObj->setPopulation($this->getPopulation());
        $copyObj->setDistance($this->getDistance());
        $copyObj->setJump($this->getJump());
        $copyObj->setIsCompleted($this->getIsCompleted());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getGamePlayers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGamePlayer($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Game Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return GamePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new GamePeer();
        }

        return self::$peer;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('GamePlayer' == $relationName) {
            $this->initGamePlayers();
        }
    }

    /**
     * Clears out the collGamePlayers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGamePlayers()
     */
    public function clearGamePlayers()
    {
        $this->collGamePlayers = null; // important to set this to null since that means it is uninitialized
        $this->collGamePlayersPartial = null;
    }

    /**
     * reset is the collGamePlayers collection loaded partially
     *
     * @return void
     */
    public function resetPartialGamePlayers($v = true)
    {
        $this->collGamePlayersPartial = $v;
    }

    /**
     * Initializes the collGamePlayers collection.
     *
     * By default this just sets the collGamePlayers collection to an empty array (like clearcollGamePlayers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGamePlayers($overrideExisting = true)
    {
        if (null !== $this->collGamePlayers && !$overrideExisting) {
            return;
        }
        $this->collGamePlayers = new PropelObjectCollection();
        $this->collGamePlayers->setModel('GamePlayer');
    }

    /**
     * Gets an array of GamePlayer objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Game is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|GamePlayer[] List of GamePlayer objects
     * @throws PropelException
     */
    public function getGamePlayers($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collGamePlayersPartial && !$this->isNew();
        if (null === $this->collGamePlayers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGamePlayers) {
                // return empty collection
                $this->initGamePlayers();
            } else {
                $collGamePlayers = GamePlayerQuery::create(null, $criteria)
                    ->filterByGame($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collGamePlayersPartial && count($collGamePlayers)) {
                      $this->initGamePlayers(false);

                      foreach($collGamePlayers as $obj) {
                        if (false == $this->collGamePlayers->contains($obj)) {
                          $this->collGamePlayers->append($obj);
                        }
                      }

                      $this->collGamePlayersPartial = true;
                    }

                    return $collGamePlayers;
                }

                if($partial && $this->collGamePlayers) {
                    foreach($this->collGamePlayers as $obj) {
                        if($obj->isNew()) {
                            $collGamePlayers[] = $obj;
                        }
                    }
                }

                $this->collGamePlayers = $collGamePlayers;
                $this->collGamePlayersPartial = false;
            }
        }

        return $this->collGamePlayers;
    }

    /**
     * Sets a collection of GamePlayer objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $gamePlayers A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setGamePlayers(PropelCollection $gamePlayers, PropelPDO $con = null)
    {
        $this->gamePlayersScheduledForDeletion = $this->getGamePlayers(new Criteria(), $con)->diff($gamePlayers);

        foreach ($this->gamePlayersScheduledForDeletion as $gamePlayerRemoved) {
            $gamePlayerRemoved->setGame(null);
        }

        $this->collGamePlayers = null;
        foreach ($gamePlayers as $gamePlayer) {
            $this->addGamePlayer($gamePlayer);
        }

        $this->collGamePlayers = $gamePlayers;
        $this->collGamePlayersPartial = false;
    }

    /**
     * Returns the number of related GamePlayer objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related GamePlayer objects.
     * @throws PropelException
     */
    public function countGamePlayers(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collGamePlayersPartial && !$this->isNew();
        if (null === $this->collGamePlayers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGamePlayers) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getGamePlayers());
                }
                $query = GamePlayerQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByGame($this)
                    ->count($con);
            }
        } else {
            return count($this->collGamePlayers);
        }
    }

    /**
     * Method called to associate a GamePlayer object to this object
     * through the GamePlayer foreign key attribute.
     *
     * @param    GamePlayer $l GamePlayer
     * @return Game The current object (for fluent API support)
     */
    public function addGamePlayer(GamePlayer $l)
    {
        if ($this->collGamePlayers === null) {
            $this->initGamePlayers();
            $this->collGamePlayersPartial = true;
        }
        if (!$this->collGamePlayers->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddGamePlayer($l);
        }

        return $this;
    }

    /**
     * @param	GamePlayer $gamePlayer The gamePlayer object to add.
     */
    protected function doAddGamePlayer($gamePlayer)
    {
        $this->collGamePlayers[]= $gamePlayer;
        $gamePlayer->setGame($this);
    }

    /**
     * @param	GamePlayer $gamePlayer The gamePlayer object to remove.
     */
    public function removeGamePlayer($gamePlayer)
    {
        if ($this->getGamePlayers()->contains($gamePlayer)) {
            $this->collGamePlayers->remove($this->collGamePlayers->search($gamePlayer));
            if (null === $this->gamePlayersScheduledForDeletion) {
                $this->gamePlayersScheduledForDeletion = clone $this->collGamePlayers;
                $this->gamePlayersScheduledForDeletion->clear();
            }
            $this->gamePlayersScheduledForDeletion[]= $gamePlayer;
            $gamePlayer->setGame(null);
        }
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related GamePlayers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|GamePlayer[] List of GamePlayer objects
     */
    public function getGamePlayersJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = GamePlayerQuery::create(null, $criteria);
        $query->joinWith('User', $join_behavior);

        return $this->getGamePlayers($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related GamePlayers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|GamePlayer[] List of GamePlayer objects
     */
    public function getGamePlayersJoinCharacter($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = GamePlayerQuery::create(null, $criteria);
        $query->joinWith('Character', $join_behavior);

        return $this->getGamePlayers($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->fuel = null;
        $this->food = null;
        $this->morale = null;
        $this->population = null;
        $this->distance = null;
        $this->jump = null;
        $this->is_completed = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volumne/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collGamePlayers) {
                foreach ($this->collGamePlayers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        if ($this->collGamePlayers instanceof PropelCollection) {
            $this->collGamePlayers->clearIterator();
        }
        $this->collGamePlayers = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(GamePeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
