<?php
namespace PhpReports\Action\DataSource;

use PhpReports\Action\Action;
use PhpReports\ManageDatabase;
use PhpReports\Model\DatabaseSource;
use PhpReports\Model\DatabaseSourceQuery;

class AddAction extends Action {

	/** @var DatabaseSource */
	protected $databaseSource;

	/** @var ManageDatabase */
	protected $manageDatabase;

	public function collect() {
		$this->databaseSource = DatabaseSourceQuery::create()->findOneById((int)$this->request->data['dataSource']);
		if (!$this->databaseSource instanceof DatabaseSource) {
			$this->databaseSource = new DatabaseSource();
		}

		$dbms = $this->request->data['dbms'];
		$host = $this->request->data['host'];
		$databaseName = $this->request->data['database_name'];
		$username = $this->request->data['username'];
		$password = $this->request->data['password'];

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
	}
}