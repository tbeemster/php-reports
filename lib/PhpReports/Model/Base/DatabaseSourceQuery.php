<?php

namespace PhpReports\Model\Base;

use \Exception;
use \PDO;
use PhpReports\Model\DatabaseSource as ChildDatabaseSource;
use PhpReports\Model\DatabaseSourceQuery as ChildDatabaseSourceQuery;
use PhpReports\Model\Map\DatabaseSourceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'database_source' table.
 *
 *
 *
 * @method     ChildDatabaseSourceQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDatabaseSourceQuery orderByDbms($order = Criteria::ASC) Order by the dbms column
 * @method     ChildDatabaseSourceQuery orderByHost($order = Criteria::ASC) Order by the host column
 * @method     ChildDatabaseSourceQuery orderByDatabaseName($order = Criteria::ASC) Order by the database_name column
 * @method     ChildDatabaseSourceQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method     ChildDatabaseSourceQuery orderByPassword($order = Criteria::ASC) Order by the password column
 *
 * @method     ChildDatabaseSourceQuery groupById() Group by the id column
 * @method     ChildDatabaseSourceQuery groupByDbms() Group by the dbms column
 * @method     ChildDatabaseSourceQuery groupByHost() Group by the host column
 * @method     ChildDatabaseSourceQuery groupByDatabaseName() Group by the database_name column
 * @method     ChildDatabaseSourceQuery groupByUsername() Group by the username column
 * @method     ChildDatabaseSourceQuery groupByPassword() Group by the password column
 *
 * @method     ChildDatabaseSourceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDatabaseSourceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDatabaseSourceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDatabaseSourceQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDatabaseSourceQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDatabaseSourceQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDatabaseSourceQuery leftJoinDatabaseTable($relationAlias = null) Adds a LEFT JOIN clause to the query using the DatabaseTable relation
 * @method     ChildDatabaseSourceQuery rightJoinDatabaseTable($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DatabaseTable relation
 * @method     ChildDatabaseSourceQuery innerJoinDatabaseTable($relationAlias = null) Adds a INNER JOIN clause to the query using the DatabaseTable relation
 *
 * @method     ChildDatabaseSourceQuery joinWithDatabaseTable($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DatabaseTable relation
 *
 * @method     ChildDatabaseSourceQuery leftJoinWithDatabaseTable() Adds a LEFT JOIN clause and with to the query using the DatabaseTable relation
 * @method     ChildDatabaseSourceQuery rightJoinWithDatabaseTable() Adds a RIGHT JOIN clause and with to the query using the DatabaseTable relation
 * @method     ChildDatabaseSourceQuery innerJoinWithDatabaseTable() Adds a INNER JOIN clause and with to the query using the DatabaseTable relation
 *
 * @method     \PhpReports\Model\DatabaseTableQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDatabaseSource findOne(ConnectionInterface $con = null) Return the first ChildDatabaseSource matching the query
 * @method     ChildDatabaseSource findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDatabaseSource matching the query, or a new ChildDatabaseSource object populated from the query conditions when no match is found
 *
 * @method     ChildDatabaseSource findOneById(int $id) Return the first ChildDatabaseSource filtered by the id column
 * @method     ChildDatabaseSource findOneByDbms(string $dbms) Return the first ChildDatabaseSource filtered by the dbms column
 * @method     ChildDatabaseSource findOneByHost(string $host) Return the first ChildDatabaseSource filtered by the host column
 * @method     ChildDatabaseSource findOneByDatabaseName(string $database_name) Return the first ChildDatabaseSource filtered by the database_name column
 * @method     ChildDatabaseSource findOneByUsername(string $username) Return the first ChildDatabaseSource filtered by the username column
 * @method     ChildDatabaseSource findOneByPassword(string $password) Return the first ChildDatabaseSource filtered by the password column *

 * @method     ChildDatabaseSource requirePk($key, ConnectionInterface $con = null) Return the ChildDatabaseSource by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDatabaseSource requireOne(ConnectionInterface $con = null) Return the first ChildDatabaseSource matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDatabaseSource requireOneById(int $id) Return the first ChildDatabaseSource filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDatabaseSource requireOneByDbms(string $dbms) Return the first ChildDatabaseSource filtered by the dbms column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDatabaseSource requireOneByHost(string $host) Return the first ChildDatabaseSource filtered by the host column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDatabaseSource requireOneByDatabaseName(string $database_name) Return the first ChildDatabaseSource filtered by the database_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDatabaseSource requireOneByUsername(string $username) Return the first ChildDatabaseSource filtered by the username column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDatabaseSource requireOneByPassword(string $password) Return the first ChildDatabaseSource filtered by the password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDatabaseSource[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDatabaseSource objects based on current ModelCriteria
 * @method     ChildDatabaseSource[]|ObjectCollection findById(int $id) Return ChildDatabaseSource objects filtered by the id column
 * @method     ChildDatabaseSource[]|ObjectCollection findByDbms(string $dbms) Return ChildDatabaseSource objects filtered by the dbms column
 * @method     ChildDatabaseSource[]|ObjectCollection findByHost(string $host) Return ChildDatabaseSource objects filtered by the host column
 * @method     ChildDatabaseSource[]|ObjectCollection findByDatabaseName(string $database_name) Return ChildDatabaseSource objects filtered by the database_name column
 * @method     ChildDatabaseSource[]|ObjectCollection findByUsername(string $username) Return ChildDatabaseSource objects filtered by the username column
 * @method     ChildDatabaseSource[]|ObjectCollection findByPassword(string $password) Return ChildDatabaseSource objects filtered by the password column
 * @method     ChildDatabaseSource[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DatabaseSourceQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \PhpReports\Model\Base\DatabaseSourceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\PhpReports\\Model\\DatabaseSource', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDatabaseSourceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDatabaseSourceQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDatabaseSourceQuery) {
            return $criteria;
        }
        $query = new ChildDatabaseSourceQuery();
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
     * @return ChildDatabaseSource|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DatabaseSourceTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DatabaseSourceTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildDatabaseSource A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, dbms, host, database_name, username, password FROM database_source WHERE id = :p0';
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
            /** @var ChildDatabaseSource $obj */
            $obj = new ChildDatabaseSource();
            $obj->hydrate($row);
            DatabaseSourceTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildDatabaseSource|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDatabaseSourceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DatabaseSourceTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDatabaseSourceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DatabaseSourceTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildDatabaseSourceQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DatabaseSourceTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DatabaseSourceTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DatabaseSourceTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the dbms column
     *
     * Example usage:
     * <code>
     * $query->filterByDbms('fooValue');   // WHERE dbms = 'fooValue'
     * $query->filterByDbms('%fooValue%'); // WHERE dbms LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dbms The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDatabaseSourceQuery The current query, for fluid interface
     */
    public function filterByDbms($dbms = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dbms)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DatabaseSourceTableMap::COL_DBMS, $dbms, $comparison);
    }

    /**
     * Filter the query on the host column
     *
     * Example usage:
     * <code>
     * $query->filterByHost('fooValue');   // WHERE host = 'fooValue'
     * $query->filterByHost('%fooValue%'); // WHERE host LIKE '%fooValue%'
     * </code>
     *
     * @param     string $host The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDatabaseSourceQuery The current query, for fluid interface
     */
    public function filterByHost($host = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($host)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DatabaseSourceTableMap::COL_HOST, $host, $comparison);
    }

    /**
     * Filter the query on the database_name column
     *
     * Example usage:
     * <code>
     * $query->filterByDatabaseName('fooValue');   // WHERE database_name = 'fooValue'
     * $query->filterByDatabaseName('%fooValue%'); // WHERE database_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $databaseName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDatabaseSourceQuery The current query, for fluid interface
     */
    public function filterByDatabaseName($databaseName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($databaseName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DatabaseSourceTableMap::COL_DATABASE_NAME, $databaseName, $comparison);
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByUsername('%fooValue%'); // WHERE username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDatabaseSourceQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DatabaseSourceTableMap::COL_USERNAME, $username, $comparison);
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%'); // WHERE password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDatabaseSourceQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DatabaseSourceTableMap::COL_PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query by a related \PhpReports\Model\DatabaseTable object
     *
     * @param \PhpReports\Model\DatabaseTable|ObjectCollection $databaseTable the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDatabaseSourceQuery The current query, for fluid interface
     */
    public function filterByDatabaseTable($databaseTable, $comparison = null)
    {
        if ($databaseTable instanceof \PhpReports\Model\DatabaseTable) {
            return $this
                ->addUsingAlias(DatabaseSourceTableMap::COL_ID, $databaseTable->getDatabaseSourceId(), $comparison);
        } elseif ($databaseTable instanceof ObjectCollection) {
            return $this
                ->useDatabaseTableQuery()
                ->filterByPrimaryKeys($databaseTable->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildDatabaseSourceQuery The current query, for fluid interface
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
     * @param   ChildDatabaseSource $databaseSource Object to remove from the list of results
     *
     * @return $this|ChildDatabaseSourceQuery The current query, for fluid interface
     */
    public function prune($databaseSource = null)
    {
        if ($databaseSource) {
            $this->addUsingAlias(DatabaseSourceTableMap::COL_ID, $databaseSource->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the database_source table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DatabaseSourceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DatabaseSourceTableMap::clearInstancePool();
            DatabaseSourceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DatabaseSourceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DatabaseSourceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DatabaseSourceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DatabaseSourceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DatabaseSourceQuery
