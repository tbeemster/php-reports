<?php
namespace PhpReports\Controller;

use PhpReports\Model\Base\DatabaseJoinQuery;
use PhpReports\Model\DatabaseSourceQuery;
use PhpReports\Model\Report;
use PhpReports\Model\ReportQuery;
use PhpReports\PhpReports;

class CreateReportController {

	public function chooseTables($dataSource) {
		$dataSource = DatabaseSourceQuery::create()->findOneByDatabaseName($dataSource);

		$templateVars = array(
			'dataSource' => $dataSource
		);
		echo PhpReports::render('create_report/new_report', $templateVars);
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
		echo PhpReports::render('create_report/choose_tables', $templateVars);
	}
}