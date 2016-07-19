<?php
namespace PhpReports\Action\Dashboard;

use PhpReports\Action\Action;
use PhpReports\Model\DashboardReport;
use PhpReports\Model\DashboardReportQuery;

class DeleteReportAction extends Action {

	/** @var DashboardReport */
	protected $dashboardReport;

	public function collect() {
		$this->dashboardReport = DashboardReportQuery::create()->findOneById((int)$this->request->data['dashboardReport']);
	}

	public function validate() {
		return $this->dashboardReport instanceof DashboardReport;
	}

	public function execute() {
		$this->dashboardReport->delete();
	}
}