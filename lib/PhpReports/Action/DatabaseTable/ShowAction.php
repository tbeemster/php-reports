<?php
namespace PhpReports\Action\DatabaseTable;

use PhpReports\Action\Action;
use PhpReports\Model\DatabaseSource;
use PhpReports\Model\DatabaseSourceQuery;
use PhpReports\Model\DatabaseTable;
use PhpReports\Model\DatabaseTableQuery;

class ShowAction extends Action {

	/** @var DatabaseSource */
	protected $databaseSource;

	/** @var DatabaseTable */
	protected $databaseTable;

	public function collect() {
		$databaseSourceId = (int)$this->request->data['database-source'];
		$databaseTableId = (int)$this->request->data['database-table'];
		$this->databaseSource = DatabaseSourceQuery::create()->findOneById($databaseSourceId);
		$this->databaseTable = DatabaseTableQuery::create()->findOneById($databaseTableId);
	}

	public function validate() {
		return ($this->databaseSource instanceof DatabaseSource && $this->databaseTable instanceof DatabaseTable);
	}

	public function execute() {
		$this->databaseTable->setHidden(false);
		$this->databaseTable->save();
	}
}