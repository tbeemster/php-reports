<?php
namespace PhpReports\Action;

use PhpReports\ManageDatabase;
use PhpReports\Model\DatabaseSource;

abstract class Action {

	/**
	 * Collects the input data
	 * @return void
	 */
	public function collect() {

	}

	/**
	 * Validates the incoming request
	 * @return boolean
	 */
	public function validate() {
		return true;
	}

	public function execute() {

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

		$dsn = $databaseSource->getDsn();;
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
}