<?php

namespace Bsg\GameBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelException;
use \PropelPDO;
use Bsg\GameBundle\Model\Character;
use Bsg\GameBundle\Model\CharacterQuery;
use Bsg\GameBundle\Model\Game;
use Bsg\GameBundle\Model\GamePlayer;
use Bsg\GameBundle\Model\GamePlayerPeer;
use Bsg\GameBundle\Model\GamePlayerQuery;
use Bsg\GameBundle\Model\GameQuery;
use FOS\UserBundle\Propel\User;
use FOS\UserBundle\Propel\UserQuery;

abstract class BaseGamePlayer extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Bsg\\GameBundle\\Model\\GamePlayerPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        GamePlayerPeer
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
     * The value for the game_id field.
     * @var        int
     */
    protected $game_id;

    /**
     * The value for the user_id field.
     * @var        int
     */
    protected $user_id;

    /**
     * The value for the character_id field.
     * @var        int
     */
    protected $character_id;

    /**
     * The value for the is_amiral field.
     * @var        boolean
     */
    protected $is_amiral;

    /**
     * The value for the is_president field.
     * @var        boolean
     */
    protected $is_president;

    /**
     * The value for the is_cag field.
     * @var        boolean
     */
    protected $is_cag;

    /**
     * The value for the is_alive field.
     * @var        boolean
     */
    protected $is_alive;

    /**
     * @var        Game
     */
    protected $aGame;

    /**
     * @var        User
     */
    protected $aUser;

    /**
     * @var        Character
     */
    protected $aCharacter;

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
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [game_id] column value.
     *
     * @return int
     */
    public function getGameId()
    {
        return $this->game_id;
    }

    /**
     * Get the [user_id] column value.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Get the [character_id] column value.
     *
     * @return int
     */
    public function getCharacterId()
    {
        return $this->character_id;
    }

    /**
     * Get the [is_amiral] column value.
     *
     * @return boolean
     */
    public function getIsAmiral()
    {
        return $this->is_amiral;
    }

    /**
     * Get the [is_president] column value.
     *
     * @return boolean
     */
    public function getIsPresident()
    {
        return $this->is_president;
    }

    /**
     * Get the [is_cag] column value.
     *
     * @return boolean
     */
    public function getIsCag()
    {
        return $this->is_cag;
    }

    /**
     * Get the [is_alive] column value.
     *
     * @return boolean
     */
    public function getIsAlive()
    {
        return $this->is_alive;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return GamePlayer The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = GamePlayerPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [game_id] column.
     *
     * @param int $v new value
     * @return GamePlayer The current object (for fluent API support)
     */
    public function setGameId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->game_id !== $v) {
            $this->game_id = $v;
            $this->modifiedColumns[] = GamePlayerPeer::GAME_ID;
        }

        if ($this->aGame !== null && $this->aGame->getId() !== $v) {
            $this->aGame = null;
        }


        return $this;
    } // setGameId()

    /**
     * Set the value of [user_id] column.
     *
     * @param int $v new value
     * @return GamePlayer The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[] = GamePlayerPeer::USER_ID;
        }

        if ($this->aUser !== null && $this->aUser->getId() !== $v) {
            $this->aUser = null;
        }


        return $this;
    } // setUserId()

    /**
     * Set the value of [character_id] column.
     *
     * @param int $v new value
     * @return GamePlayer The current object (for fluent API support)
     */
    public function setCharacterId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->character_id !== $v) {
            $this->character_id = $v;
            $this->modifiedColumns[] = GamePlayerPeer::CHARACTER_ID;
        }

        if ($this->aCharacter !== null && $this->aCharacter->getId() !== $v) {
            $this->aCharacter = null;
        }


        return $this;
    } // setCharacterId()

    /**
     * Sets the value of the [is_amiral] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return GamePlayer The current object (for fluent API support)
     */
    public function setIsAmiral($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_amiral !== $v) {
            $this->is_amiral = $v;
            $this->modifiedColumns[] = GamePlayerPeer::IS_AMIRAL;
        }


        return $this;
    } // setIsAmiral()

    /**
     * Sets the value of the [is_president] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return GamePlayer The current object (for fluent API support)
     */
    public function setIsPresident($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_president !== $v) {
            $this->is_president = $v;
            $this->modifiedColumns[] = GamePlayerPeer::IS_PRESIDENT;
        }


        return $this;
    } // setIsPresident()

    /**
     * Sets the value of the [is_cag] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return GamePlayer The current object (for fluent API support)
     */
    public function setIsCag($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_cag !== $v) {
            $this->is_cag = $v;
            $this->modifiedColumns[] = GamePlayerPeer::IS_CAG;
        }


        return $this;
    } // setIsCag()

    /**
     * Sets the value of the [is_alive] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return GamePlayer The current object (for fluent API support)
     */
    public function setIsAlive($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_alive !== $v) {
            $this->is_alive = $v;
            $this->modifiedColumns[] = GamePlayerPeer::IS_ALIVE;
        }


        return $this;
    } // setIsAlive()

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
            $this->game_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->user_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->character_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->is_amiral = ($row[$startcol + 4] !== null) ? (boolean) $row[$startcol + 4] : null;
            $this->is_president = ($row[$startcol + 5] !== null) ? (boolean) $row[$startcol + 5] : null;
            $this->is_cag = ($row[$startcol + 6] !== null) ? (boolean) $row[$startcol + 6] : null;
            $this->is_alive = ($row[$startcol + 7] !== null) ? (boolean) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = GamePlayerPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating GamePlayer object", $e);
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

        if ($this->aGame !== null && $this->game_id !== $this->aGame->getId()) {
            $this->aGame = null;
        }
        if ($this->aUser !== null && $this->user_id !== $this->aUser->getId()) {
            $this->aUser = null;
        }
        if ($this->aCharacter !== null && $this->character_id !== $this->aCharacter->getId()) {
            $this->aCharacter = null;
        }
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
            $con = Propel::getConnection(GamePlayerPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = GamePlayerPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aGame = null;
            $this->aUser = null;
            $this->aCharacter = null;
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
            $con = Propel::getConnection(GamePlayerPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = GamePlayerQuery::create()
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
            $con = Propel::getConnection(GamePlayerPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                GamePlayerPeer::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aGame !== null) {
                if ($this->aGame->isModified() || $this->aGame->isNew()) {
                    $affectedRows += $this->aGame->save($con);
                }
                $this->setGame($this->aGame);
            }

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

            if ($this->aCharacter !== null) {
                if ($this->aCharacter->isModified() || $this->aCharacter->isNew()) {
                    $affectedRows += $this->aCharacter->save($con);
                }
                $this->setCharacter($this->aCharacter);
            }

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

        $this->modifiedColumns[] = GamePlayerPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . GamePlayerPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(GamePlayerPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`ID`';
        }
        if ($this->isColumnModified(GamePlayerPeer::GAME_ID)) {
            $modifiedColumns[':p' . $index++]  = '`GAME_ID`';
        }
        if ($this->isColumnModified(GamePlayerPeer::USER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`USER_ID`';
        }
        if ($this->isColumnModified(GamePlayerPeer::CHARACTER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`CHARACTER_ID`';
        }
        if ($this->isColumnModified(GamePlayerPeer::IS_AMIRAL)) {
            $modifiedColumns[':p' . $index++]  = '`IS_AMIRAL`';
        }
        if ($this->isColumnModified(GamePlayerPeer::IS_PRESIDENT)) {
            $modifiedColumns[':p' . $index++]  = '`IS_PRESIDENT`';
        }
        if ($this->isColumnModified(GamePlayerPeer::IS_CAG)) {
            $modifiedColumns[':p' . $index++]  = '`IS_CAG`';
        }
        if ($this->isColumnModified(GamePlayerPeer::IS_ALIVE)) {
            $modifiedColumns[':p' . $index++]  = '`IS_ALIVE`';
        }

        $sql = sprintf(
            'INSERT INTO `game_player` (%s) VALUES (%s)',
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
                    case '`GAME_ID`':
                        $stmt->bindValue($identifier, $this->game_id, PDO::PARAM_INT);
                        break;
                    case '`USER_ID`':
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
                        break;
                    case '`CHARACTER_ID`':
                        $stmt->bindValue($identifier, $this->character_id, PDO::PARAM_INT);
                        break;
                    case '`IS_AMIRAL`':
                        $stmt->bindValue($identifier, (int) $this->is_amiral, PDO::PARAM_INT);
                        break;
                    case '`IS_PRESIDENT`':
                        $stmt->bindValue($identifier, (int) $this->is_president, PDO::PARAM_INT);
                        break;
                    case '`IS_CAG`':
                        $stmt->bindValue($identifier, (int) $this->is_cag, PDO::PARAM_INT);
                        break;
                    case '`IS_ALIVE`':
                        $stmt->bindValue($identifier, (int) $this->is_alive, PDO::PARAM_INT);
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


            // We call the validate method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aGame !== null) {
                if (!$this->aGame->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aGame->getValidationFailures());
                }
            }

            if ($this->aUser !== null) {
                if (!$this->aUser->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aUser->getValidationFailures());
                }
            }

            if ($this->aCharacter !== null) {
                if (!$this->aCharacter->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCharacter->getValidationFailures());
                }
            }


            if (($retval = GamePlayerPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
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
        $pos = GamePlayerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getGameId();
                break;
            case 2:
                return $this->getUserId();
                break;
            case 3:
                return $this->getCharacterId();
                break;
            case 4:
                return $this->getIsAmiral();
                break;
            case 5:
                return $this->getIsPresident();
                break;
            case 6:
                return $this->getIsCag();
                break;
            case 7:
                return $this->getIsAlive();
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
        if (isset($alreadyDumpedObjects['GamePlayer'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['GamePlayer'][$this->getPrimaryKey()] = true;
        $keys = GamePlayerPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getGameId(),
            $keys[2] => $this->getUserId(),
            $keys[3] => $this->getCharacterId(),
            $keys[4] => $this->getIsAmiral(),
            $keys[5] => $this->getIsPresident(),
            $keys[6] => $this->getIsCag(),
            $keys[7] => $this->getIsAlive(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aGame) {
                $result['Game'] = $this->aGame->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUser) {
                $result['User'] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCharacter) {
                $result['Character'] = $this->aCharacter->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = GamePlayerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setGameId($value);
                break;
            case 2:
                $this->setUserId($value);
                break;
            case 3:
                $this->setCharacterId($value);
                break;
            case 4:
                $this->setIsAmiral($value);
                break;
            case 5:
                $this->setIsPresident($value);
                break;
            case 6:
                $this->setIsCag($value);
                break;
            case 7:
                $this->setIsAlive($value);
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
        $keys = GamePlayerPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setGameId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setUserId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setCharacterId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setIsAmiral($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setIsPresident($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setIsCag($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setIsAlive($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(GamePlayerPeer::DATABASE_NAME);

        if ($this->isColumnModified(GamePlayerPeer::ID)) $criteria->add(GamePlayerPeer::ID, $this->id);
        if ($this->isColumnModified(GamePlayerPeer::GAME_ID)) $criteria->add(GamePlayerPeer::GAME_ID, $this->game_id);
        if ($this->isColumnModified(GamePlayerPeer::USER_ID)) $criteria->add(GamePlayerPeer::USER_ID, $this->user_id);
        if ($this->isColumnModified(GamePlayerPeer::CHARACTER_ID)) $criteria->add(GamePlayerPeer::CHARACTER_ID, $this->character_id);
        if ($this->isColumnModified(GamePlayerPeer::IS_AMIRAL)) $criteria->add(GamePlayerPeer::IS_AMIRAL, $this->is_amiral);
        if ($this->isColumnModified(GamePlayerPeer::IS_PRESIDENT)) $criteria->add(GamePlayerPeer::IS_PRESIDENT, $this->is_president);
        if ($this->isColumnModified(GamePlayerPeer::IS_CAG)) $criteria->add(GamePlayerPeer::IS_CAG, $this->is_cag);
        if ($this->isColumnModified(GamePlayerPeer::IS_ALIVE)) $criteria->add(GamePlayerPeer::IS_ALIVE, $this->is_alive);

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
        $criteria = new Criteria(GamePlayerPeer::DATABASE_NAME);
        $criteria->add(GamePlayerPeer::ID, $this->id);

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
     * @param object $copyObj An object of GamePlayer (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setGameId($this->getGameId());
        $copyObj->setUserId($this->getUserId());
        $copyObj->setCharacterId($this->getCharacterId());
        $copyObj->setIsAmiral($this->getIsAmiral());
        $copyObj->setIsPresident($this->getIsPresident());
        $copyObj->setIsCag($this->getIsCag());
        $copyObj->setIsAlive($this->getIsAlive());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

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
     * @return GamePlayer Clone of current object.
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
     * @return GamePlayerPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new GamePlayerPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Game object.
     *
     * @param             Game $v
     * @return GamePlayer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setGame(Game $v = null)
    {
        if ($v === null) {
            $this->setGameId(NULL);
        } else {
            $this->setGameId($v->getId());
        }

        $this->aGame = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Game object, it will not be re-added.
        if ($v !== null) {
            $v->addGamePlayer($this);
        }


        return $this;
    }


    /**
     * Get the associated Game object
     *
     * @param PropelPDO $con Optional Connection object.
     * @return Game The associated Game object.
     * @throws PropelException
     */
    public function getGame(PropelPDO $con = null)
    {
        if ($this->aGame === null && ($this->game_id !== null)) {
            $this->aGame = GameQuery::create()->findPk($this->game_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aGame->addGamePlayers($this);
             */
        }

        return $this->aGame;
    }

    /**
     * Declares an association between this object and a User object.
     *
     * @param             User $v
     * @return GamePlayer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(User $v = null)
    {
        if ($v === null) {
            $this->setUserId(NULL);
        } else {
            $this->setUserId($v->getId());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the User object, it will not be re-added.
        if ($v !== null) {
            $v->addGamePlayer($this);
        }


        return $this;
    }


    /**
     * Get the associated User object
     *
     * @param PropelPDO $con Optional Connection object.
     * @return User The associated User object.
     * @throws PropelException
     */
    public function getUser(PropelPDO $con = null)
    {
        if ($this->aUser === null && ($this->user_id !== null)) {
            $this->aUser = UserQuery::create()->findPk($this->user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addGamePlayers($this);
             */
        }

        return $this->aUser;
    }

    /**
     * Declares an association between this object and a Character object.
     *
     * @param             Character $v
     * @return GamePlayer The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCharacter(Character $v = null)
    {
        if ($v === null) {
            $this->setCharacterId(NULL);
        } else {
            $this->setCharacterId($v->getId());
        }

        $this->aCharacter = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Character object, it will not be re-added.
        if ($v !== null) {
            $v->addGamePlayer($this);
        }


        return $this;
    }


    /**
     * Get the associated Character object
     *
     * @param PropelPDO $con Optional Connection object.
     * @return Character The associated Character object.
     * @throws PropelException
     */
    public function getCharacter(PropelPDO $con = null)
    {
        if ($this->aCharacter === null && ($this->character_id !== null)) {
            $this->aCharacter = CharacterQuery::create()->findPk($this->character_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCharacter->addGamePlayers($this);
             */
        }

        return $this->aCharacter;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->game_id = null;
        $this->user_id = null;
        $this->character_id = null;
        $this->is_amiral = null;
        $this->is_president = null;
        $this->is_cag = null;
        $this->is_alive = null;
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
        } // if ($deep)

        $this->aGame = null;
        $this->aUser = null;
        $this->aCharacter = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(GamePlayerPeer::DEFAULT_STRING_FORMAT);
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
