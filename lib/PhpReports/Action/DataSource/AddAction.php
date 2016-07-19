<?php
namespace PhpReports\Action\DataSource;

use PhpReports\Action\Action;
use PhpReports\ManageDatabase;
use PhpReports\Model\DatabaseSource;

class AddAction extends Action {

	/** @var DatabaseSource */
	protected $databaseSource;

	/** @var ManageDatabase */
	protected $manageDatabase;

	public function collect() {
		$dbms = $this->request->data['dbms'];
		$host = $this->request->data['host'];
		$databaseName = $this->request->data['database_name'];
		$username = $this->request->data['username'];
		$password = $this->request->data['password'];
		$this->databaseSource = new DatabaseSource();
		$this->databaseSource->setDbms($dbms)->setHost($host)->setDatabaseName($databaseName)->setUsername($username)->setPassword($password);
	}

	public function validate() {
		try {
			$this->manageDatabase = new ManageDatabase($this->databaseSource);
			return true;
		}
		catch (\PDOException $pdoException) {
			$this->databaseSource->delete();
			return false;
		}
	}

	public function execute() {
		$this->databaseSource->save();
		echo $this->manageDatabase->configureTables();
	}
}