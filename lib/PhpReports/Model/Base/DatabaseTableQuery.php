<?php

namespace PhpReports\Model\Base;

use \Exception;
use \PDO;
use PhpReports\Model\DatabaseTable as ChildDatabaseTable;
use PhpReports\Model\DatabaseTableQuery as ChildDatabaseTableQuery;
use PhpReports\Model\Map\DatabaseTableTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'database_table' table.
 *
 *
 *
 * @method     ChildDatabaseTableQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDatabaseTableQuery orderByHidden($order = Criteria::ASC) Order by the hidden column
 * @method     ChildDatabaseTableQuery orderByDatabaseSourceId($order = Criteria::ASC) Order by the database_source_id column
 *
 * @method     ChildDatabaseTableQuery groupById() Group by the id column
 * @method     ChildDatabaseTableQuery groupByHidden() Group by the hidden column
 * @method     ChildDatabaseTableQuery groupByDatabaseSourceId() Group by the database_source_id column
 *
 * @method     ChildDatabaseTableQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDatabaseTableQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDatabaseTableQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDatabaseTableQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDatabaseTableQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDatabaseTableQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDatabaseTableQuery leftJoinDatabaseSource($relationAlias = null) Adds a LEFT JOIN clause to the query using the DatabaseSource relation
 * @method     ChildDatabaseTableQuery rightJoinDatabaseSource($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DatabaseSource relation
 * @method     ChildDatabaseTableQuery innerJoinDatabaseSource($relationAlias = null) Adds a INNER JOIN clause to the query using the DatabaseSource relation
 *
 * @method     ChildDatabaseTableQuery joinWithDatabaseSource($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DatabaseSource relation
 *
 * @method     ChildDatabaseTableQuery leftJoinWithDatabaseSource() Adds a LEFT JOIN clause and with to the query using the DatabaseSource relation
 * @method     ChildDatabaseTableQuery rightJoinWithDatabaseSource() Adds a RIGHT JOIN clause and with to the query using the DatabaseSource relation
 * @method     ChildDatabaseTableQuery innerJoinWithDatabaseSource() Adds a INNER JOIN clause and with to the query using the DatabaseSource relation
 *
 * @method     ChildDatabaseTableQuery leftJoinDatabaseColumn($relationAlias = null) Adds a LEFT JOIN clause to the query using the DatabaseColumn relation
 * @method     ChildDatabaseTableQuery rightJoinDatabaseColumn($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DatabaseColumn relation
 * @method     ChildDatabaseTableQuery innerJoinDatabaseColumn($relationAlias = null) Adds a INNER JOIN clause to the query using the DatabaseColumn relation
 *
 * @method     ChildDatabaseTableQuery joinWithDatabaseColumn($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DatabaseColumn relation
 *
 * @method     ChildDatabaseTableQuery leftJoinWithDatabaseColumn() Adds a LEFT JOIN clause and with to the query using the DatabaseColumn relation
 * @method     ChildDatabaseTableQuery rightJoinWithDatabaseColumn() Adds a RIGHT JOIN clause and with to the query using the DatabaseColumn relation
 * @method     ChildDatabaseTableQuery innerJoinWithDatabaseColumn() Adds a INNER JOIN clause and with to the query using the DatabaseColumn relation
 *
 * @method     \PhpReports\Model\DatabaseSourceQuery|\PhpReports\Model\DatabaseColumnQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDatabaseTable findOne(ConnectionInterface $con = null) Return the first ChildDatabaseTable matching the query
 * @method     ChildDatabaseTable findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDatabaseTable matching the query, or a new ChildDatabaseTable object populated from the query conditions when no match is found
 *
 * @method     ChildDatabaseTable findOneById(int $id) Return the first ChildDatabaseTable filtered by the id column
 * @method     ChildDatabaseTable findOneByHidden(int $hidden) Return the first ChildDatabaseTable filtered by the hidden column
 * @method     ChildDatabaseTable findOneByDatabaseSourceId(int $database_source_id) Return the first ChildDatabaseTable filtered by the database_source_id column *

 * @method     ChildDatabaseTable requirePk($key, ConnectionInterface $con = null) Return the ChildDatabaseTable by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDatabaseTable requireOne(ConnectionInterface $con = null) Return the first ChildDatabaseTable matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDatabaseTable requireOneById(int $id) Return the first ChildDatabaseTable filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDatabaseTable requireOneByHidden(int $hidden) Return the first ChildDatabaseTable filtered by the hidden column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDatabaseTable requireOneByDatabaseSourceId(int $database_source_id) Return the first ChildDatabaseTable filtered by the database_source_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDatabaseTable[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDatabaseTable objects based on current ModelCriteria
 * @method     ChildDatabaseTable[]|ObjectCollection findById(int $id) Return ChildDatabaseTable objects filtered by the id column
 * @method     ChildDatabaseTable[]|ObjectCollection findByHidden(int $hidden) Return ChildDatabaseTable objects filtered by the hidden column
 * @method     ChildDatabaseTable[]|ObjectCollection findByDatabaseSourceId(int $database_source_id) Return ChildDatabaseTable objects filtered by the database_source_id column
 * @method     ChildDatabaseTable[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DatabaseTableQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \PhpReports\Model\Base\DatabaseTableQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\PhpReports\\Model\\DatabaseTable', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDatabaseTableQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDatabaseTableQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDatabaseTableQuery) {
            return $criteria;
        }
        $query = new ChildDatabaseTableQuery();
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
     * @return ChildDatabaseTable|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DatabaseTableTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DatabaseTableTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildDatabaseTable A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, hidden, database_source_id FROM database_table WHERE id = :p0';
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
            /** @var ChildDatabaseTable $obj */
            $obj = new ChildDatabaseTable();
            $obj->hydrate($row);
            DatabaseTableTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildDatabaseTable|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDatabaseTableQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DatabaseTableTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDatabaseTableQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DatabaseTableTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildDatabaseTableQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DatabaseTableTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DatabaseTableTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DatabaseTableTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildDatabaseTableQuery The current query, for fluid interface
     */
    public function filterByHidden($hidden = null, $comparison = null)
    {
        if (is_array($hidden)) {
            $useMinMax = false;
            if (isset($hidden['min'])) {
                $this->addUsingAlias(DatabaseTableTableMap::COL_HIDDEN, $hidden['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($hidden['max'])) {
                $this->addUsingAlias(DatabaseTableTableMap::COL_HIDDEN, $hidden['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DatabaseTableTableMap::COL_HIDDEN, $hidden, $comparison);
    }

    /**
     * Filter the query on the database_source_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDatabaseSourceId(1234); // WHERE database_source_id = 1234
     * $query->filterByDatabaseSourceId(array(12, 34)); // WHERE database_source_id IN (12, 34)
     * $query->filterByDatabaseSourceId(array('min' => 12)); // WHERE database_source_id > 12
     * </code>
     *
     * @see       filterByDatabaseSource()
     *
     * @param     mixed $databaseSourceId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDatabaseTableQuery The current query, for fluid interface
     */
    public function filterByDatabaseSourceId($databaseSourceId = null, $comparison = null)
    {
        if (is_array($databaseSourceId)) {
            $useMinMax = false;
            if (isset($databaseSourceId['min'])) {
                $this->addUsingAlias(DatabaseTableTableMap::COL_DATABASE_SOURCE_ID, $databaseSourceId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($databaseSourceId['max'])) {
                $this->addUsingAlias(DatabaseTableTableMap::COL_DATABASE_SOURCE_ID, $databaseSourceId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DatabaseTableTableMap::COL_DATABASE_SOURCE_ID, $databaseSourceId, $comparison);
    }

    /**
     * Filter the query by a related \PhpReports\Model\DatabaseSource object
     *
     * @param \PhpReports\Model\DatabaseSource|ObjectCollection $databaseSource The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDatabaseTableQuery The current query, for fluid interface
     */
    public function filterByDatabaseSource($databaseSource, $comparison = null)
    {
        if ($databaseSource instanceof \PhpReports\Model\DatabaseSource) {
            return $this
                ->addUsingAlias(DatabaseTableTableMap::COL_DATABASE_SOURCE_ID, $databaseSource->getId(), $comparison);
        } elseif ($databaseSource instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DatabaseTableTableMap::COL_DATABASE_SOURCE_ID, $databaseSource->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByDatabaseSource() only accepts arguments of type \PhpReports\Model\DatabaseSource or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DatabaseSource relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDatabaseTableQuery The current query, for fluid interface
     */
    public function joinDatabaseSource($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DatabaseSource');

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
            $this->addJoinObject($join, 'DatabaseSource');
        }

        return $this;
    }

    /**
     * Use the DatabaseSource relation DatabaseSource object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PhpReports\Model\DatabaseSourceQuery A secondary query class using the current class as primary query
     */
    public function useDatabaseSourceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDatabaseSource($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DatabaseSource', '\PhpReports\Model\DatabaseSourceQuery');
    }

    /**
     * Filter the query by a related \PhpReports\Model\DatabaseColumn object
     *
     * @param \PhpReports\Model\DatabaseColumn|ObjectCollection $databaseColumn the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDatabaseTableQuery The current query, for fluid interface
     */
    public function filterByDatabaseColumn($databaseColumn, $comparison = null)
    {
        if ($databaseColumn instanceof \PhpReports\Model\DatabaseColumn) {
            return $this
                ->addUsingAlias(DatabaseTableTableMap::COL_ID, $databaseColumn->getDatabaseTableId(), $comparison);
        } elseif ($databaseColumn instanceof ObjectCollection) {
            return $this
                ->useDatabaseColumnQuery()
                ->filterByPrimaryKeys($databaseColumn->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDatabaseColumn() only accepts arguments of type \PhpReports\Model\DatabaseColumn or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DatabaseColumn relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDatabaseTableQuery The current query, for fluid interface
     */
    public function joinDatabaseColumn($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DatabaseColumn');

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
            $this->addJoinObject($join, 'DatabaseColumn');
        }

        return $this;
    }

    /**
     * Use the DatabaseColumn relation DatabaseColumn object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PhpReports\Model\DatabaseColumnQuery A secondary query class using the current class as primary query
     */
    public function useDatabaseColumnQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDatabaseColumn($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DatabaseColumn', '\PhpReports\Model\DatabaseColumnQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDatabaseTable $databaseTable Object to remove from the list of results
     *
     * @return $this|ChildDatabaseTableQuery The current query, for fluid interface
     */
    public function prune($databaseTable = null)
    {
        if ($databaseTable) {
            $this->addUsingAlias(DatabaseTableTableMap::COL_ID, $databaseTable->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the database_table table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DatabaseTableTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DatabaseTableTableMap::clearInstancePool();
            DatabaseTableTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DatabaseTableTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DatabaseTableTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DatabaseTableTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DatabaseTableTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DatabaseTableQuery
