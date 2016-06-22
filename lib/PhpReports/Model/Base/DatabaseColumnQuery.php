<?php

namespace PhpReports\Model\Base;

use \Exception;
use \PDO;
use PhpReports\Model\DatabaseColumn as ChildDatabaseColumn;
use PhpReports\Model\DatabaseColumnQuery as ChildDatabaseColumnQuery;
use PhpReports\Model\Map\DatabaseColumnTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'database_column' table.
 *
 *
 *
 * @method     ChildDatabaseColumnQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDatabaseColumnQuery orderByHidden($order = Criteria::ASC) Order by the hidden column
 * @method     ChildDatabaseColumnQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildDatabaseColumnQuery orderByDataType($order = Criteria::ASC) Order by the data_type column
 * @method     ChildDatabaseColumnQuery orderByDatabaseTableId($order = Criteria::ASC) Order by the database_table_id column
 *
 * @method     ChildDatabaseColumnQuery groupById() Group by the id column
 * @method     ChildDatabaseColumnQuery groupByHidden() Group by the hidden column
 * @method     ChildDatabaseColumnQuery groupByName() Group by the name column
 * @method     ChildDatabaseColumnQuery groupByDataType() Group by the data_type column
 * @method     ChildDatabaseColumnQuery groupByDatabaseTableId() Group by the database_table_id column
 *
 * @method     ChildDatabaseColumnQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDatabaseColumnQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDatabaseColumnQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDatabaseColumnQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDatabaseColumnQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDatabaseColumnQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDatabaseColumnQuery leftJoinDatabaseTable($relationAlias = null) Adds a LEFT JOIN clause to the query using the DatabaseTable relation
 * @method     ChildDatabaseColumnQuery rightJoinDatabaseTable($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DatabaseTable relation
 * @method     ChildDatabaseColumnQuery innerJoinDatabaseTable($relationAlias = null) Adds a INNER JOIN clause to the query using the DatabaseTable relation
 *
 * @method     ChildDatabaseColumnQuery joinWithDatabaseTable($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DatabaseTable relation
 *
 * @method     ChildDatabaseColumnQuery leftJoinWithDatabaseTable() Adds a LEFT JOIN clause and with to the query using the DatabaseTable relation
 * @method     ChildDatabaseColumnQuery rightJoinWithDatabaseTable() Adds a RIGHT JOIN clause and with to the query using the DatabaseTable relation
 * @method     ChildDatabaseColumnQuery innerJoinWithDatabaseTable() Adds a INNER JOIN clause and with to the query using the DatabaseTable relation
 *
 * @method     \PhpReports\Model\DatabaseTableQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDatabaseColumn findOne(ConnectionInterface $con = null) Return the first ChildDatabaseColumn matching the query
 * @method     ChildDatabaseColumn findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDatabaseColumn matching the query, or a new ChildDatabaseColumn object populated from the query conditions when no match is found
 *
 * @method     ChildDatabaseColumn findOneById(int $id) Return the first ChildDatabaseColumn filtered by the id column
 * @method     ChildDatabaseColumn findOneByHidden(int $hidden) Return the first ChildDatabaseColumn filtered by the hidden column
 * @method     ChildDatabaseColumn findOneByName(string $name) Return the first ChildDatabaseColumn filtered by the name column
 * @method     ChildDatabaseColumn findOneByDataType(string $data_type) Return the first ChildDatabaseColumn filtered by the data_type column
 * @method     ChildDatabaseColumn findOneByDatabaseTableId(int $database_table_id) Return the first ChildDatabaseColumn filtered by the database_table_id column *

 * @method     ChildDatabaseColumn requirePk($key, ConnectionInterface $con = null) Return the ChildDatabaseColumn by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDatabaseColumn requireOne(ConnectionInterface $con = null) Return the first ChildDatabaseColumn matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDatabaseColumn requireOneById(int $id) Return the first ChildDatabaseColumn filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDatabaseColumn requireOneByHidden(int $hidden) Return the first ChildDatabaseColumn filtered by the hidden column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDatabaseColumn requireOneByName(string $name) Return the first ChildDatabaseColumn filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDatabaseColumn requireOneByDataType(string $data_type) Return the first ChildDatabaseColumn filtered by the data_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDatabaseColumn requireOneByDatabaseTableId(int $database_table_id) Return the first ChildDatabaseColumn filtered by the database_table_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDatabaseColumn[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDatabaseColumn objects based on current ModelCriteria
 * @method     ChildDatabaseColumn[]|ObjectCollection findById(int $id) Return ChildDatabaseColumn objects filtered by the id column
 * @method     ChildDatabaseColumn[]|ObjectCollection findByHidden(int $hidden) Return ChildDatabaseColumn objects filtered by the hidden column
 * @method     ChildDatabaseColumn[]|ObjectCollection findByName(string $name) Return ChildDatabaseColumn objects filtered by the name column
 * @method     ChildDatabaseColumn[]|ObjectCollection findByDataType(string $data_type) Return ChildDatabaseColumn objects filtered by the data_type column
 * @method     ChildDatabaseColumn[]|ObjectCollection findByDatabaseTableId(int $database_table_id) Return ChildDatabaseColumn objects filtered by the database_table_id column
 * @method     ChildDatabaseColumn[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DatabaseColumnQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \PhpReports\Model\Base\DatabaseColumnQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\PhpReports\\Model\\DatabaseColumn', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDatabaseColumnQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDatabaseColumnQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDatabaseColumnQuery) {
            return $criteria;
        }
        $query = new ChildDatabaseColumnQuery();
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
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildDatabaseColumn|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DatabaseColumnTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DatabaseColumnTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDatabaseColumn A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, hidden, name, data_type, database_table_id FROM database_column WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildDatabaseColumn $obj */
            $obj = new ChildDatabaseColumn();
            $obj->hydrate($row);
            DatabaseColumnTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildDatabaseColumn|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildDatabaseColumnQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DatabaseColumnTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDatabaseColumnQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DatabaseColumnTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildDatabaseColumnQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DatabaseColumnTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DatabaseColumnTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DatabaseColumnTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the hidden column
     *
     * Example usage:
     * <code>
     * $query->filterByHidden(1234); // WHERE hidden = 1234
     * $query->filterByHidden(array(12, 34)); // WHERE hidden IN (12, 34)
     * $query->filterByHidden(array('min' => 12)); // WHERE hidden > 12
     * </code>
     *
     * @param     mixed $hidden The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDatabaseColumnQuery The current query, for fluid interface
     */
    public function filterByHidden($hidden = null, $comparison = null)
    {
        if (is_array($hidden)) {
            $useMinMax = false;
            if (isset($hidden['min'])) {
                $this->addUsingAlias(DatabaseColumnTableMap::COL_HIDDEN, $hidden['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($hidden['max'])) {
                $this->addUsingAlias(DatabaseColumnTableMap::COL_HIDDEN, $hidden['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DatabaseColumnTableMap::COL_HIDDEN, $hidden, $comparison);
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
     * @return $this|ChildDatabaseColumnQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DatabaseColumnTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the data_type column
     *
     * Example usage:
     * <code>
     * $query->filterByDataType('fooValue');   // WHERE data_type = 'fooValue'
     * $query->filterByDataType('%fooValue%'); // WHERE data_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dataType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDatabaseColumnQuery The current query, for fluid interface
     */
    public function filterByDataType($dataType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dataType)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DatabaseColumnTableMap::COL_DATA_TYPE, $dataType, $comparison);
    }

    /**
     * Filter the query on the database_table_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDatabaseTableId(1234); // WHERE database_table_id = 1234
     * $query->filterByDatabaseTableId(array(12, 34)); // WHERE database_table_id IN (12, 34)
     * $query->filterByDatabaseTableId(array('min' => 12)); // WHERE database_table_id > 12
     * </code>
     *
     * @see       filterByDatabaseTable()
     *
     * @param     mixed $databaseTableId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDatabaseColumnQuery The current query, for fluid interface
     */
    public function filterByDatabaseTableId($databaseTableId = null, $comparison = null)
    {
        if (is_array($databaseTableId)) {
            $useMinMax = false;
            if (isset($databaseTableId['min'])) {
                $this->addUsingAlias(DatabaseColumnTableMap::COL_DATABASE_TABLE_ID, $databaseTableId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($databaseTableId['max'])) {
                $this->addUsingAlias(DatabaseColumnTableMap::COL_DATABASE_TABLE_ID, $databaseTableId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DatabaseColumnTableMap::COL_DATABASE_TABLE_ID, $databaseTableId, $comparison);
    }

    /**
     * Filter the query by a related \PhpReports\Model\DatabaseTable object
     *
     * @param \PhpReports\Model\DatabaseTable|ObjectCollection $databaseTable The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDatabaseColumnQuery The current query, for fluid interface
     */
    public function filterByDatabaseTable($databaseTable, $comparison = null)
    {
        if ($databaseTable instanceof \PhpReports\Model\DatabaseTable) {
            return $this
                ->addUsingAlias(DatabaseColumnTableMap::COL_DATABASE_TABLE_ID, $databaseTable->getId(), $comparison);
        } elseif ($databaseTable instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DatabaseColumnTableMap::COL_DATABASE_TABLE_ID, $databaseTable->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByDatabaseTable() only accepts arguments of type \PhpReports\Model\DatabaseTable or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DatabaseTable relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDatabaseColumnQuery The current query, for fluid interface
     */
    public function joinDatabaseTable($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DatabaseTable');

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
            $this->addJoinObject($join, 'DatabaseTable');
        }

        return $this;
    }

    /**
     * Use the DatabaseTable relation DatabaseTable object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PhpReports\Model\DatabaseTableQuery A secondary query class using the current class as primary query
     */
    public function useDatabaseTableQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDatabaseTable($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DatabaseTable', '\PhpReports\Model\DatabaseTableQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDatabaseColumn $databaseColumn Object to remove from the list of results
     *
     * @return $this|ChildDatabaseColumnQuery The current query, for fluid interface
     */
    public function prune($databaseColumn = null)
    {
        if ($databaseColumn) {
            $this->addUsingAlias(DatabaseColumnTableMap::COL_ID, $databaseColumn->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the database_column table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DatabaseColumnTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DatabaseColumnTableMap::clearInstancePool();
            DatabaseColumnTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DatabaseColumnTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DatabaseColumnTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DatabaseColumnTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DatabaseColumnTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DatabaseColumnQuery
