<?php
namespace PhpReports\Report;

use PhpReports\Model\Base\ReportQuery;
use PhpReports\Model\Map\VariableTableMap;
use PhpReports\Model\Report as ReportModel;
use PhpReports\Model\Variable;
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
		$this->headers[] = 'Chart';
		$this->headers[] = 'Variable';
		$this->headers[] = 'Rollup';
		$this->options['Type'] = 'Generated';
		$this->options['Filters'] = array();
		$this->options['Variables'] = self::extractVariables($report);
		$this->options['Includes'] = array();
		$this->options['Name'] = $report->getName();
		$this->options['Charts'] = self::extractCharts($report);
		$this->options['has_charts'] = (count($this->options['Charts']) > 0 ? true : false);
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

	/**
	 * Extracts the variable(s) from the Report Model and returns them as an array
	 * @param ReportModel $report
	 * @return array
	 * @throws \Propel\Runtime\Exception\PropelException
	 */
	public static function extractVariables(ReportModel $report) {
		if ($report->countVariables() == 0) {
			return array();
		}

		$variables = array();

		/** @var Variable $variable */
		foreach ($report->getVariables() as $variable) {
			$variables[$variable->getName()] = array(
				'name' => $variable->getName(),
				'display' => $variable->getDisplayName(),
				'type' => $variable->getType(),
				'empty' => $variable->getEmpty(),
				'multiple' => $variable->getMultiple(),
			);
			if ($variable->getDefaultValue()) {
				$variables[$variable->getName()]['default'] = $variable->getDefaultValue();
			}

			if ($variable->getType() == VariableTableMap::COL_TYPE_DATERANGE) {
				$variables[$variable->getName()]['default'] = array(
					'start' => date('Y-m-d', strtotime('last month')),
					'end' => date('Y-m-d', strtotime('today'))
				);
			}
			elseif ($variable->getType() == VariableTableMap::COL_TYPE_SELECT) {
				$variables[$variable->getName()]['database_options'] = array(
					'table' => $variable->getDatabaseTable(),
					'column' => $variable->getDatabaseColumn(),
					'display' => $variable->getDatabaseDisplay(),
					'all' => $variable->getDatabaseAll(),
				);
			}
		}
		return $variables;
	}

	/**
	 * Extracts the chart(s) from the Report Model and returns them as an array
	 * @param ReportModel $report
	 * @return array
	 */
	public static function extractCharts(ReportModel $report) {
		/** @todo separate chart as its own entity, so countables are possible */
		if (false) {
			return array();
		}

		$charts = array(
			0 => array(
				'type' => $report->getType(),
				'dataset' => 0,
				'title' => $report->getName(),
				'h-axis-title' => $report->getHAxisTitle(),
				'v-axis-title' => $report->getVAxisTitle(),
				'width' => "100%",
				'height' => "400px",
				'xhistogram' => false,
				'buckets' => 0,
				'omit-totals' => false,
				'rotate-x-labels' => true,
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
		$i = 0;
		foreach ($report->getDatabaseColumnDataTypes() as $column) {
			$charts[0]['columns'][] = $i;
			$charts[0]['datatypes'][] = $column[1];
			$i++;
		}
		return $charts;
	}
}
?>