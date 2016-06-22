<?php
// for build-in php server serve the requested resource as-is.
use PhpReports\ManageDatabase;
use PhpReports\Model\DatabaseSource;
use PhpReports\Model\DatabaseSourceQuery;
use PhpReports\PhpReports;

if (php_sapi_name() == 'cli-server' && preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER["REQUEST_URI"])) {
    return false;
}

session_start();

//set php ini so the page doesn't time out for long requests
ini_set('max_execution_time', 300);

//sets up autoloading of composer dependencies
include 'vendor/autoload.php';

require_once 'generated-conf/config.php';

header("Access-Control-Allow-Origin: *");

// Google Analytics API
if(isset(PhpReports::$config['ga_api'])) {
  $ga_client = new Google_Client();
  $ga_client->setApplicationName(PhpReports::$config['ga_api']['applicationName']);
  $ga_client->setClientId(PhpReports::$config['ga_api']['clientId']);
  $ga_client->setAccessType('offline');
  $ga_client->setClientSecret(PhpReports::$config['ga_api']['clientSecret']);
  $ga_client->setRedirectUri(PhpReports::$config['ga_api']['redirectUri']);
  $ga_service = new Google_Service_Analytics($ga_client);
  $ga_client->addScope(Google_Service_Analytics::ANALYTICS);
  if(isset($_GET['code'])) {
    $ga_client->authenticate($_GET['code']);
    $_SESSION['ga_token'] = $ga_client->getAccessToken();
    
    if(isset($_SESSION['ga_authenticate_redirect'])) {
      $url = $_SESSION['ga_authenticate_redirect'];
      unset($_SESSION['ga_authenticate_redirect']);
      header("Location: $url");
      exit;
    }
  }
  if(isset($_SESSION['ga_token'])) {    
    $ga_client->setAccessToken($_SESSION['ga_token']);
  }
  elseif(isset(PhpReports::$config['ga_api']['accessToken'])) {    
    $ga_client->setAccessToken(PhpReports::$config['ga_api']['accessToken']);
    $_SESSION['ga_token'] = $ga_client->getAccessToken();
  }
  
  Flight::route('/ga_authenticate',function() use($ga_client) {
    $authUrl = $ga_client->createAuthUrl();
    if(isset($_GET['redirect'])) {
      $_SESSION['ga_authenticate_redirect'] = $_GET['redirect'];
    }
    header("Location: $authUrl");
    exit;
  });
}

Flight::route('/',function() {
	PhpReports::listReports();
});

Flight::route('/configure', function () {
	PhpReports::configure();
});

Flight::route('POST /configure/database', function () {

	$request = Flight::request();
	$dbms = $request->data['dbms'];
	$host = $request->data['host'];
	$databaseName = $request->data['database_name'];
	$username = $request->data['username'];
	$password = $request->data['password'];

	$databaseSource = new DatabaseSource();
	$databaseSource->setDbms($dbms)->setHost($host)->setDatabaseName($databaseName)->setUsername($username)->setPassword($password);

	$dsn = $databaseSource->getDsn();;
	try {
		$manageDatabase = new ManageDatabase($databaseSource);
	}
	catch (PDOException $pdoException) {
		$databaseSource->delete();
		echo '<h1>Couldn\'t connect to database</h1>';
		var_dump($pdoException);
		exit();
	}
	$databaseSource->save();
	echo $manageDatabase->configureTables();
});

Flight::route('GET /configure/@database', function ($database) {
	$databaseSource = DatabaseSourceQuery::create()->findOneByDatabaseName($database);
	if (!$databaseSource instanceof DatabaseSource) {
		echo 'Database ' . $database . ' not found!';
		exit();
	}
	try {
		$manageDatabase = new ManageDatabase($databaseSource);
	}
	catch (PDOException $pdoException) {
		$databaseSource->delete();
		echo '<h1>Couldn\'t connect to database</h1>';
		var_dump($pdoException);
		exit();
	}
	echo $manageDatabase->configureTables();
});

Flight::route('/dashboard/@name',function($name) {
	PhpReports::displayDashboard($name);
});

//JSON list of reports (used for typeahead search)
Flight::route('/report-list-json',function() {
	header("Content-Type: application/json");
	header("Cache-Control: max-age=3600");

	echo PhpReports::getReportListJSON();
});

//if no report format is specified, default to html
Flight::route('/report',function() {
	PhpReports::displayReport($_REQUEST['report'],'html');
});

//reports in a specific format (e.g. 'html','csv','json','xml', etc.)
Flight::route('/report/@format',function($format) {
	PhpReports::displayReport($_REQUEST['report'],$format);
});

Flight::route('/edit',function() {
	PhpReports::editReport($_REQUEST['report']);
});

Flight::route('/set-environment',function() {
    header("Content-Type: application/json");
	$_SESSION['environment'] = $_REQUEST['environment'];

    echo '{ "status": "OK" }';
});

//email report
Flight::route('/email',function() {
	PhpReports::emailReport();	
});

Flight::route('/@controller/@action', function ($controller, $action) {
	$controller = new $controller();
	echo $controller->$action();
	PhpReports::listDashboards();
});

Flight::set('flight.handle_errors', false);
Flight::set('flight.log_errors', true);

Flight::start();
