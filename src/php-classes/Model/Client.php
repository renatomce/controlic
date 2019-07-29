<?php 

namespace Controlic\Model;

use \Controlic\DB\Sql;
use \Controlic\Model;

class Client extends Model {

	public static function listAll()
	{

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_clients a INNER JOIN tb_registers b USING(idclient) WHERE a.idclient = b.idclient");

	}

	public function save()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_clients_save(:desrazsoc, :desfantasia, :descnpj, :desnrphone, :desemail)", array(
			":desrazsoc"=>utf8_decode($this->getdesrazsoc()),
			":desfantasia"=>utf8_decode($this->getdesfantasia()),
			":descnpj"=>$this->getdescnpj(),
			":desnrphone"=>$this->getnrphone(),
			":desemail"=>$this->getdesemail()
		));

		$this->setData($results[0]);

	}

	public function get($idclient)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_clients a INNER JOIN tb_registers b USING(idclient) WHERE a.idclient = :idclient", array(
			":idclient"=>$idclient
		));

		$data = $results[0];

		$data['desfantasia'] = utf8_encode($data['desfantasia']);

		$this->setData($data);

	}

	public function update()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_usersupdate_save(:iduser, :desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
			":iduser"=>$this->getiduser(),
			":desperson"=>utf8_decode($this->getdesperson()),
			":deslogin"=>$this->getdeslogin(),
			":despassword"=>User::getPasswordHash($this->getdespassword()),
			":desemail"=>$this->getdesemail(),
			":nrphone"=>$this->getnrphone(),
			":inadmin"=>$this->getinadmin()
		));

		$this->setData($results[0]);		

	}

	public function delete()
	{

		$sql = new Sql();

		$sql->query("CALL sp_clients_delete(:idclient)", array(
			":idclient"=>$this->getidclient()
		));

	}

	public static function getPage($page = 1, $itemsPerPage = 10)
	{

		$start = ($page - 1) * $itemsPerPage;

		$sql = new Sql();

		$results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS *
			FROM tb_clients a
			INNER JOIN tb_registers b USING(idclient) WHERE a.idclient = b.idclient
			LIMIT $start, $itemsPerPage;
		");

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

		return [
			'data'=>$results,
			'total'=>(int)$resultTotal[0]["nrtotal"],
			'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
		];

	}

	public static function getPageSearch($search, $page = 1, $itemsPerPage = 10)
	{

		$start = ($page - 1) * $itemsPerPage;

		$sql = new Sql();

		$results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS *
			FROM tb_clients a
			INNER JOIN tb_registers b USING(idclient)
			WHERE a.desrazsoc LIKE :search OR a.desfantasia LIKE :search OR a.desemail = :search
			ORDER BY a.desfantasia
			LIMIT $start, $itemsPerPage;
		", [
			':search'=>'%'.$search.'%'
		]);

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

		return [
			'data'=>$results,
			'total'=>(int)$resultTotal[0]["nrtotal"],
			'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
		];

	} 

}

 ?>