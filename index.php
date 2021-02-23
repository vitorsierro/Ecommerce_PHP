<?php 
session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;
use Hcode\Page;
use Hcode\PageAdmin;
use Hcode\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
   
	$page = new Page();

	$page->setTpl('index');

});

$app->get('/admin', function() {

	User::verifylogin();
   
	$page = new PageAdmin();

	$page->setTpl('index');



});

$app->get('/admin/login', function(){

$page = new PageAdmin([
	"header"=>false,
	"footer"=>false
]);

$page->setTpl("login");

});
$app->post('/admin/login', function(){

	User::login($_POST["login"], $_POST["password"]);

	header("location: /admin");

	exit;

});

$app->get('/admin/logout', function(){
	User::logout();

	header("Location: /admin/login");
	exit;
});

$app->get('/admin/forgot', function() {
 	
 	$page = new PageAdmin([
 		"header"=>false,
 		"footer"=>false

 	]);

 	$page->setTpl("forgot");
});
$app->post("/admin/forgot", function(){
	
	$user = User::getForgot($_POST["email"]);

	header("Location: /admin/forgot/sent");
	exit;

});
$app->get("/admin/forgot/sent", function(){
	$page = new PageAdmin([
 		"header"=>false,
 		"footer"=>false

 	]);

 	$page->setTpl("forgot-sent");

});


$app->run();

 ?>