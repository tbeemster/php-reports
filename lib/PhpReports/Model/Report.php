<?php

namespace PhpReports\Model;

use PhpReports\Model\Base\Report as BaseReport;
use Propel\Runtime\Connection\ConnectionInterface;

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

	/** @var boolean */
	const SQL_MODE_GENERATED = false;

	/** @var boolean */
	const SQL_MODE_MANUAL = true;

	public function preInsert(ConnectionInterface $con = null) {
		$this->setCreatedAt(time());
		$this->setUpdatedAt(time());
		return true;
	}

	public function preUpdate(ConnectionInterface $con = null) {
		$this->setUpdatedAt(time());
		return true;
	}

	public function __toString() {
		return $this->getId() . '';
	}

}
