<?php
namespace PhpReports\Action\Report;

use PhpReports\Action\Action;
use PhpReports\Model\DatabaseSource;
use PhpReports\Model\Report;
use PhpReports\Model\ReportQuery;

class UpdateAction extends Action {

	/** @var Report */
	protected $report;

	/** @var string */
	protected $name;

	/** @var string */
	protected $type;

	/** @var string */
	protected $hAxisTitle;

	/** @var string */
	protected $vAxisTitle;

	/** @var boolean */
	protected $sqlMode;

	/** @var string */
	protected $sqlCode;

	/** @var DatabaseSource */
	protected $dataSource;

	public function collect() {
		$this->report = ReportQuery::create()->findOneById($this->request->data['report']);
		$this->name = $this->request->data['name'];
		$this->type = $this->request->data['report_type'];
		$this->hAxisTitle = $this->request->data['h_axis_title'];
		$this->vAxisTitle = $this->request->data['v_axis_title'];
		$this->sqlMode = $this->request->data['sql_mode'];
		$this->sqlCode = $this->request->data['sql_code'];
	}

	public function validate() {
		return ($this->report instanceof Report);
	}

	public function execute() {
		$this->report->setName($this->name)
			->setType($this->type)
			->setHAxisTitle($this->hAxisTitle)
			->setVAxisTitle($this->vAxisTitle)
			->setSqlMode($this->sqlMode)
			->setSqlCode($this->sqlCode);

		$this->report->save();
	}
}