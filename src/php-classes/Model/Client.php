<?php 

namespace Controlic\Model;

use \Controlic\DB\Sql;
use \Controlic\Model;

class Client extends Model {

	public function save()
	{
		$sql = new Sql();
		$results = $sql->select("CALL sp_clients_save(:desrazsoc, :desfantasia, :descnpj, :desnrphone, :desemail, :deslicexpires)", array(
			":desrazsoc"=>utf8_decode($this->getdesrazsoc()),
			":desfantasia"=>utf8_decode($this->getdesfantasia()),
			":descnpj"=>$this->getdescnpj(),
			":desnrphone"=>$this->getdesnrphone(),
			":desemail"=>$this->getdesemail(),
			":deslicexpires"=>$this->getdeslicexpires()
		));
		$this->setData($results[0]);
	}

	public function get($idclient)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_clients WHERE idclient = :idclient", array(
			":idclient"=>$idclient
		));

		$data = $results[0];

		$data['desfantasia'] = utf8_encode($data['desfantasia']);
		$data['desrazsoc'] = utf8_encode($data['desrazsoc']);

		$this->setData($data);

	}

	public function getLicense($idclient)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_registers WHERE idclient = :idclient", array(
			":idclient"=>$idclient
		));

		$data = $results[0];

		$this->setData($data);

	}

	public function update()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_clientsupdate_save(:idclient, :desrazsoc, :desfantasia, :descnpj, :desnrphone, :desemail)", array(
			":idclient"=>$this->getidclient(),
			":desrazsoc"=>utf8_decode($this->getdesrazsoc()),
			":desfantasia"=>utf8_decode($this->getdesfantasia()),
			":descnpj"=>$this->getdescnpj(),
			":desnrphone"=>$this->getdesnrphone(),
			":desemail"=>$this->getdesemail()
		));

		$this->setData($results[0]);		

	}

	public function updateLicense()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_licenseupdate_save(:idclient, :deslicexpires)", array(
			":idclient"=>$this->getidclient(),
			":deslicexpires"=>$this->getdeslicexpires()
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
			ORDER BY b.deslicexpires
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
			ORDER BY b.deslicexpires
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