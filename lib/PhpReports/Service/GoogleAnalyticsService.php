<?php
namespace PhpReports\Service;

use PhpReports\PhpReports;

class GoogleAnalyticsService {

	/** @var \Google_Client */
	protected $googleClient;

	/** @var \Google_Service_Analytics */
	protected $googleServiceAnalytics;

	public function init() {
		$this->googleClient = new \Google_Client();
		$this->googleClient->setApplicationName(PhpReports::$config['ga_api']['applicationName']);
		$this->googleClient->setClientId(PhpReports::$config['ga_api']['clientId']);
		$this->googleClient->setAccessType('offline');
		$this->googleClient->setClientSecret(PhpReports::$config['ga_api']['clientSecret']);
		$this->googleClient->setRedirectUri(PhpReports::$config['ga_api']['redirectUri']);
		$this->googleServiceAnalytics = new \Google_Service_Analytics($this->googleClient);
		$this->googleClient->addScope(\Google_Service_Analytics::ANALYTICS);

		if (isset($_GET['code'])) {
			$this->googleClient->authenticate($_GET['code']);
			$_SESSION['ga_token'] = $this->googleClient->getAccessToken();

			if (isset($_SESSION['ga_authenticate_redirect'])) {
				$url = $_SESSION['ga_authenticate_redirect'];
				unset($_SESSION['ga_authenticate_redirect']);
				header("Location: $url");
				exit;
			}
		}
		if (isset($_SESSION['ga_token'])) {
			$this->googleClient->setAccessToken($_SESSION['ga_token']);
		}
		elseif (isset(PhpReports::$config['ga_api']['accessToken'])) {
			$this->googleClient->setAccessToken(PhpReports::$config['ga_api']['accessToken']);
			$_SESSION['ga_token'] = $this->googleClient->getAccessToken();
		}
	}

	/**
	 * Authorize the OAuth key
	 */
	public function authorize() {
		$authUrl = $this->googleClient->createAuthUrl();
		if (isset($_GET['redirect'])) {
			$_SESSION['ga_authenticate_redirect'] = $_GET['redirect'];
		}
		\Flight::redirect($authUrl);
	}

	/**
	 * @return \Google_Client
	 */
	public function getGoogleClient() {
		return $this->googleClient;
	}

	/**
	 * @return \Google_Service_Analytics
	 */
	public function getGoogleServiceAnalytics() {
		return $this->googleServiceAnalytics;
	}

}