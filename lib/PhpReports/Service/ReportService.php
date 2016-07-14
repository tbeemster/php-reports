<?php
namespace PhpReports\Service;

use PhpReports\Model\Base\ReportQuery;
use PhpReports\Model\Report;
use PhpReports\PhpReports;

class ReportService {

	/**
	 * Returns all reports
	 * @return array
	 */
	public function getReports() {
		$children = ReportQuery::create()->find();

		$reports = array(
			'Name' => 'Generated Reports',
			'Title' => 'Generated Reports',
			'Id' => 'gen',
			'Description' => 'Reports generated in PhpReports.',
			'is_dir' => true
		);

		/** @var Report $child */
		foreach ($children as $child) {
			$reports['children'][] = array(
				'Filters' => array(),
				'Variables' => ($child->countVariables() > 0 ? true : false),
				'Charts' => ($child->countReportColumns() > 0 ? true : false),
				'Includes' => array(),
				'Name' => $child->getName(),
				'access' => 'readonly',
				'noreport' => false,
				'ignore' => false,
				'stop' => false,
				'version' => 1,
				'default_dataset' => 0,
				'Formatting' => array(),
				'Rollup' => array(),
				'Type' => 'Gen',
				'Database' => 'gen',
				'report' => $child->getId(),
				'url' => PhpReports::$request->base . '/report/generated/?report=' . $child->getId() . '/',
				'is_dir' => false,
				'Id' => $child->getId()
			);
		}
		$reports['count'] = count($children);
		return $reports;
	}

}