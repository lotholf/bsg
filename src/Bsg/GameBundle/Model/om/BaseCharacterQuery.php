<?php

namespace Bsg\GameBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Bsg\GameBundle\Model\Character;
use Bsg\GameBundle\Model\CharacterPeer;
use Bsg\GameBundle\Model\CharacterQuery;

/**
 * @method CharacterQuery orderById($order = Criteria::ASC) Order by the id column
 * @method CharacterQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method CharacterQuery orderByPower($order = Criteria::ASC) Order by the power column
 * @method CharacterQuery orderByPowerOnePerGame($order = Criteria::ASC) Order by the power_one_per_game column
 * @method CharacterQuery orderByDrawback($order = Criteria::ASC) Order by the drawback column
 *
 * @method CharacterQuery groupById() Group by the id column
 * @method CharacterQuery groupByName() Group by the name column
 * @method CharacterQuery groupByPower() Group by the power column
 * @method CharacterQuery groupByPowerOnePerGame() Group by the power_one_per_game column
 * @method CharacterQuery groupByDrawback() Group by the drawback column
 *
 * @method CharacterQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CharacterQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CharacterQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method Character findOne(PropelPDO $con = null) Return the first Character matching the query
 * @method Character findOneOrCreate(PropelPDO $con = null) Return the first Character matching the query, or a new Character object populated from the query conditions when no match is found
 *
 * @method Character findOneById(int $id) Return the first Character filtered by the id column
 * @method Character findOneByName(string $name) Return the first Character filtered by the name column
 * @method Character findOneByPower(string $power) Return the first Character filtered by the power column
 * @method Character findOneByPowerOnePerGame(string $power_one_per_game) Return the first Character filtered by the power_one_per_game column
 * @method Character findOneByDrawback(string $drawback) Return the first Character filtered by the drawback column
 *
 * @method array findById(int $id) Return Character objects filtered by the id column
 * @method array findByName(string $name) Return Character objects filtered by the name column
 * @method array findByPower(string $power) Return Character objects filtered by the power column
 * @method array findByPowerOnePerGame(string $power_one_per_game) Return Character objects filtered by the power_one_per_game column
 * @method array findByDrawback(string $drawback) Return Character objects filtered by the drawback column
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
        $sql = 'SELECT `ID`, `NAME`, `POWER`, `POWER_ONE_PER_GAME`, `DRAWBACK` FROM `character` WHERE `ID` = :p0';
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
