<?php
use PhpReports\FilterBase;

class hideFilter extends FilterBase {
	public static function filter($value, $options = array(), &$report, &$row) {
		return false;
	}
}
