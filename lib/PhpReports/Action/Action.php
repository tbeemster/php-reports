<?php
namespace PhpReports\Action;

abstract class Action {

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
		$this->redirectUrl = \Flight::request()->referrer;
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

}