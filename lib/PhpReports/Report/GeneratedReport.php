<?php
namespace PhpReports\Report;

use PhpReports\Model\Base\ReportQuery;
use PhpReports\Model\Report as ReportModel;
use PhpReports\PhpReports;
use PhpReports\Report;

class GeneratedReport extends Report {

	/** @var \PDO */
	public $conn;

	/**
	 * GeneratedReport constructor.
	 * @param int $report
	 * @param array $macros
	 * @param array $environment
	 * @throws \Exception
	 */
	public function __construct($report, $macros = array(), $environment = null) {
		$report = ReportQuery::create()->findOneById((int)$report);
		$this->report = $report;

		if (!$report instanceof ReportModel) {
			throw new \Exception('Report not found - ' . $report);
		}

		/** @todo use CreatedAt dates from model */
		$this->filemtime = time();

		$this->use_cache = false;

		//get the raw report file
		$this->raw = $report;

		//split the raw report into headers and code
		list($this->raw_headers, $this->raw_query) = explode("\n\n", $this->raw, 2);

		$this->macros = array();
		foreach ($macros as $key => $value) {
			$this->addMacro($key, $value);
		}

		$this->options['Environment'] = $environment;

		$this->options['Type'] = 'Generated';

		$this->is_ready = true;
	}

	public function renderReportPage($template = 'html/report', $additional_vars = array()) {
		$this->run();

		$template_vars = array(
			'is_ready' => $this->is_ready,
			'async' => $this->async,
			'report_url' => PhpReports::$request->base . '/report/generated/?' . $_SERVER['QUERY_STRING'],
			'report_querystring' => $_SERVER['QUERY_STRING'],
			'base' => PhpReports::$request->base,
			'report' => $this->report,
			'vars' => $this->prepareVariableForm(),
			'macros' => $this->macros,
		);

		$template_vars = array_merge($template_vars, $additional_vars);

		$template_vars = array_merge($template_vars, $this->options);

		return PhpReports::render($template, $template_vars);
	}
}

?>
