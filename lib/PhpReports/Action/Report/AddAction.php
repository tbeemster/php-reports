<?php
namespace PhpReports\Action\Report;

use PhpReports\Action\Action;
use PhpReports\Model\Base\DatabaseSourceQuery;
use PhpReports\Model\DatabaseSource;
use PhpReports\Model\Report;
use PhpReports\PhpReports;

class AddAction extends Action {

	/** @var string */
	protected $name;

	/** @var string */
	protected $type;

	/** @var DatabaseSource */
	protected $dataSource;

	public function collect() {
		$this->name = $this->request->data['name'];
		$this->type = $this->request->data['report_type'];
		$this->dataSource = DatabaseSourceQuery::create()->findOneById((int)$this->request->data['dataSource']);
	}

	public function validate() {
		$validReport = (strlen($this->name) > 3);
		$validDataSource = ($this->dataSource instanceof DatabaseSource);

		return $validReport && $validDataSource;
	}

	public function execute() {
		$report = new Report();
		$report->setName($this->name)
			->setType($this->type)
			->setDatabaseSource($this->dataSource);

		$report->save();

		\Flight::redirect(PhpReports::$request->base . '/manage-report/edit/?report=' . $report->getId());
	}
}