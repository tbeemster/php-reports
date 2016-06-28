<?php
namespace PhpReports\Service;

use PhpReports\Model\Base\ReportQuery;

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

		foreach ($children as $child) {
			$reports['children'][] = array(
				'Filters' => array(),
				'Variables' => array(),
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
				'url' => 'http://dev.yardinternet.nl/timothe/php-reports/report/generated/?report=' . $child->getId() . '/',
				'is_dir' => false,
				'Id' => $child->getId()
			);
		}
		$reports['count'] = count($children);
		return $reports;
	}

}