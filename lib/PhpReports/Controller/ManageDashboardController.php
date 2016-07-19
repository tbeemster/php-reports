<?php
namespace PhpReports\Controller;

use PhpReports\Model\Dashboard;
use PhpReports\Model\DashboardQuery;
use PhpReports\Model\DashboardReport;
use PhpReports\Model\DashboardReportQuery;
use PhpReports\Model\DatabaseSourceQuery;
use PhpReports\PhpReports;

class ManageDashboardController {

	public function add() {
		echo PhpReports::render('ManageDashboard/add', array());
	}

	public function edit() {
		$request = \Flight::request();

		if (count($request->query->getData()) > 0) {
			$dashboardId = $request->query['dashboard'];
			$dashboard = DashboardQuery::create()->findOneById($dashboardId);
			if (!$dashboard instanceof Dashboard) {
				throw new \Exception('Dashboard not found! ' . $dashboardId);
			}
		}
		else {
			throw new \Exception('No dashboard given! ');
		}
		$dataSources = DatabaseSourceQuery::create()->find();

		$templateVars = array(
			'dashboard' => $dashboard,
			'dataSources' => $dataSources,
		);
		echo PhpReports::render('ManageDashboard/edit', $templateVars);
	}

	public function editReport() {
		$request = \Flight::request();

		if (count($request->query->getData()) > 0) {
			$dashboardReportId = (int)$request->query['dashboardReport'];
			$dashboardReport = DashboardReportQuery::create()->findOneById($dashboardReportId);
			if (!$dashboardReport instanceof DashboardReport) {
				throw new \Exception('DashboardReport not found! ID: ' . $dashboardReportId);
			}
		}
		else {
			throw new \Exception('No dashboard given! ');
		}

		$templateVars = array(
			'dashboardReport' => $dashboardReport
		);
		echo PhpReports::render('ManageDashboard/editReport', $templateVars);
	}

	public function showAll() {
		$dashboards = DashboardQuery::create()->find();
		echo PhpReports::render('ManageDashboard/showAll', array('dashboards' => $dashboards));
	}
}