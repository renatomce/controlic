<?php 

use \Controlic\PageAdmin;
use \Controlic\Model\User;
use \Controlic\Model\Client;

$app->get('/admin/clients', function() {

	User::verifyLogin();

	$search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	if ($search != '') {

		$pagination = Client::getPageSearch($search, $page);

	} else {

		$pagination = Client::getPage($page);

	}

	$pages = [];

	for ($x = 0; $x < $pagination['pages']; $x++)
	{

		array_push($pages, [
			'href'=>'/admin/clients?'.http_build_query([
				'page'=>$x+1,
				'search'=>$search
			]),
			'text'=>$x+1
		]);

	}

	$page = new PageAdmin();

	$page->setTpl("clients", array(
		"clients"=>$pagination['data'],
		"search"=>$search,
		"pages"=>$pages
	));


});

$app->get("/admin/clients/create", function() {

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("clients-create");

});

$app->post("/admin/clients/create", function() {

	User::verifyLogin();

	$client = new Client();

	$client->setData($_POST);

	$client->save();

	header("Location: /admin/clients");
	exit;

});

$app->get("/admin/clients/:idclient", function($idclient) {

	User::verifyLogin();

	$client = new Client();

	$client->get((int)$idclient);

	$page = new PageAdmin();

	$page->setTpl("clients-update", array(
		"client"=>$client->getValues()
	));

});

$app->post("/admin/clients/:idclient", function($idclient) {

	User::verifyLogin();

	$client = new Client();

	$client->get((int)$idclient);

	$client->setData($_POST);

	$client->update();	

	header("Location: /admin/clients");
	exit;

});

$app->get("/admin/clients/:idclient/delete", function($idclient) {

	User::verifyLogin();	

	$client = new Client();

	$client->get((int)$idclient);

	$client->delete();

	header("Location: /admin/clients");
	exit;

});

$app->get("/admin/clients/:idclient/register", function($idclient) {

	User::verifyLogin();

	$client = new Client();

	$client->get((int)$idclient);

	$page = new PageAdmin();

	$page->setTpl("license-register", array(
		"client"=>$client->getValues()
	));

});

$app->post("/admin/clients/:idclient/register", function($idclient) {

	User::verifyLogin();

	$client = new Client();

	$client->get((int)$idclient);

	$client->setData($_POST);

	$client->updateLicense();	

	header("Location: /admin/clients/$idclient/success");
	exit;

});

$app->get("/admin/clients/:idclient/success", function($idclient) {

	User::verifyLogin();

	$client = new Client();

	$client->get((int)$idclient);

	$client->getLicense((int)$idclient);

	$page = new PageAdmin();

	$page->setTpl("license-success", array(
		"client"=>$client->getValues()
	));


});

?>
