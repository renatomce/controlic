<?php 

use \Controlic\Model\User;

function formatDate($date) {

	return date('d/m/Y', strtotime($date));

}

function checkLogin($inadmin = true) {

	return User::checkLogin($inadmin);

}

function getUserName() {

	$user = User::getFromSession();

	return $user->getdesperson();

}

?>
