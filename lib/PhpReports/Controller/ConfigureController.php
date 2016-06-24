<?php
namespace PhpReports\Controller;

use PhpReports\ManageDatabase;
use PhpReports\Model\DatabaseSource;
use PhpReports\Model\DatabaseSourceQuery;

class ConfigureController {

	public function dataSource($database = null) {
		if ($database == null) {
			$this->newDataSource();
		}
		else {
			$this->manageDataSource($database);
		}
	}

	protected function newDataSource() {
		$request = \Flight::request();
		$dbms = $request->data['dbms'];
		$host = $request->data['host'];
		$databaseName = $request->data['database_name'];
		$username = $request->data['username'];
		$password = $request->data['password'];

		$databaseSource = new DatabaseSource();
		$databaseSource->setDbms($dbms)->setHost($host)->setDatabaseName($databaseName)->setUsername($username)->setPassword($password);

		try {
			$manageDatabase = new ManageDatabase($databaseSource);
		}
		catch (\PDOException $pdoException) {
			$databaseSource->delete();
			echo '<h1>Couldn\'t connect to database</h1>';
			var_dump($pdoException);
			exit();
		}
		$databaseSource->save();
		echo $manageDatabase->configureTables();
	}

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
}