<?php
namespace PhpReports;

use PhpReports\Model\DatabaseColumn;
use PhpReports\Model\DatabaseSource;
use PhpReports\Model\DatabaseTable;
use PhpReports\Model\DatabaseTableQuery;

class ManageDatabase {

	/** @var \PDO */
	protected $database;

	/** @var DatabaseSource */
	protected $databaseSource;

	/**
	 * ManageDatabase constructor.
	 *
	 * @param DatabaseSource $databaseSource
	 * @throws \PDOException
	 */
	public function __construct(DatabaseSource $databaseSource) {
		$this->databaseSource = $databaseSource;
		$database = array(
			'dsn' => $this->databaseSource->getDsn(),
			'user' => $this->databaseSource->getUsername(),
			'pass' => $this->databaseSource->getPassword(),
		);
		$this->database = $this->connect($database);
	}

	/**
	 * @param array $database
	 * @throws \PDOException
	 * @return \PDO
	 */
	public static function connect(array $database) {
		return new \PDO($database['dsn'], $database['user'], $database['pass']);
	}

	/**
	 * Returns the row count of the given table.
	 *
	 * @param string $tableName
	 * @return int
	 */
	protected function getRowCount($tableName) {
		$result = $this->database->query("SELECT COUNT(*) FROM " . $tableName);
		$count = $result->fetch();
		return current($count);
	}

	public function getTables() {
		$result = $this->database->query("SHOW TABLES");
		$tables = $result->fetchAll(\PDO::FETCH_ASSOC);

		$rows = array();
		$i = 0;
		foreach ($tables as $table) {
			$tableName = current($table);
			$rowCount = $this->getRowCount($tableName);

			$dbTable = DatabaseTableQuery::create()->filterByDatabaseSource($this->databaseSource)->findOneByName($tableName);
			if (!$dbTable instanceof DatabaseTable) {
				$dbTable = $this->importTable($tableName, $rowCount);
			}

			$rows[$i]['TableId'] = $dbTable->getId();
			$rows[$i]['Table'] = $dbTable->getName();
			$rows[$i]['ColumnCount'] = $dbTable->countDatabaseColumns();
			$rows[$i]['RowCount'] = $rowCount;
			$rows[$i]['Hidden'] = $dbTable->getHidden();

			$i++;
		}
		return $rows;
	}

	/**
	 * Imports a table and converts it to a DatabaseTable object.
	 * @param string $tableName
	 * @param integer $rowCount
	 * @return DatabaseTable
	 * @throws \Propel\Runtime\Exception\PropelException
	 */
	protected function importTable($tableName, $rowCount) {
		$dbTable = new DatabaseTable();
		$dbTable->setDatabaseSource($this->databaseSource);

		$hidden = ($rowCount == 0 ? 1 : 0);
		$dbTable->setHidden($hidden);
		$dbTable->setName($tableName);
		$dbTable->save();

		$result = $this->database->query("DESCRIBE " . $tableName);
		$columns = $result->fetchAll(\PDO::FETCH_ASSOC);
		foreach ($columns as $column) {
			$dbColumn = new DatabaseColumn();
			$dbColumn->setName($column['Field'])->setDataType($column['Type'])->setDatabaseTable($dbTable);
			$dbColumn->save();
			$dbTable->addDatabaseColumn($dbColumn);
		}
		$dbTable->save();
		return $dbTable;
	}

	public function getDatabaseSource() {
		return $this->databaseSource;
	}

}
