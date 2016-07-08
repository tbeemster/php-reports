<?php
namespace PhpReports\Action\Report;

use flight\net\Request;
use PhpReports\Action\Action;
use PhpReports\Model\DatabaseColumn;
use PhpReports\Model\DatabaseColumnQuery;
use PhpReports\Model\Report;
use PhpReports\Model\ReportQuery;

class AddColumnAction extends Action {

	/** @var Request */
	protected $request;

	/** @var Report */
	protected $report;

	/** @var DatabaseColumn */
	protected $column;

	public function collect() {
		$this->request = \Flight::request();
		$this->report = ReportQuery::create()->findOneById($this->request->data['report']);
		$this->column = DatabaseColumnQuery::create()->findOneById($this->request->data['column']);
	}

	public function validate() {
		$validReport = $this->report instanceof Report;
		$validColumn = $this->column instanceof DatabaseColumn;
		return $validReport && $validColumn;
	}

	public function execute() {
		$dataType = $this->column->getChartDataType();

		$this->report->addDatabaseColumn($this->column, $dataType);
		$this->report->save();
	}
}