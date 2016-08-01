<?php
namespace PhpReports\Action\Report;

use PhpReports\Action\Action;
use PhpReports\Model\ReportVariable;
use PhpReports\Model\Variable;
use PhpReports\Model\VariableQuery;

class DeleteVariableAction extends Action {

	/** @var ReportVariable */
	protected $reportVariable;

	/** @var Variable */
	protected $variable;

	public function collect() {
		$this->variable = VariableQuery::create()->findOneById($this->request->data['variable']);
		$this->reportVariable = $this->variable->getReportVariables()->getFirst();
	}

	public function validate() {
		if ($this->variable instanceof Variable) {
			$this->validationErrors[] = new \Exception('The instance of Variable could not be found.');
		}
		return (count($this->validationErrors) > 0 ? true : false);
	}

	public function execute() {
		$this->reportVariable->delete();
		$this->variable->delete();
	}
}