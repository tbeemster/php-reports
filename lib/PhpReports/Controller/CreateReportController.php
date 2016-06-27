<?php
namespace PhpReports\Controller;

use PhpReports\Model\Base\DatabaseJoinQuery;
use PhpReports\Model\Base\DatabaseTableQuery;
use PhpReports\Model\DatabaseSourceQuery;
use PhpReports\PhpReports;
use Propel\Runtime\ActiveQuery\Criteria;

class CreateReportController {

	public function chooseTables($dataSource) {
		$request = \Flight::request();
		$reportId = time();
		if (count($request->query->getData()) > 0) {
			$reportId = $request->query['report'];

			$column = $request->query->getData();
			$_SESSION['report_' . $reportId][$column['type']][] = $column['column'];
		}
		$dataSource = DatabaseSourceQuery::create()->findOneByDatabaseName($dataSource);
		$tables = DatabaseTableQuery::create()->filterByDatabaseSource($dataSource)->filterByHidden(false)->orderByName(Criteria::ASC)->find();

		$dbJoins = DatabaseJoinQuery::create()->filterByDatabaseSource($dataSource)->find();
		$templateVars = array(
			'dbJoins' => $dbJoins,
			'tables' => $tables,
			'reportStorage' => $_SESSION['report_' . $reportId],
			'reportId' => $reportId,
			'dataSource' => $dataSource
		);
		echo PhpReports::render('create_report/choose_tables', $templateVars);
	}
}