<?php
namespace PhpReports\Action\Report;

use PhpReports\Action\Action;
use PhpReports\Model\Map\VariableTableMap;
use PhpReports\Model\Report;
use PhpReports\Model\ReportQuery;
use PhpReports\Model\Variable;
use PhpReports\Model\VariableQuery;

class UpdateVariableAction extends Action {

	/** @var Report */
	protected $report;

	/** @var Variable */
	protected $variable;

	/** @string */
	protected $name;

	/** @string */
	protected $displayName;

	/** @string */
	protected $type;

	/** @string */
	protected $defaultValue;

	/** @string */
	protected $mayBeEmpty;

	/** @string */
	protected $multipleValuesAllowed;

	/** @var boolean */
	protected $populateFromDatabase;

	/** @var string */
	protected $databaseTable;

	/** @var string */
	protected $databaseColumn;

	/** @var string */
	protected $databaseDisplay;

	/** @var string */
	protected $databaseWhere;

	/** @var boolean */
	protected $databaseAll;

	public function collect() {
		$this->variable = VariableQuery::create()->findOneById($this->request->data['variable']);
		if (!$this->variable instanceof Variable) {
			$this->report = ReportQuery::create()->findOneById($this->request->data['report']);
			$this->variable = new Variable();
		}

		$this->name = $this->request->data['variable_name'];
		$this->displayName = $this->request->data['display_name'];
		$this->type = $this->request->data['variable_type'];
		$this->defaultValue = $this->request->data['variable_default'];
		$this->mayBeEmpty = $this->request->data['variable_empty'];
		$this->multipleValuesAllowed = $this->request->data['variable_multiple'];

		$this->populateFromDatabase = $this->request->data['database_populate'];
		$this->databaseTable = $this->request->data['database_table'];
		$this->databaseColumn = $this->request->data['database_column'];
		$this->databaseDisplay = $this->request->data['database_display'];
		$this->databaseWhere = $this->request->data['database_where'];
		$this->databaseAll = $this->request->data['database_all'];
	}

	public function validate() {
		$validators = array(
			'name' => true,
			'displayName' => true,
			'defaultValue' => false,
			'database' => false
		);

		switch ($this->type) {
			case VariableTableMap::COL_TYPE_DATE:
			case VariableTableMap::COL_TYPE_DATERANGE:
				$validators['defaultValue'] = true;
				break;
			case VariableTableMap::COL_TYPE_SELECT:
				if ($this->populateFromDatabase) {
					$validators['database'] = true;
				}
				break;
		}

		foreach ($validators as $validator => $enabled) {
			if (!$enabled) {
				continue;
			}

			switch ($validator) {
				case 'name':
				case 'displayName':
					if (strlen($this->$validator) > 3 == false) {
						$this->validationErrors[] = new \Exception($validator . ' should be longer than 3 characters.');
					}
					break;
				case 'defaultValue':
					break;
				case 'database':
					if (strlen($this->databaseTable) > 2 == false) {
						$this->validationErrors[] = new \Exception($validator . ' should be longer than 2 characters.');
					}
					if (strlen($this->databaseColumn) > 2 == false) {
						$this->validationErrors[] = new \Exception($validator . ' should be longer than 2 characters.');
					}
					if (strlen($this->databaseDisplay) > 2 == false) {
						$this->validationErrors[] = new \Exception($validator . ' should be longer than 2 characters.');
					}
			}
		}

		if ($this->variable->isNew() && (!$this->report instanceof Report)) {
			$this->validationErrors[] = new \Exception('The instance of Report could not be found.');
		}

		if ($this->variable instanceof Variable) {
			$this->validationErrors[] = new \Exception('The instance of Variable could not be found.');
		}
		return (count($this->validationErrors) > 0 ? true : false);
	}

	public function execute() {
		$this->variable->setName($this->name)
			->setDisplayName($this->displayName)
			->setType($this->type)
			->setDefaultValue($this->defaultValue)
			->setEmpty($this->mayBeEmpty)
			->setMultiple($this->multipleValuesAllowed);
		if ($this->type == VariableTableMap::COL_TYPE_SELECT && $this->populateFromDatabase) {
			$this->variable->setDatabasePopulate($this->populateFromDatabase)
				->setDatabaseTable($this->databaseTable)
				->setDatabaseColumn($this->databaseColumn)
				->setDatabaseDisplay($this->databaseDisplay)
				->setDatabaseWhere($this->databaseWhere)
				->setDatabaseAll($this->databaseAll);
		}
		if ($this->variable->isNew()) {
			$this->report->addVariable($this->variable);
			$this->report->save();
		}
		else {
			$this->variable->save();
		}
	}
}