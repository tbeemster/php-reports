<?php

namespace PhpReports\Model;

use PhpReports\Model\Base\DashboardReport as BaseDashboardReport;
use PhpReports\Model\Map\DashboardReportTableMap;

/**
 * Skeleton subclass for representing a row from the 'dashboard_report' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class DashboardReport extends BaseDashboardReport
{

	public function getTypes() {
		return DashboardReportTableMap::getValueSet(DashboardReportTableMap::COL_TYPE);
	}

	public function getVariables() {
		$variables = parent::getVariables();
		$variables = unserialize($variables);

		$macros = '';
		foreach ($variables as $key => $value) {
			if (is_array($value)) {
				foreach ($value as $keyy => $val) {
					$macros .= '&macros[' . $key . '][]=' . $val;
				}
			}
			else {
				$macros .= '&macros[' . $key . ']=' . $value;

			}
		}
		return $macros;
	}

}
