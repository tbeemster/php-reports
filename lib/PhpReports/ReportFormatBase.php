<?php
namespace PhpReports;

use PhpReports\Model\Base\ReportQuery;
use PhpReports\Report\GeneratedReport;

abstract class ReportFormatBase {
	abstract public static function display(&$report, &$request);

	/**
	 * Returns the Report class based on the given report (generated or file based)
	 * @param string $report
	 * @return Report
	 * @throws \Exception
	 */
	public static function prepareReport($report) {
		$environment = $_SESSION['environment'];

		$macros = array();
		if(isset($_GET['macros'])) $macros = $_GET['macros'];

		if (file_exists(Report::getFileLocation($report))) {
			return new Report($report, $macros, $environment);
		}

		$reportModel = ReportQuery::create()->findOneById((int)$report);
		if ($reportModel instanceof \PhpReports\Model\Report) {
			return new GeneratedReport($reportModel->getId(), $macros, $environment);
		}
		throw new \Exception('Report not found - ' . $report);
	}

}
