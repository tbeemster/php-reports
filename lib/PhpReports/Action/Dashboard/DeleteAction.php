<?php
namespace PhpReports\Action\Dashboard;

use flight\net\Request;
use PhpReports\Action\Action;
use PhpReports\Model\Dashboard;
use PhpReports\Model\DashboardQuery;
use PhpReports\PhpReports;

class DeleteAction extends Action {

	/** @var Request */
	protected $request;

	/** @var Dashboard */
	protected $dashboard;

	public function collect() {
		$this->request = \Flight::request();
		$this->dashboard = DashboardQuery::create()->findOneById((int)$this->request->data['dashboard']);
	}

	public function validate() {
		return $this->dashboard instanceof Dashboard;
	}

	public function execute() {
		$this->dashboard->delete();

		\Flight::redirect(PhpReports::$request->base . '/manage-dashboard/show-all');
	}
}