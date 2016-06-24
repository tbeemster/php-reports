<?php
namespace PhpReports\Action\Join;

use flight\net\Request;
use PhpReports\Action\Action;
use PhpReports\Model\Base\DatabaseColumn;
use PhpReports\Model\Base\DatabaseColumnQuery;
use PhpReports\Model\Base\DatabaseSource;
use PhpReports\Model\DatabaseJoin;

class AddAction extends Action {

	/** @var Request */
	protected $request;

	/** @var DatabaseColumn */
	protected $localColumn;

	/** @var DatabaseColumn */
	protected $foreignColumn;

	/** @var DatabaseSource */
	protected $dataSource;

	/** @var string */
	protected $alias;

	public function collect() {
		$this->request = \Flight::request();
		$local = (int)$this->request->data['local_table'];
		$this->localColumn = DatabaseColumnQuery::create()->findOneById($local);

		$foreign = (int)$this->request->data['foreign_table'];
		$this->foreignColumn = DatabaseColumnQuery::create()->findOneById($foreign);
		$this->dataSource = $this->foreignColumn->getDatabaseTable()->getDatabaseSource();

		$this->alias = $this->request->data['alias'];
	}

	public function validate() {
		return ($this->localColumn instanceof DatabaseColumn && $this->foreignColumn instanceof DatabaseColumn && $this->dataSource instanceof DatabaseSource);
	}

	public function execute() {
		$join = new DatabaseJoin();
		$join->setLocalColumn($this->localColumn->getId())
			->setForeignColumn($this->foreignColumn->getId())
			->setDatabaseSource($this->dataSource)
			->setAlias($this->alias)
			->save();
	}
}