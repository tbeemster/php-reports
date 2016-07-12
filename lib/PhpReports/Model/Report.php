<?php

namespace PhpReports\Model;

use PhpReports\Model\Base\Report as BaseReport;

/**
 * Skeleton subclass for representing a row from the 'report' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Report extends BaseReport
{

	public function __toString() {
		return $this->getId() . '';
	}

}