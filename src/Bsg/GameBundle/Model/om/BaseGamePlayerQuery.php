<?php

namespace Bsg\GameBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Bsg\GameBundle\Model\Character;
use Bsg\GameBundle\Model\Game;
use Bsg\GameBundle\Model\GamePlayer;
use Bsg\GameBundle\Model\GamePlayerPeer;
use Bsg\GameBundle\Model\GamePlayerQuery;
use FOS\UserBundle\Propel\User;

/**
 * @method GamePlayerQuery orderById($order = Criteria::ASC) Order by the id column
 * @method GamePlayerQuery orderByGameId($order = Criteria::ASC) Order by the game_id column
 * @method GamePlayerQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method GamePlayerQuery orderByCharacterId($order = Criteria::ASC) Order by the character_id column
 * @method GamePlayerQuery orderByIsAmiral($order = Criteria::ASC) Order by the is_amiral column
 * @method GamePlayerQuery orderByIsPresident($order = Criteria::ASC) Order by the is_president column
 * @method GamePlayerQuery orderByIsCag($order = Criteria::ASC) Order by the is_cag column
 * @method GamePlayerQuery orderByIsAlive($order = Criteria::ASC) Order by the is_alive column
 *
 * @method GamePlayerQuery groupById() Group by the id column
 * @method GamePlayerQuery groupByGameId() Group by the game_id column
 * @method GamePlayerQuery groupByUserId() Group by the user_id column
 * @method GamePlayerQuery groupByCharacterId() Group by the character_id column
 * @method GamePlayerQuery groupByIsAmiral() Group by the is_amiral column
 * @method GamePlayerQuery groupByIsPresident() Group by the is_president column
 * @method GamePlayerQuery groupByIsCag() Group by the is_cag column
 * @method GamePlayerQuery groupByIsAlive() Group by the is_alive column
 *
 * @method GamePlayerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method GamePlayerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method GamePlayerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method GamePlayerQuery leftJoinGame($relationAlias = null) Adds a LEFT JOIN clause to the query using the Game relation
 * @method GamePlayerQuery rightJoinGame($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Game relation
 * @method GamePlayerQuery innerJoinGame($relationAlias = null) Adds a INNER JOIN clause to the query using the Game relation
 *
 * @method GamePlayerQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method GamePlayerQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method GamePlayerQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method GamePlayerQuery leftJoinCharacter($relationAlias = null) Adds a LEFT JOIN clause to the query using the Character relation
 * @method GamePlayerQuery rightJoinCharacter($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Character relation
 * @method GamePlayerQuery innerJoinCharacter($relationAlias = null) Adds a INNER JOIN clause to the query using the Character relation
 *
 * @method GamePlayer findOne(PropelPDO $con = null) Return the first GamePlayer matching the query
 * @method GamePlayer findOneOrCreate(PropelPDO $con = null) Return the first GamePlayer matching the query, or a new GamePlayer object populated from the query conditions when no match is found
 *
 * @method GamePlayer findOneById(int $id) Return the first GamePlayer filtered by the id column
 * @method GamePlayer findOneByGameId(int $game_id) Return the first GamePlayer filtered by the game_id column
 * @method GamePlayer findOneByUserId(int $user_id) Return the first GamePlayer filtered by the user_id column
 * @method GamePlayer findOneByCharacterId(int $character_id) Return the first GamePlayer filtered by the character_id column
 * @method GamePlayer findOneByIsAmiral(boolean $is_amiral) Return the first GamePlayer filtered by the is_amiral column
 * @method GamePlayer findOneByIsPresident(boolean $is_president) Return the first GamePlayer filtered by the is_president column
 * @method GamePlayer findOneByIsCag(boolean $is_cag) Return the first GamePlayer filtered by the is_cag column
 * @method GamePlayer findOneByIsAlive(boolean $is_alive) Return the first GamePlayer filtered by the is_alive column
 *
 * @method array findById(int $id) Return GamePlayer objects filtered by the id column
 * @method array findByGameId(int $game_id) Return GamePlayer objects filtered by the game_id column
 * @method array findByUserId(int $user_id) Return GamePlayer objects filtered by the user_id column
 * @method array findByCharacterId(int $character_id) Return GamePlayer objects filtered by the character_id column
 * @method array findByIsAmiral(boolean $is_amiral) Return GamePlayer objects filtered by the is_amiral column
 * @method array findByIsPresident(boolean $is_president) Return GamePlayer objects filtered by the is_president column
 * @method array findByIsCag(boolean $is_cag) Return GamePlayer objects filtered by the is_cag column
 * @method array findByIsAlive(boolean $is_alive) Return GamePlayer objects filtered by the is_alive column
 */
abstract class BaseGamePlayerQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseGamePlayerQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'Bsg\\GameBundle\\Model\\GamePlayer', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new GamePlayerQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     GamePlayerQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return GamePlayerQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof GamePlayerQuery) {
            return $criteria;
        }
        $query = new GamePlayerQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   GamePlayer|GamePlayer[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = GamePlayerPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(GamePlayerPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return   GamePlayer A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `ID`, `GAME_ID`, `USER_ID`, `CHARACTER_ID`, `IS_AMIRAL`, `IS_PRESIDENT`, `IS_CAG`, `IS_ALIVE` FROM `game_player` WHERE `ID` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new GamePlayer();
            $obj->hydrate($row);
            GamePlayerPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return GamePlayer|GamePlayer[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|GamePlayer[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return GamePlayerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GamePlayerPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return GamePlayerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GamePlayerPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GamePlayerQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(GamePlayerPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the game_id column
     *
     * Example usage:
     * <code>
     * $query->filterByGameId(1234); // WHERE game_id = 1234
     * $query->filterByGameId(array(12, 34)); // WHERE game_id IN (12, 34)
     * $query->filterByGameId(array('min' => 12)); // WHERE game_id > 12
     * </code>
     *
     * @see       filterByGame()
     *
     * @param     mixed $gameId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GamePlayerQuery The current query, for fluid interface
     */
    public function filterByGameId($gameId = null, $comparison = null)
    {
        if (is_array($gameId)) {
            $useMinMax = false;
            if (isset($gameId['min'])) {
                $this->addUsingAlias(GamePlayerPeer::GAME_ID, $gameId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gameId['max'])) {
                $this->addUsingAlias(GamePlayerPeer::GAME_ID, $gameId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamePlayerPeer::GAME_ID, $gameId, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GamePlayerQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(GamePlayerPeer::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(GamePlayerPeer::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamePlayerPeer::USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the character_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCharacterId(1234); // WHERE character_id = 1234
     * $query->filterByCharacterId(array(12, 34)); // WHERE character_id IN (12, 34)
     * $query->filterByCharacterId(array('min' => 12)); // WHERE character_id > 12
     * </code>
     *
     * @see       filterByCharacter()
     *
     * @param     mixed $characterId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GamePlayerQuery The current query, for fluid interface
     */
    public function filterByCharacterId($characterId = null, $comparison = null)
    {
        if (is_array($characterId)) {
            $useMinMax = false;
            if (isset($characterId['min'])) {
                $this->addUsingAlias(GamePlayerPeer::CHARACTER_ID, $characterId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($characterId['max'])) {
                $this->addUsingAlias(GamePlayerPeer::CHARACTER_ID, $characterId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamePlayerPeer::CHARACTER_ID, $characterId, $comparison);
    }

    /**
     * Filter the query on the is_amiral column
     *
     * Example usage:
     * <code>
     * $query->filterByIsAmiral(true); // WHERE is_amiral = true
     * $query->filterByIsAmiral('yes'); // WHERE is_amiral = true
     * </code>
     *
     * @param     boolean|string $isAmiral The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GamePlayerQuery The current query, for fluid interface
     */
    public function filterByIsAmiral($isAmiral = null, $comparison = null)
    {
        if (is_string($isAmiral)) {
            $is_amiral = in_array(strtolower($isAmiral), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(GamePlayerPeer::IS_AMIRAL, $isAmiral, $comparison);
    }

    /**
     * Filter the query on the is_president column
     *
     * Example usage:
     * <code>
     * $query->filterByIsPresident(true); // WHERE is_president = true
     * $query->filterByIsPresident('yes'); // WHERE is_president = true
     * </code>
     *
     * @param     boolean|string $isPresident The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GamePlayerQuery The current query, for fluid interface
     */
    public function filterByIsPresident($isPresident = null, $comparison = null)
    {
        if (is_string($isPresident)) {
            $is_president = in_array(strtolower($isPresident), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(GamePlayerPeer::IS_PRESIDENT, $isPresident, $comparison);
    }

    /**
     * Filter the query on the is_cag column
     *
     * Example usage:
     * <code>
     * $query->filterByIsCag(true); // WHERE is_cag = true
     * $query->filterByIsCag('yes'); // WHERE is_cag = true
     * </code>
     *
     * @param     boolean|string $isCag The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GamePlayerQuery The current query, for fluid interface
     */
    public function filterByIsCag($isCag = null, $comparison = null)
    {
        if (is_string($isCag)) {
            $is_cag = in_array(strtolower($isCag), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(GamePlayerPeer::IS_CAG, $isCag, $comparison);
    }

    /**
     * Filter the query on the is_alive column
     *
     * Example usage:
     * <code>
     * $query->filterByIsAlive(true); // WHERE is_alive = true
     * $query->filterByIsAlive('yes'); // WHERE is_alive = true
     * </code>
     *
     * @param     boolean|string $isAlive The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GamePlayerQuery The current query, for fluid interface
     */
    public function filterByIsAlive($isAlive = null, $comparison = null)
    {
        if (is_string($isAlive)) {
            $is_alive = in_array(strtolower($isAlive), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(GamePlayerPeer::IS_ALIVE, $isAlive, $comparison);
    }

    /**
     * Filter the query by a related Game object
     *
     * @param   Game|PropelObjectCollection $game The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   GamePlayerQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByGame($game, $comparison = null)
    {
        if ($game instanceof Game) {
            return $this
                ->addUsingAlias(GamePlayerPeer::GAME_ID, $game->getId(), $comparison);
        } elseif ($game instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GamePlayerPeer::GAME_ID, $game->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByGame() only accepts arguments of type Game or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Game relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return GamePlayerQuery The current query, for fluid interface
     */
    public function joinGame($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Game');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Game');
        }

        return $this;
    }

    /**
     * Use the Game relation Game object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Bsg\GameBundle\Model\GameQuery A secondary query class using the current class as primary query
     */
    public function useGameQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGame($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Game', '\Bsg\GameBundle\Model\GameQuery');
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   GamePlayerQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(GamePlayerPeer::USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GamePlayerPeer::USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type User or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return GamePlayerQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \FOS\UserBundle\Propel\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\FOS\UserBundle\Propel\UserQuery');
    }

    /**
     * Filter the query by a related Character object
     *
     * @param   Character|PropelObjectCollection $character The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   GamePlayerQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByCharacter($character, $comparison = null)
    {
        if ($character instanceof Character) {
            return $this
                ->addUsingAlias(GamePlayerPeer::CHARACTER_ID, $character->getId(), $comparison);
        } elseif ($character instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GamePlayerPeer::CHARACTER_ID, $character->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCharacter() only accepts arguments of type Character or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Character relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return GamePlayerQuery The current query, for fluid interface
     */
    public function joinCharacter($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Character');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Character');
        }

        return $this;
    }

    /**
     * Use the Character relation Character object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Bsg\GameBundle\Model\CharacterQuery A secondary query class using the current class as primary query
     */
    public function useCharacterQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCharacter($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Character', '\Bsg\GameBundle\Model\CharacterQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   GamePlayer $gamePlayer Object to remove from the list of results
     *
     * @return GamePlayerQuery The current query, for fluid interface
     */
    public function prune($gamePlayer = null)
    {
        if ($gamePlayer) {
            $this->addUsingAlias(GamePlayerPeer::ID, $gamePlayer->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
