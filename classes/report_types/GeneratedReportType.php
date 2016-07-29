<?php
use PhpReports\Model\Base\DatabaseColumnQuery;
use PhpReports\Model\DatabaseJoin;
use PhpReports\Model\DatabaseTable;
use PhpReports\Model\Report as ReportModel;

class GeneratedReportType extends PdoReportType {

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
	 * @param \PhpReports\Report\GeneratedReport $report
	 * @return mixed
	 * @throws Exception
	 */
	public static function run(&$report) {
		/** @var ReportModel $reportModel */
		$reportModel = $report->report;

		if ($reportModel->getSqlMode() == 1) {
			$sql = $reportModel->getSqlCode();
		}
		else {
			$sql = self::generateSql($reportModel);
		}

		$variables = array();
		foreach ($report->options['Variables'] as $variable => $value) {
			$variables[$variable] = $value['default'];
			if (array_key_exists($variable, $report->macros)) {
				$variables[$variable] = $report->macros[$variable];
			}
		}

		$sql = PhpReports\PhpReports::renderString($sql, $variables);
		$sql = str_replace('\n', '', $sql);
		$result = $report->conn->query($sql);
		$rows = $result->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
	}

	/**
	 * Generates SQL code based on the given report
	 * @param ReportModel $report
	 */
	protected static function generateSql(ReportModel $reportModel) {
		$tables = array();
		$joins = array();

		$sql = 'SELECT ';

		$i = 0;
		foreach ($reportModel->getDatabaseColumns() as $column) {
			if ($i > 0) {
				$sql .= ', ';
			}
			foreach ($column->getDatabaseJoinsRelatedByForeignColumn() as $join) {
				$joins[] = $join;
			}
			$sql .= $column->getDatabaseTable()->getName() . '.' . $column->getName();

			$i++;
			$tables[$column->getDatabaseTable()->getId()] = $column->getDatabaseTable();
		}

		$sql .= ' FROM ';

		$i = 0;

		/** @var DatabaseTable $table */
		foreach ($tables as $table) {
			if ($i > 0) {
				$sql .= ', ';
			}
			$sql .= $table->getName();

			$i++;
		}

		$i = 0;
		/** @var DatabaseJoin $join */
		foreach ($joins as $join) {
			if ($i == 0) {
				$sql .= ' WHERE ';
			}
			else {
				$sql .= ' AND ';
			}
			$localColumn = DatabaseColumnQuery::create()->findOneById($join->getLocalColumn());
			$foreignColumn = DatabaseColumnQuery::create()->findOneById($join->getForeignColumn());
			$sql .= $localColumn->getDatabaseTable()->getName() . '.' . $localColumn->getName() . ' = ' . $foreignColumn->getDatabaseTable()->getName() . '.' . $foreignColumn->getName();
		}
		return $sql . ' LIMIT 100';
	}
}
