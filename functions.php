<?php 

use \Controlic\Model\User;

function formatDate($date) {

	return date('d/m/Y H:i', strtotime($date));

}

function countDays($licregister, $licexpires) {

	$register = new DateTime($licregister);
	$expires = new DateTime($licexpires);
	$days = $register->diff($expires);

	if ($days->days > 0)
	{
		return $days->days;
	} else {
		return 'Expirou';
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
