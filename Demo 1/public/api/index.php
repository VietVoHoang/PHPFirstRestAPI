<?php

	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	
	// Load all dependencies
	require __DIR__ . '/../../Demo/config.php';
	require __DIR__ . LINK_AUTOLOAD;
	
	
	// Config setting
	$config['displayErrorDetails'] = true;
	$config['addContentLengthHeader'] = true;
	
	$config['db']['type'] = "sqlite";
	$config['db']['file'] = __DIR__ . LINK_DATABASE;
	
	// Create Slim app with config
	$app = new \Slim\App(["settings" => $config]);
	
	// Get DIC (Dependencies Injection Container)
	$container = $app->getContainer();

	$container['logger'] = function($c) {
		$logger = new \Monolog\Logger('my_logger');
		$file_handler = new \Monolog\Handler\StreamHandler(LINK_LOGS);
		$logger->pushHandler($file_handler);
		return $logger;
	};
	//Logging ex: $this->logger->info(print_r($this->db, true));

	// Init Medoo
	use Medoo\Medoo;

	$container['db'] = function ($c){
		$db = $c['settings']['db'];
		$md = new Medoo([
			'database_type' => $db['type'],
			'database_file' => $db['file']
		]);

		return $md;
	};

	// // Website you wish to allow to connect
	// header("Access-Control-Allow-Origin: *");
	
	// // Request methods you wish to allow
	// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");

	// // Request JSON 
	// header("Content-Type: application/json; charset=UTF-8");

	// header("Access-Control-Max-Age: 3600");

	// // Request headers you wish to allow
	// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, x-access-token");	
	
	$app->add(function ($req, $res, $next) {
		$response = $next($req, $res);
		return $response
				->withHeader('Access-Control-Allow-Origin', '*')
				->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, x-access-token')
				->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
				->withHeader('Access-Control-Max-Age', 3600);
	});

	// $corsOptions = array(
	// 	"origin" => "*",
	// 	"exposeHeaders" => array("Content-Type", "X-Requested-With", "X-authentication", "X-client", "x-access-token"),
	// 	"allowHeaders" => array("Content-Type", "X-Requested-With", "X-authentication", "X-client", "x-access-token"),
	// 	"allowMethods" => array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'),
	// 	"maxAge" => 3600,
	// 	"allowCredentials" => True
	// );
	// $cors = new \CorsSlim\CorsSlim($corsOptions);
	
	// $app->add($cors);
	
	// -------------------------------------------------------------------------
	// Welcome Route
	// -------------------------------------------------------------------------
	$app->get('/', function(Request $req, Response $res){	
		return $res->getBody()->write("Welcome to NashTrophy API!");
	});

	
	// -------------------------------------------------------------------------
	// Trophy Routes
	// -------------------------------------------------------------------------
	$app->get('/product', function(Request $req, Response $res){
		$productController = new ProductController ($this->db);
		$result = $productController->getAll();		
		return $res->withJson($result['data'], $result['status']);
	});

	$app->post('/product/findById', function(Request $req, Response $res){
		$body = $req->getParsedBody();
		$productController = new ProductController ($this->db);
		$result = $productController->getOne($body);			
		return $res->withJson($result['data'], $result['status']);
	});

	$app->post('/product/create', function(Request $req, Response $res){
		$body = $req->getParsedBody();
		$productController = new ProductController ($this->db);
		$result = $productController->create($body);
		return $res->withJson($result['data'], $result['status']);
	});

	$app->post('/product/update', function(Request $req, Response $res){
		$body = $req->getParsedBody();
		$productController = new ProductController ($this->db);
		$result = $productController->update($body);			
		return $res->withJson($result['data'], $result['status']);
	});

	$app->post('/product/delete', function(Request $req, Response $res){
		$body = $req->getParsedBody();
		$productController = new ProductController ($this->db);
		$result = $productController->delete($body);			
		return $res->withJson($result['data'], $result['status']);
	});
	
	$app->run();

?>