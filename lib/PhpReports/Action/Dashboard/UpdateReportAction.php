<?php
namespace PhpReports\Action\Dashboard;

use PhpReports\Action\Action;
use PhpReports\Model\DashboardReport;
use PhpReports\Model\DashboardReportQuery;
use PhpReports\Model\Map\DashboardReportTableMap;
use Propel\Runtime\Exception\ClassNotFoundException;

class UpdateReportAction extends Action {

	/** @var DashboardReport */
	protected $dashboardReport;

	/** @var string */
	protected $type;

	public function collect() {
		$this->dashboardReport = DashboardReportQuery::create()->findOneById((int)$this->request->data['dashboardReport']);
		$this->type = $this->request->data['type'];
	}

	public function validate() {
		if (!$this->dashboardReport instanceof DashboardReport) {
			$this->validationErrors[] = new ClassNotFoundException('Class DashboardReport not found');
		}
		if (!in_array($this->type, DashboardReportTableMap::getValueSet(DashboardReportTableMap::COL_TYPE))) {
			$this->validationErrors[] = new \Exception($this->type . ' is not part of the Type ValueSet');
		}
		return (count($this->validationErrors) > 0 ? false : true);
	}

	public function execute() {
		$this->dashboardReport->setType($this->type)->save();
	}
}