<?php

namespace PhpReports\Model;

use PhpReports\Model\Base\DatabaseColumn as BaseDatabaseColumn;

/**
 * Skeleton subclass for representing a row from the 'database_column' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class DatabaseColumn extends BaseDatabaseColumn
{

	public function getChartDataType() {
		$dataType = 'string';

		if (strpos($this->getDataType(), 'tinyint') !== false) {
			$dataType = 'boolean';
		}
		elseif (strpos($this->getDataType(), 'int') !== false || strpos($this->getDataType(), 'double') !== false) {
			$dataType = 'number';
		}
		elseif (strpos($this->getDataType(), 'char') !== false || strpos($this->getDataType(), 'text') !== false) {
			$dataType = 'string';
		}
		elseif (strpos($this->getDataType(), 'date') !== false) {
			$dataType = 'date';
		}
		return $dataType;
	}
}
