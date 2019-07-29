<?php 

use \Controlic\PageAdmin;
use \Controlic\Model\Client;
use \Controlic\Model\User;

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

?>
