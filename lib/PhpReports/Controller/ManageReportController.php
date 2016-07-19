<?php
namespace PhpReports\Controller;

use PhpReports\Model\Base\DatabaseJoinQuery;
use PhpReports\Model\DatabaseSource;
use PhpReports\Model\DatabaseSourceQuery;
use PhpReports\Model\Report;
use PhpReports\Model\ReportQuery;
use PhpReports\PhpReports;

class ManageReportController {

	public function add($dataSources = null) {
		$dataSources = DatabaseSourceQuery::create()->findOneByDatabaseName($dataSources);
		if (!$dataSources instanceof DatabaseSource) {
			$dataSources = DatabaseSourceQuery::create()->find();
		}

		$templateVars = array(
			'dataSources' => $dataSources
		);
		echo PhpReports::render('ManageReport/add', $templateVars);
	}


	public function edit() {
		$request = \Flight::request();

		if (count($request->query->getData()) > 0) {
			$reportId = $request->query['report'];
			$report = ReportQuery::create()->findOneById($reportId);
			if (!$report instanceof Report) {
				throw new \Exception('Report not found! ' . $reportId);
			}
		}
		else {
			throw new \Exception('No report given! ');
		}
		$columns = $report->getDatabaseColumns();
		$tables = array();
		foreach ($columns as $column) {
			$table = $column->getDatabaseTable();
			$tables[$table->getId()] = $table;
		}
		$dbJoins = DatabaseJoinQuery::create()->filterByDatabaseSource($report->getDatabaseSource())->find();

		$chartTypes = array(
			'LineChart',
			'GeoChart',
			'AnnotatedTimeLine',
			'BarChart',
			'ColumnChart',
			'Timeline',
			'AreaChart',
			'Histogram',
			'ComboChart',
			'BubbleChart',
			'CandlestickChart',
			'Gauge',
			'Map',
			'PieChart',
			'Sankey',
			'ScatterChart',
			'SteppedAreaChart',
			'WordTree'
		);

		$templateVars = array(
			'dbJoins' => $dbJoins,
			'tables' => $tables,
			'report' => $report,
			'dataSource' => $report->getDatabaseSource(),
			'chartTypes' => $chartTypes
		);
		echo PhpReports::render('ManageReport/edit', $templateVars);
	}
}