<?php
namespace PhpReports\Controller;

use PhpReports\ManageDatabase;
use PhpReports\Model\Base\DatabaseJoinQuery;
use PhpReports\Model\Base\DatabaseTableQuery;
use PhpReports\Model\DatabaseSource;
use PhpReports\Model\DatabaseSourceQuery;
use PhpReports\PhpReports;
use Propel\Runtime\ActiveQuery\Criteria;

class ConfigureController {

	/**
	 * Manage a data source: show tables from the given data source.
	 * @param string $dataSource
	 * @throws \Propel\Runtime\Exception\PropelException
	 */
	public function manageDataSource($dataSource) {
		$databaseSource = DatabaseSourceQuery::create()->findOneByDatabaseName($dataSource);
		if (!$databaseSource instanceof DatabaseSource) {
			echo 'Database ' . $dataSource . ' not found!';
			exit();
		}
		try {
			$manageDatabase = new ManageDatabase($databaseSource);
		}
		catch (\PDOException $pdoException) {
			$databaseSource->delete();
			echo '<h1>Couldn\'t connect to database</h1>';
			var_dump($pdoException);
			exit();
		}
		echo $manageDatabase->configureTables();
	}

	public function joinTables($dataSource) {
		$dataSource = DatabaseSourceQuery::create()->findOneByDatabaseName($dataSource);
		$tables = DatabaseTableQuery::create()->filterByDatabaseSource($dataSource)->filterByHidden(false)->orderByName(Criteria::ASC)->find();

		$dbJoins = DatabaseJoinQuery::create()->filterByDatabaseSource($dataSource)->find();
		$templateVars = array('dbJoins' => $dbJoins, 'tables' => $tables);
		echo PhpReports::render('configure/join_tables', $templateVars);
	}
}