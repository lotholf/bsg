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
use Bsg\GameBundle\Model\CharacterPeer;
use Bsg\GameBundle\Model\CharacterQuery;
use Bsg\GameBundle\Model\GamePlayer;

/**
 * @method CharacterQuery orderById($order = Criteria::ASC) Order by the id column
 * @method CharacterQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method CharacterQuery orderByPower($order = Criteria::ASC) Order by the power column
 * @method CharacterQuery orderByPowerOnePerGame($order = Criteria::ASC) Order by the power_one_per_game column
 * @method CharacterQuery orderByDrawback($order = Criteria::ASC) Order by the drawback column
 * @method CharacterQuery orderByCards($order = Criteria::ASC) Order by the cards column
 * @method CharacterQuery orderByRole($order = Criteria::ASC) Order by the role column
 * @method CharacterQuery orderByAmiralOrder($order = Criteria::ASC) Order by the amiral_order column
 * @method CharacterQuery orderByPresidentOrder($order = Criteria::ASC) Order by the president_order column
 * @method CharacterQuery orderByCagOrder($order = Criteria::ASC) Order by the cag_order column
 *
 * @method CharacterQuery groupById() Group by the id column
 * @method CharacterQuery groupByName() Group by the name column
 * @method CharacterQuery groupByPower() Group by the power column
 * @method CharacterQuery groupByPowerOnePerGame() Group by the power_one_per_game column
 * @method CharacterQuery groupByDrawback() Group by the drawback column
 * @method CharacterQuery groupByCards() Group by the cards column
 * @method CharacterQuery groupByRole() Group by the role column
 * @method CharacterQuery groupByAmiralOrder() Group by the amiral_order column
 * @method CharacterQuery groupByPresidentOrder() Group by the president_order column
 * @method CharacterQuery groupByCagOrder() Group by the cag_order column
 *
 * @method CharacterQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CharacterQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CharacterQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method CharacterQuery leftJoinGamePlayer($relationAlias = null) Adds a LEFT JOIN clause to the query using the GamePlayer relation
 * @method CharacterQuery rightJoinGamePlayer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GamePlayer relation
 * @method CharacterQuery innerJoinGamePlayer($relationAlias = null) Adds a INNER JOIN clause to the query using the GamePlayer relation
 *
 * @method Character findOne(PropelPDO $con = null) Return the first Character matching the query
 * @method Character findOneOrCreate(PropelPDO $con = null) Return the first Character matching the query, or a new Character object populated from the query conditions when no match is found
 *
 * @method Character findOneById(int $id) Return the first Character filtered by the id column
 * @method Character findOneByName(string $name) Return the first Character filtered by the name column
 * @method Character findOneByPower(string $power) Return the first Character filtered by the power column
 * @method Character findOneByPowerOnePerGame(string $power_one_per_game) Return the first Character filtered by the power_one_per_game column
 * @method Character findOneByDrawback(string $drawback) Return the first Character filtered by the drawback column
 * @method Character findOneByCards(string $cards) Return the first Character filtered by the cards column
 * @method Character findOneByRole(string $role) Return the first Character filtered by the role column
 * @method Character findOneByAmiralOrder(int $amiral_order) Return the first Character filtered by the amiral_order column
 * @method Character findOneByPresidentOrder(int $president_order) Return the first Character filtered by the president_order column
 * @method Character findOneByCagOrder(int $cag_order) Return the first Character filtered by the cag_order column
 *
 * @method array findById(int $id) Return Character objects filtered by the id column
 * @method array findByName(string $name) Return Character objects filtered by the name column
 * @method array findByPower(string $power) Return Character objects filtered by the power column
 * @method array findByPowerOnePerGame(string $power_one_per_game) Return Character objects filtered by the power_one_per_game column
 * @method array findByDrawback(string $drawback) Return Character objects filtered by the drawback column
 * @method array findByCards(string $cards) Return Character objects filtered by the cards column
 * @method array findByRole(string $role) Return Character objects filtered by the role column
 * @method array findByAmiralOrder(int $amiral_order) Return Character objects filtered by the amiral_order column
 * @method array findByPresidentOrder(int $president_order) Return Character objects filtered by the president_order column
 * @method array findByCagOrder(int $cag_order) Return Character objects filtered by the cag_order column
 */
abstract class BaseCharacterQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseCharacterQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'Bsg\\GameBundle\\Model\\Character', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new CharacterQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     CharacterQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return CharacterQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof CharacterQuery) {
            return $criteria;
        }
        $query = new CharacterQuery();
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
     * @return   Character|Character[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CharacterPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(CharacterPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return   Character A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `ID`, `NAME`, `POWER`, `POWER_ONE_PER_GAME`, `DRAWBACK`, `CARDS`, `ROLE`, `AMIRAL_ORDER`, `PRESIDENT_ORDER`, `CAG_ORDER` FROM `character` WHERE `ID` = :p0';
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
            $obj = new Character();
            $obj->hydrate($row);
            CharacterPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Character|Character[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Character[]|mixed the list of results, formatted by the current formatter
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
     * @return CharacterQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CharacterPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return CharacterQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CharacterPeer::ID, $keys, Criteria::IN);
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
     * @return CharacterQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(CharacterPeer::ID, $id, $comparison);
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
     * @return CharacterQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CharacterPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the power column
     *
     * Example usage:
     * <code>
     * $query->filterByPower('fooValue');   // WHERE power = 'fooValue'
     * $query->filterByPower('%fooValue%'); // WHERE power LIKE '%fooValue%'
     * </code>
     *
     * @param     string $power The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CharacterQuery The current query, for fluid interface
     */
    public function filterByPower($power = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($power)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $power)) {
                $power = str_replace('*', '%', $power);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CharacterPeer::POWER, $power, $comparison);
    }

    /**
     * Filter the query on the power_one_per_game column
     *
     * Example usage:
     * <code>
     * $query->filterByPowerOnePerGame('fooValue');   // WHERE power_one_per_game = 'fooValue'
     * $query->filterByPowerOnePerGame('%fooValue%'); // WHERE power_one_per_game LIKE '%fooValue%'
     * </code>
     *
     * @param     string $powerOnePerGame The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CharacterQuery The current query, for fluid interface
     */
    public function filterByPowerOnePerGame($powerOnePerGame = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($powerOnePerGame)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $powerOnePerGame)) {
                $powerOnePerGame = str_replace('*', '%', $powerOnePerGame);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CharacterPeer::POWER_ONE_PER_GAME, $powerOnePerGame, $comparison);
    }

    /**
     * Filter the query on the drawback column
     *
     * Example usage:
     * <code>
     * $query->filterByDrawback('fooValue');   // WHERE drawback = 'fooValue'
     * $query->filterByDrawback('%fooValue%'); // WHERE drawback LIKE '%fooValue%'
     * </code>
     *
     * @param     string $drawback The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CharacterQuery The current query, for fluid interface
     */
    public function filterByDrawback($drawback = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($drawback)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $drawback)) {
                $drawback = str_replace('*', '%', $drawback);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CharacterPeer::DRAWBACK, $drawback, $comparison);
    }

    /**
     * Filter the query on the cards column
     *
     * Example usage:
     * <code>
     * $query->filterByCards('fooValue');   // WHERE cards = 'fooValue'
     * $query->filterByCards('%fooValue%'); // WHERE cards LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cards The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CharacterQuery The current query, for fluid interface
     */
    public function filterByCards($cards = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cards)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cards)) {
                $cards = str_replace('*', '%', $cards);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CharacterPeer::CARDS, $cards, $comparison);
    }

    /**
     * Filter the query on the role column
     *
     * Example usage:
     * <code>
     * $query->filterByRole('fooValue');   // WHERE role = 'fooValue'
     * $query->filterByRole('%fooValue%'); // WHERE role LIKE '%fooValue%'
     * </code>
     *
     * @param     string $role The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CharacterQuery The current query, for fluid interface
     */
    public function filterByRole($role = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($role)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $role)) {
                $role = str_replace('*', '%', $role);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CharacterPeer::ROLE, $role, $comparison);
    }

    /**
     * Filter the query on the amiral_order column
     *
     * Example usage:
     * <code>
     * $query->filterByAmiralOrder(1234); // WHERE amiral_order = 1234
     * $query->filterByAmiralOrder(array(12, 34)); // WHERE amiral_order IN (12, 34)
     * $query->filterByAmiralOrder(array('min' => 12)); // WHERE amiral_order > 12
     * </code>
     *
     * @param     mixed $amiralOrder The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CharacterQuery The current query, for fluid interface
     */
    public function filterByAmiralOrder($amiralOrder = null, $comparison = null)
    {
        if (is_array($amiralOrder)) {
            $useMinMax = false;
            if (isset($amiralOrder['min'])) {
                $this->addUsingAlias(CharacterPeer::AMIRAL_ORDER, $amiralOrder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($amiralOrder['max'])) {
                $this->addUsingAlias(CharacterPeer::AMIRAL_ORDER, $amiralOrder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharacterPeer::AMIRAL_ORDER, $amiralOrder, $comparison);
    }

    /**
     * Filter the query on the president_order column
     *
     * Example usage:
     * <code>
     * $query->filterByPresidentOrder(1234); // WHERE president_order = 1234
     * $query->filterByPresidentOrder(array(12, 34)); // WHERE president_order IN (12, 34)
     * $query->filterByPresidentOrder(array('min' => 12)); // WHERE president_order > 12
     * </code>
     *
     * @param     mixed $presidentOrder The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CharacterQuery The current query, for fluid interface
     */
    public function filterByPresidentOrder($presidentOrder = null, $comparison = null)
    {
        if (is_array($presidentOrder)) {
            $useMinMax = false;
            if (isset($presidentOrder['min'])) {
                $this->addUsingAlias(CharacterPeer::PRESIDENT_ORDER, $presidentOrder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($presidentOrder['max'])) {
                $this->addUsingAlias(CharacterPeer::PRESIDENT_ORDER, $presidentOrder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharacterPeer::PRESIDENT_ORDER, $presidentOrder, $comparison);
    }

    /**
     * Filter the query on the cag_order column
     *
     * Example usage:
     * <code>
     * $query->filterByCagOrder(1234); // WHERE cag_order = 1234
     * $query->filterByCagOrder(array(12, 34)); // WHERE cag_order IN (12, 34)
     * $query->filterByCagOrder(array('min' => 12)); // WHERE cag_order > 12
     * </code>
     *
     * @param     mixed $cagOrder The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CharacterQuery The current query, for fluid interface
     */
    public function filterByCagOrder($cagOrder = null, $comparison = null)
    {
        if (is_array($cagOrder)) {
            $useMinMax = false;
            if (isset($cagOrder['min'])) {
                $this->addUsingAlias(CharacterPeer::CAG_ORDER, $cagOrder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cagOrder['max'])) {
                $this->addUsingAlias(CharacterPeer::CAG_ORDER, $cagOrder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharacterPeer::CAG_ORDER, $cagOrder, $comparison);
    }

    /**
     * Filter the query by a related GamePlayer object
     *
     * @param   GamePlayer|PropelObjectCollection $gamePlayer  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   CharacterQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByGamePlayer($gamePlayer, $comparison = null)
    {
        if ($gamePlayer instanceof GamePlayer) {
            return $this
                ->addUsingAlias(CharacterPeer::ID, $gamePlayer->getCharacterId(), $comparison);
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
     * @return CharacterQuery The current query, for fluid interface
     */
    public function joinGamePlayer($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useGamePlayerQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGamePlayer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GamePlayer', '\Bsg\GameBundle\Model\GamePlayerQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Character $character Object to remove from the list of results
     *
     * @return CharacterQuery The current query, for fluid interface
     */
    public function prune($character = null)
    {
        if ($character) {
            $this->addUsingAlias(CharacterPeer::ID, $character->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
