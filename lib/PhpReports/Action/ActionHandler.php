<?php
namespace PhpReports\Action;

use flight\net\Request;
use Propel\Runtime\Exception\ClassNotFoundException;
use Symfony\Component\Validator\Exception\ValidatorException;

class ActionHandler {

	/** @var Action */
	protected $action;

	/**
	 * Checks if the given request is an action.
	 * If so, it will associate it with the current handler and return a boolean.
	 *
	 * @param Request $request
	 * @return bool
	 */
	public function isValidAction(Request $request) {
		$postData = $request->data->getData();
		if (!array_key_exists('action', $postData) || !array_key_exists('subject', $postData)) {
			return false;
		}

		$subNamespace = $this->slugToUpperCamelCase($request->data['subject']);
		$action = $this->slugToUpperCamelCase($request->data['action']);

		$fullyQualifiedNamespace = '\\PhpReports\\Action\\' . $subNamespace . '\\' . $action . 'Action';

		if (!class_exists($fullyQualifiedNamespace)) {
			throw new ClassNotFoundException('Class ' . $fullyQualifiedNamespace . ' has not been found');
		}
		$this->action = new $fullyQualifiedNamespace();
		return true;
	}

	/**
	 * Executes the current action associated with this handler
	 */
	public function executeAction() {
		$this->action->collect();
		if ($this->action->validate()) {
			$this->action->execute();
			\Flight::redirect($this->action->getRedirectUrl());
		}
		else {
			throw new ValidatorException('The action: ' . get_class($this->action) . ' could not be validated');
		}
	}

	/**
	 * Returns the given slug in UpperCamelCase
	 * @param string $slug
	 * @return mixed
	 */
	public function slugToUpperCamelCase($slug) {
		$loweredString = strtolower($slug);
		$uppercaseWords = ucwords($loweredString, "\t\n\r\f\v-_");
		return str_replace('-', '', $uppercaseWords);
	}
}