<?php
namespace PhpReports\Action\Dashboard;

use PhpReports\Action\Action;
use PhpReports\Model\Dashboard;
use PhpReports\Model\DashboardQuery;
use PhpReports\Model\DashboardReport;
use PhpReports\Model\Map\DashboardReportTableMap;
use PhpReports\Model\Report;
use PhpReports\Model\ReportQuery;
use Propel\Runtime\Exception\ClassNotFoundException;

class AddReportAction extends Action {

	/** @var Dashboard */
	protected $dashboard;

	/** @var Report */
	protected $report;

	public function collect() {
		$this->dashboard = DashboardQuery::create()->findOneById((int)$this->request->data['dashboard']);
		$this->report = ReportQuery::create()->findOneById((int)$this->request->data['report']);
	}

	public function validate() {
		if (!$this->report instanceof Report) {
			$this->validationErrors[] = new ClassNotFoundException('Class Report not found');
		}
		if (!$this->dashboard instanceof Dashboard) {
			$this->validationErrors[] = new ClassNotFoundException('Class Dashboard not found');
		}
		return (count($this->validationErrors) > 0 ? false : true);
	}

	public function execute() {
		$dashboardReport = new DashboardReport();
		$dashboardReport->setDashboard($this->dashboard);
		$dashboardReport->setReport($this->report);
		$dashboardReport->setType(DashboardReportTableMap::COL_TYPE_CHART);
		$this->dashboard->addDashboardReport($dashboardReport);
		$this->dashboard->save();
	}
}