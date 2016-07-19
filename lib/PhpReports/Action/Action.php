<?php
namespace PhpReports\Action;

use flight\net\Request;

abstract class Action {

	/** @var Request */
	protected $request;

	/** @var array<\Exception> */
	protected $validationErrors;

	/** @var string */
	protected $redirectUrl;

	/**
	 * Executes the action code
	 */
	abstract public function execute();

	/**
	 * Sets the redirect url to the referrer url.
	 */
	public function __construct() {
		$this->request = \Flight::request();
		$this->redirectUrl = $this->request->referrer;
	}

	/**
	 * Collects the input data
	 */
	public function collect() {

	}

	/**
	 * Validates the incoming request
	 * @return boolean
	 */
	public function validate() {
		return true;
	}

	/**
	 * Returns the redirect url
	 * @return string
	 */
	public function getRedirectUrl() {
		return $this->redirectUrl;
	}

	/**
	 * @return mixed
	 */
	public function getValidationErrors() {
		return $this->validationErrors;
	}

}