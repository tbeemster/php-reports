<?php
namespace PhpReports\Action\Dashboard;

use PhpReports\Action\Action;
use PhpReports\Model\DashboardReport;
use PhpReports\Model\DashboardReportQuery;

class DeleteReportAction extends Action {

	/** @var DashboardReport */
	protected $dashboardReport;

	public function collect() {
		$rank = $this->request->data['rank'];
		$dashboard = $this->request->data['dashboard'];

		$this->dashboardReport = DashboardReportQuery::create()->findOneByRank($rank, $dashboard);
	}

	public function validate() {
		return $this->dashboardReport instanceof DashboardReport;
	}

	public function execute() {
		$this->dashboardReport->delete();
	}
}