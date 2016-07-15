<?php
namespace PhpReports\Action\Dashboard;

use flight\net\Request;
use PhpReports\Action\Action;
use PhpReports\Model\Dashboard;
use PhpReports\PhpReports;

class AddAction extends Action {

	/** @var Request */
	protected $request;

	/** @var string */
	protected $name;

	public function collect() {
		$this->request = \Flight::request();
		$this->name = $this->request->data['name'];
	}

	public function validate() {
		if (strlen($this->name) < 3) {
			return false;
		}

		return true;
	}

	public function execute() {
		$dashboard = new Dashboard();
		$dashboard->setName($this->name)->save();

		\Flight::redirect(PhpReports::$request->base . '/manage-dashboard/edit/?dashboard=' . $dashboard->getId());
	}
}