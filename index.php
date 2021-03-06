<?php
// for build-in php server serve the requested resource as-is.
use PhpReports\Action\ActionHandler;
use PhpReports\PhpReports;
use PhpReports\Service\GoogleAnalyticsService;
use Propel\Runtime\Exception\ClassNotFoundException;

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
    $googleAnalyticsService = new GoogleAnalyticsService();

	Flight::route('/ga_authenticate',function() use($googleAnalyticsService) {
		$googleAnalyticsService->authorize();
	});
}

Flight::route('POST /*', function () {
	$actionHandler = new ActionHandler();
	$isValid = $actionHandler->isValidAction(Flight::request());
	if (!$isValid) {
		return true;
	}
	$actionHandler->executeAction();
});

Flight::route('/',function() {
	PhpReports::listReports();
});

Flight::route('/configure', function () {
	PhpReports::configure();
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

Flight::route('/@controller/@action(/@parameter)', function ($controller, $action, $parameter = null) {
	$controller = strtolower($controller);
	$controller = ucwords($controller, "\t\n\r\f\v-_");
	$controller = str_replace('-', '', $controller);

	$action = strtolower($action);
	$action = ucwords($action, "\t\n\r\f\v-_");
	$action = str_replace('-', '', $action);

	$fullyQualifiedNamespace = '\\PhpReports\\Controller\\' . $controller . 'Controller';

	if (!class_exists($fullyQualifiedNamespace)) {
		throw new ClassNotFoundException('Class ' . $fullyQualifiedNamespace . ' has not been found');
	}
	$controller = new $fullyQualifiedNamespace();

	if (!method_exists($controller, $action)) {
		throw new Exception('Method not found in controller: ' . $fullyQualifiedNamespace . ' for action: ' . $action);
	}
	echo $controller->$action($parameter);
});

Flight::set('flight.handle_errors', false);
Flight::set('flight.log_errors', true);

Flight::start();
