<?php
namespace PhpReports\Action\Dashboard;

use flight\net\Request;
use PhpReports\Action\Action;
use PhpReports\Model\DashboardReport;
use PhpReports\Model\DashboardReportQuery;
use Propel\Runtime\Exception\ClassNotFoundException;

class MoveReportAction extends Action {

	/** @var Request */
	protected $request;

	/** @var DashboardReport */
	protected $dashboardReport;

	/** @var string */
	protected $direction;

	public function collect() {
		$this->request = \Flight::request();
		$rank = $this->request->data['rank'];
		$dashboard = $this->request->data['dashboard'];
		$this->direction = $this->request->data['direction'];

		$this->dashboardReport = DashboardReportQuery::create()->findOneByRank($rank, $dashboard);
	}

	public function validate() {
		if (!$this->dashboardReport instanceof DashboardReport) {
			$this->validationErrors[] = new ClassNotFoundException('Dashboard Report not found');
		}

		if ($this->direction != 'up' && $this->direction != 'down') {
			$this->validationErrors[] = new \Exception('Input direction should be either `up` or `down`');
		}
		return (count($this->validationErrors) > 0 ? false : true);
	}

	public function execute() {
		if ($this->direction == 'up') {
			$this->dashboardReport->moveUp();
		}
		elseif ($this->direction == 'down') {
			$this->dashboardReport->moveDown();
		}
		$this->dashboardReport->save();
	}
}