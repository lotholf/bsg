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
use Bsg\GameBundle\Model\Game;
use Bsg\GameBundle\Model\GamePeer;
use Bsg\GameBundle\Model\GamePlayer;
use Bsg\GameBundle\Model\GameQuery;

/**
 * @method GameQuery orderById($order = Criteria::ASC) Order by the id column
 * @method GameQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method GameQuery orderByFuel($order = Criteria::ASC) Order by the fuel column
 * @method GameQuery orderByFood($order = Criteria::ASC) Order by the food column
 * @method GameQuery orderByMorale($order = Criteria::ASC) Order by the morale column
 * @method GameQuery orderByPopulation($order = Criteria::ASC) Order by the population column
 * @method GameQuery orderByDistance($order = Criteria::ASC) Order by the distance column
 * @method GameQuery orderByJump($order = Criteria::ASC) Order by the jump column
 * @method GameQuery orderByIsCompleted($order = Criteria::ASC) Order by the is_completed column
 *
 * @method GameQuery groupById() Group by the id column
 * @method GameQuery groupByName() Group by the name column
 * @method GameQuery groupByFuel() Group by the fuel column
 * @method GameQuery groupByFood() Group by the food column
 * @method GameQuery groupByMorale() Group by the morale column
 * @method GameQuery groupByPopulation() Group by the population column
 * @method GameQuery groupByDistance() Group by the distance column
 * @method GameQuery groupByJump() Group by the jump column
 * @method GameQuery groupByIsCompleted() Group by the is_completed column
 *
 * @method GameQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method GameQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method GameQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method GameQuery leftJoinGamePlayer($relationAlias = null) Adds a LEFT JOIN clause to the query using the GamePlayer relation
 * @method GameQuery rightJoinGamePlayer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GamePlayer relation
 * @method GameQuery innerJoinGamePlayer($relationAlias = null) Adds a INNER JOIN clause to the query using the GamePlayer relation
 *
 * @method Game findOne(PropelPDO $con = null) Return the first Game matching the query
 * @method Game findOneOrCreate(PropelPDO $con = null) Return the first Game matching the query, or a new Game object populated from the query conditions when no match is found
 *
 * @method Game findOneById(int $id) Return the first Game filtered by the id column
 * @method Game findOneByName(string $name) Return the first Game filtered by the name column
 * @method Game findOneByFuel(int $fuel) Return the first Game filtered by the fuel column
 * @method Game findOneByFood(int $food) Return the first Game filtered by the food column
 * @method Game findOneByMorale(int $morale) Return the first Game filtered by the morale column
 * @method Game findOneByPopulation(int $population) Return the first Game filtered by the population column
 * @method Game findOneByDistance(int $distance) Return the first Game filtered by the distance column
 * @method Game findOneByJump(int $jump) Return the first Game filtered by the jump column
 * @method Game findOneByIsCompleted(boolean $is_completed) Return the first Game filtered by the is_completed column
 *
 * @method array findById(int $id) Return Game objects filtered by the id column
 * @method array findByName(string $name) Return Game objects filtered by the name column
 * @method array findByFuel(int $fuel) Return Game objects filtered by the fuel column
 * @method array findByFood(int $food) Return Game objects filtered by the food column
 * @method array findByMorale(int $morale) Return Game objects filtered by the morale column
 * @method array findByPopulation(int $population) Return Game objects filtered by the population column
 * @method array findByDistance(int $distance) Return Game objects filtered by the distance column
 * @method array findByJump(int $jump) Return Game objects filtered by the jump column
 * @method array findByIsCompleted(boolean $is_completed) Return Game objects filtered by the is_completed column
 */
abstract class BaseGameQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseGameQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'Bsg\\GameBundle\\Model\\Game', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new GameQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     GameQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return GameQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof GameQuery) {
            return $criteria;
        }
        $query = new GameQuery();
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
     * @return   Game|Game[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = GamePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(GamePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return   Game A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `ID`, `NAME`, `FUEL`, `FOOD`, `MORALE`, `POPULATION`, `DISTANCE`, `JUMP`, `IS_COMPLETED` FROM `game` WHERE `ID` = :p0';
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
            $obj = new Game();
            $obj->hydrate($row);
            GamePeer::addInstanceToPool($obj, (string) $key);
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
     * @return Game|Game[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Game[]|mixed the list of results, formatted by the current formatter
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
     * @return GameQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GamePeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return GameQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GamePeer::ID, $keys, Criteria::IN);
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
     * @return GameQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(GamePeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GameQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(GamePeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the fuel column
     *
     * Example usage:
     * <code>
     * $query->filterByFuel(1234); // WHERE fuel = 1234
     * $query->filterByFuel(array(12, 34)); // WHERE fuel IN (12, 34)
     * $query->filterByFuel(array('min' => 12)); // WHERE fuel > 12
     * </code>
     *
     * @param     mixed $fuel The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GameQuery The current query, for fluid interface
     */
    public function filterByFuel($fuel = null, $comparison = null)
    {
        if (is_array($fuel)) {
            $useMinMax = false;
            if (isset($fuel['min'])) {
                $this->addUsingAlias(GamePeer::FUEL, $fuel['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fuel['max'])) {
                $this->addUsingAlias(GamePeer::FUEL, $fuel['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamePeer::FUEL, $fuel, $comparison);
    }

    /**
     * Filter the query on the food column
     *
     * Example usage:
     * <code>
     * $query->filterByFood(1234); // WHERE food = 1234
     * $query->filterByFood(array(12, 34)); // WHERE food IN (12, 34)
     * $query->filterByFood(array('min' => 12)); // WHERE food > 12
     * </code>
     *
     * @param     mixed $food The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GameQuery The current query, for fluid interface
     */
    public function filterByFood($food = null, $comparison = null)
    {
        if (is_array($food)) {
            $useMinMax = false;
            if (isset($food['min'])) {
                $this->addUsingAlias(GamePeer::FOOD, $food['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($food['max'])) {
                $this->addUsingAlias(GamePeer::FOOD, $food['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamePeer::FOOD, $food, $comparison);
    }

    /**
     * Filter the query on the morale column
     *
     * Example usage:
     * <code>
     * $query->filterByMorale(1234); // WHERE morale = 1234
     * $query->filterByMorale(array(12, 34)); // WHERE morale IN (12, 34)
     * $query->filterByMorale(array('min' => 12)); // WHERE morale > 12
     * </code>
     *
     * @param     mixed $morale The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GameQuery The current query, for fluid interface
     */
    public function filterByMorale($morale = null, $comparison = null)
    {
        if (is_array($morale)) {
            $useMinMax = false;
            if (isset($morale['min'])) {
                $this->addUsingAlias(GamePeer::MORALE, $morale['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($morale['max'])) {
                $this->addUsingAlias(GamePeer::MORALE, $morale['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamePeer::MORALE, $morale, $comparison);
    }

    /**
     * Filter the query on the population column
     *
     * Example usage:
     * <code>
     * $query->filterByPopulation(1234); // WHERE population = 1234
     * $query->filterByPopulation(array(12, 34)); // WHERE population IN (12, 34)
     * $query->filterByPopulation(array('min' => 12)); // WHERE population > 12
     * </code>
     *
     * @param     mixed $population The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GameQuery The current query, for fluid interface
     */
    public function filterByPopulation($population = null, $comparison = null)
    {
        if (is_array($population)) {
            $useMinMax = false;
            if (isset($population['min'])) {
                $this->addUsingAlias(GamePeer::POPULATION, $population['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($population['max'])) {
                $this->addUsingAlias(GamePeer::POPULATION, $population['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamePeer::POPULATION, $population, $comparison);
    }

    /**
     * Filter the query on the distance column
     *
     * Example usage:
     * <code>
     * $query->filterByDistance(1234); // WHERE distance = 1234
     * $query->filterByDistance(array(12, 34)); // WHERE distance IN (12, 34)
     * $query->filterByDistance(array('min' => 12)); // WHERE distance > 12
     * </code>
     *
     * @param     mixed $distance The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GameQuery The current query, for fluid interface
     */
    public function filterByDistance($distance = null, $comparison = null)
    {
        if (is_array($distance)) {
            $useMinMax = false;
            if (isset($distance['min'])) {
                $this->addUsingAlias(GamePeer::DISTANCE, $distance['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($distance['max'])) {
                $this->addUsingAlias(GamePeer::DISTANCE, $distance['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamePeer::DISTANCE, $distance, $comparison);
    }

    /**
     * Filter the query on the jump column
     *
     * Example usage:
     * <code>
     * $query->filterByJump(1234); // WHERE jump = 1234
     * $query->filterByJump(array(12, 34)); // WHERE jump IN (12, 34)
     * $query->filterByJump(array('min' => 12)); // WHERE jump > 12
     * </code>
     *
     * @param     mixed $jump The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GameQuery The current query, for fluid interface
     */
    public function filterByJump($jump = null, $comparison = null)
    {
        if (is_array($jump)) {
            $useMinMax = false;
            if (isset($jump['min'])) {
                $this->addUsingAlias(GamePeer::JUMP, $jump['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($jump['max'])) {
                $this->addUsingAlias(GamePeer::JUMP, $jump['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GamePeer::JUMP, $jump, $comparison);
    }

    /**
     * Filter the query on the is_completed column
     *
     * Example usage:
     * <code>
     * $query->filterByIsCompleted(true); // WHERE is_completed = true
     * $query->filterByIsCompleted('yes'); // WHERE is_completed = true
     * </code>
     *
     * @param     boolean|string $isCompleted The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GameQuery The current query, for fluid interface
     */
    public function filterByIsCompleted($isCompleted = null, $comparison = null)
    {
        if (is_string($isCompleted)) {
            $is_completed = in_array(strtolower($isCompleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(GamePeer::IS_COMPLETED, $isCompleted, $comparison);
    }

    /**
     * Filter the query by a related GamePlayer object
     *
     * @param   GamePlayer|PropelObjectCollection $gamePlayer  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   GameQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByGamePlayer($gamePlayer, $comparison = null)
    {
        if ($gamePlayer instanceof GamePlayer) {
            return $this
                ->addUsingAlias(GamePeer::ID, $gamePlayer->getGameId(), $comparison);
        } elseif ($gamePlayer instanceof PropelObjectCollection) {
            return $this
                ->useGamePlayerQuery()
                ->filterByPrimaryKeys($gamePlayer->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGamePlayer() only accepts arguments of type GamePlayer or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GamePlayer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return GameQuery The current query, for fluid interface
     */
    public function joinGamePlayer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GamePlayer');

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
            $this->addJoinObject($join, 'GamePlayer');
        }

        return $this;
    }

    /**
     * Use the GamePlayer relation GamePlayer object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Bsg\GameBundle\Model\GamePlayerQuery A secondary query class using the current class as primary query
     */
    public function useGamePlayerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGamePlayer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GamePlayer', '\Bsg\GameBundle\Model\GamePlayerQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Game $game Object to remove from the list of results
     *
     * @return GameQuery The current query, for fluid interface
     */
    public function prune($game = null)
    {
        if ($game) {
            $this->addUsingAlias(GamePeer::ID, $game->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
