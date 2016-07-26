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
			if ($this->isAjaxRequest()) {
				header('Content-Type: application/json');
				echo json_encode(array('status' => 200));
				exit();
			}
			else {
				\Flight::redirect($this->action->getRedirectUrl());
			}
		}
		else {
			if ($this->isAjaxRequest()) {
				header('Content-Type: application/json');
				echo json_encode(
					array(
						'status' => 503,
						'request' => \Flight::request(),
						'errors' => $this->action->getValidationErrors()
					)
				);
				exit();
			}
			else {
				var_dump(\Flight::request());
				var_dump($this->action->getValidationErrors());
				throw new ValidatorException('The action: ' . get_class($this->action) . ' could not be validated');
			}
		}
	}

	protected function isAjaxRequest() {
		return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
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