<?php
namespace PhpReports\Action\Report;

use flight\net\Request;
use PhpReports\Action\Action;
use PhpReports\Model\DatabaseSource;
use PhpReports\Model\Report;
use PhpReports\Model\ReportQuery;
use PhpReports\Model\Variable;

class UpdateAction extends Action {

	/** @var Request */
	protected $request;

	/** @var Report */
	protected $report;

	/** @var string */
	protected $name;

	/** @var string */
	protected $type;

	/** @var string */
	protected $hAxisTitle;

	/** @var string */
	protected $vAxisTitle;

	/** @var boolean */
	protected $sqlMode;

	/** @var string */
	protected $sqlCode;

	/** @var DatabaseSource */
	protected $dataSource;

	/** @string */
	protected $variableName;

	/** @string */
	protected $displayName;

	/** @string */
	protected $variableType;

	/** @string */
	protected $variableDefault;

	/** @string */
	protected $variableEmpty;

	/** @string */
	protected $variableMultiple;

	public function collect() {
		$this->request = \Flight::request();
		$this->report = ReportQuery::create()->findOneById($this->request->data['report']);
		$this->name = $this->request->data['name'];
		$this->type = $this->request->data['report_type'];
		$this->hAxisTitle = $this->request->data['h_axis_title'];
		$this->vAxisTitle = $this->request->data['v_axis_title'];
		$this->sqlMode = $this->request->data['sql_mode'];
		$this->sqlCode = $this->request->data['sql_code'];

		$this->variableName = $this->request->data['variable_name'];
		$this->displayName = $this->request->data['display_name'];
		$this->variableType = $this->request->data['variable_type'];
		$this->variableDefault = $this->request->data['variable_default'];
		$this->variableEmpty = $this->request->data['variable_empty'];
		$this->variableMultiple = $this->request->data['variable_multiple'];
	}

	public function validate() {
		return ($this->report instanceof Report);
	}

	public function execute() {
		$this->report->setName($this->name)
			->setType($this->type)
			->setHAxisTitle($this->hAxisTitle)
			->setVAxisTitle($this->vAxisTitle)
			->setSqlMode($this->sqlMode)
			->setSqlCode($this->sqlCode);

		$variable = $this->report->getVariables()->getFirst();
		if (!$variable instanceof Variable) {
			$variable = new Variable();
		}
		$variable->setName($this->variableName)
			->setDisplayName($this->displayName)
			->setType($this->variableType)
			->setDefaultValue($this->variableDefault)
			->setEmpty($this->variableEmpty)
			->setMultiple($this->variableMultiple)
			->save();

		$this->report->addVariable($variable);

		$this->report->save();
	}
}