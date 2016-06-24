<?php

namespace PhpReports\Model;

use PhpReports\Model\Base\DatabaseSource as BaseDatabaseSource;

/**
 * Skeleton subclass for representing a row from the 'database_source' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class DatabaseSource extends BaseDatabaseSource
{

	/**
	 * Returns the DSN string from the current Database Source.
	 * @return string
	 */
	public function getDsn() {
		return $this->getDbms() . ':host=' . $this->getHost() . ';dbname=' . $this->getDatabaseName();
	}

}
