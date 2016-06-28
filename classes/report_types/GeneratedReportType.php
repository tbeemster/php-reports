<?php
use PhpReports\Model\Report as ReportModel;
use PhpReports\Report;
use PhpReports\ReportTypeBase;

class GeneratedReportType extends ReportTypeBase {
	public static function init(&$report) {
		$report->raw_query = "<?php\n//REPORT: " . $report->report . "\n" . trim($report->raw_query);

		//if there are any included reports, add it to the top of the raw query
		if (isset($report->options['Includes'])) {
			$included_code = '';
			foreach ($report->options['Includes'] as &$included_report) {
				$included_code .= "\n<?php /*BEGIN INCLUDED REPORT*/ ?>" . trim($included_report->raw_query) . "<?php /*END INCLUDED REPORT*/ ?>";
			}

			if ($included_code) {
				$included_code .= "\n";
			}

			$report->raw_query = $included_code . $report->raw_query;

			//make sure the raw query has a closing PHP tag at the end
			//this makes sure it will play nice as an included report
			if (!preg_match('/\?>\s*$/', $report->raw_query)) {
				$report->raw_query .= "\n?>";
			}
		}
	}

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

		$sql = 'SELECT ActionLog.alUsID, ActionLog.alSubject FROM ActionLog LIMIT 100;';
		$report->options['Name'] = $reportModel->getName();
		$report->options['Query'] = $sql;
		$report->options['Query_Formatted'] = SqlFormatter::format($sql);
		$report->options['Filters'] = array();
		$report->options['Variables'] = array();
		$report->options['Includes'] = array();
		$report->options['Name'] = $reportModel->getName();
		$report->options['Charts'] = array(
			0 => array(
				'type' => $reportModel->getType(),
				'columns' => array('alUsID', 'alSubject'),
				'dataset' => 0,
				'title' => "Line Chart chart",
				'width' => "100%",
				'height' => "400px",
				'xhistogram' => false,
				'buckets' => 0,
				'omit-totals' => false,
				'rotate-x-labels' => false,
				'grid' => false,
				'timefmt' => "",
				'xformat' => "",
				'yrange' => "",
				'all' => false,
				'colors' => array(),
				'roles' => array(),
				'markers' => false,
				'omit-columns' => array(),
				'options' => array(),
				'num' => 1,
				'Rows' => array(),
			)
		);
		$report->options['has_charts'] = true;

		$result = $report->conn->query($sql);
		$rows = $result->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
	}
}
