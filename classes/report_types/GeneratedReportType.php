<?php
use PhpReports\Model\Report as ReportModel;
use PhpReports\Report;
use PhpReports\ReportTypeBase;

class GeneratedReportType extends ReportTypeBase {

	/**
	 * Opens the PDO connection
	 * @param \PhpReports\Report $report
	 */
	public static function openConnection(&$report) {
		/** @var ReportModel $reportModel */
		$reportModel = $report->report;
		$dataSource = $reportModel->getDatabaseSource();

		$dsn = $dataSource->getDsn();

		//the default is to use a user with read only privileges
		$username = $dataSource->getUsername();
		$password = $dataSource->getPassword();

		$report->conn = new PDO($dsn, $username, $password);
		$report->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	/**
	 * Closes the PDO connection
	 * @param \PhpReports\Report\GeneratedReport $report
	 */
	public static function closeConnection(&$report) {
		if (!isset($report->conn)) {
			return;
		}
		$report->conn = null;
		unset($report->conn);
	}

	/**
	 * @param \PhpReports\Report\GeneratedReport $report
	 * @return mixed
	 * @throws Exception
	 */
	public static function run(&$report) {
		/** @var ReportModel $reportModel */
		$reportModel = $report->report;

		$sql = 'SHOW TABLES;';

		$result = $report->conn->query($sql);
		$rows = $result->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
	}
}
