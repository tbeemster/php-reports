<?php
namespace PhpReports\Action\Report;

use flight\net\Request;
use PhpReports\Action\Action;
use PhpReports\Model\Base\DatabaseColumnQuery;
use PhpReports\Model\Base\DatabaseSourceQuery;
use PhpReports\Model\DatabaseColumn;
use PhpReports\Model\DatabaseSource;
use PhpReports\Model\Map\ReportColumnTableMap;
use PhpReports\Model\Report;

class AddAction extends Action {

	/** @var Request */
	protected $request;

	/** @var string */
	protected $name;

	/** @var string */
	protected $type;

	/** @var array */
	protected $measures;

	/** @var array */
	protected $dimensions;

	/** @var DatabaseSource */
	protected $dataSource;

	public function collect() {
		$this->request = \Flight::request();
		$this->name = $this->request->data['name'];
		$this->type = $this->request->data['report_type'];
		$this->measures = $this->request->data['measures'];
		$this->dimensions = $this->request->data['dimensions'];
		$this->dataSource = DatabaseSourceQuery::create()->findOneById((int)$this->request->data['dataSource']);
	}

	public function validate() {
		return ($this->dataSource instanceof DatabaseSource);
	}

	public function execute() {
		echo 'hallo?';
		$report = new Report();
		$report->setName($this->name)
			->setType($this->type)
			->setDatabaseSource($this->dataSource);

		/** @var DatabaseColumn $measure */
		foreach ($this->measures as $measure) {
			$measure = DatabaseColumnQuery::create()->findOneById((int)$measure);
			$report->addDatabaseColumn($measure, ReportColumnTableMap::COL_TYPE_MEASURE);
		}

		/** @var DatabaseColumn $measure */
		foreach ($this->dimensions as $dimension) {
			$dimension = DatabaseColumnQuery::create()->findOneById((int)$dimension);
			$report->addDatabaseColumn($dimension, ReportColumnTableMap::COL_TYPE_DIMENSION);
		}
		$report->save();
	}
}