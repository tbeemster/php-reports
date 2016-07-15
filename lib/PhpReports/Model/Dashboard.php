<?php

namespace PhpReports\Model;

use PhpReports\Model\Base\Dashboard as BaseDashboard;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Connection\ConnectionInterface;

/**
 * Skeleton subclass for representing a row from the 'dashboard' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Dashboard extends BaseDashboard {

	public function preInsert(ConnectionInterface $con = null) {
		$this->setCreatedAt(time());
		$this->setUpdatedAt(time());
		return true;
	}

	public function preUpdate(ConnectionInterface $con = null) {
		$this->setUpdatedAt(time());
		return true;
	}

	/**
	 * Returns the reports sorted by Rank
	 * @return DashboardReport[]|\Propel\Runtime\Collection\ObjectCollection
	 */
	public function getDashboardReportsByRank() {
		return DashboardReportQuery::create()->orderByRank(Criteria::ASC)->findByDashboardId($this->getId());
	}

}
