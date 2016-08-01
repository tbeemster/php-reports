<?php
namespace PhpReports\Action\Report;

use PhpReports\Action\Action;
use PhpReports\Model\Chart;
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
	protected $pointsVisible;

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
		$this->sqlMode = $this->request->data['sql_mode'];
		$this->sqlCode = $this->request->data['sql_code'];
		$this->hAxisTitle = $this->request->data['h_axis_title'];
		$this->vAxisTitle = $this->request->data['v_axis_title'];
		$this->pointsVisible = (boolean)$this->request->data['points_visible'];
	}

	public function validate() {
		return ($this->report instanceof Report);
	}

	public function execute() {
		$this->report->setName($this->name)
			->setType($this->type)
			->setSqlMode($this->sqlMode)
			->setSqlCode($this->sqlCode);

		/** @var Chart $chart */
		$chart = $this->report->getCharts()->getFirst();
		if (!$chart instanceof Chart) {
			$chart = new Chart();
			$this->report->addChart($chart);
		}
		$chart->setType($this->type)
			->setHAxisTitle($this->hAxisTitle)
			->setVAxisTitle($this->vAxisTitle)
			->setPointsVisible($this->pointsVisible)
			->save();

		$this->report->save();
	}
}