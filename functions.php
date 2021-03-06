<?php 

use \Controlic\Model\User;

function formatDate($date) {

	return date('d/m/Y H:i', strtotime($date));

}

function countDays($licexpires) {

	$current = new DateTime();
	$expires = new DateTime($licexpires);
	$interval = $current->diff($expires);

	if ($current > $expires) {
		return 'Expirou!';
	}
	else if ($interval->days < 8) {	
		$notif = $interval->days . ' (*)';
		return $notif;
	}
	else {
		return $interval->days;
	}

}

function licenseSql($licexpires) {

	return "UPDATE SIS_PARAMETROS SET LIC_LIMITE = "."'".date('d.m.Y H.i', strtotime($licexpires))."'".", LIC_CONTROLE = NULL;";

}

function checkLogin($inadmin = true) {

	return User::checkLogin($inadmin);

}

function getUserName() {

	$user = User::getFromSession();

	return $user->getdesperson();

}

function getIdUser() {

	$user = User::getFromSession();

	return $user->getiduser();

}

?>
