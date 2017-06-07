<?php
 define("mysqlServer","localhost");
 define("mysqlDB","leaflet");
 define("mysqlUser","root");
 define("mysqlPass","");

 class connectToDB
 {
	public static function addCompany( $company, $details, $latitude, $longitude, $telephone, $keywords)
	{
		  $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
		  $statement = $db_connection->prepare("INSERT INTO companies( company, details, latitude, longitude, telephone, keywords) VALUES( ?, ?, ?, ?, ?, ?)");
		  $statement->bind_param('ssssss', $company, $details, $latitude, $longitude, $telephone, $keywords);
		  $statement->execute();
		  $statement->close();
		  $db_connection->close();
	}
	public static function getCompaniesList()
	{
		  $arr = array();
		  $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
		  $statement = $db_connection->prepare( "SELECT id, company, details, latitude, longitude, telephone, keywords from companies order by company ASC");
		  $statement->bind_result( $id, $company, $details, $latitude, $longitude, $telephone, $keywords);
		  $statement->execute();
		  while ($statement->fetch()) {
			$arr[] = [ "id" => $id, "company" => $company, "details" => $details, "latitude" => $latitude, "longitude" => $longitude, "telephone" => $telephone, "keywords" => $keywords];
		  }
		  $statement->close();
		  $db_connection->close();
		  return $arr;
	}
	public static function updateCompany( $id, $details, $latitude, $longitude, $telephone, $keywords)
	{
		  $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
		  $statement = $db_connection->prepare("UPDATE companies SET details = ?,latitude = ?,longitude = ?,telephone = ?,keywords = ? where id = ?");
		  $statement->bind_param( 'sssssi', $details, $latitude, $longitude, $telephone, $keywords, $id);
		  $statement->execute();
		  $statement->close();
		  $db_connection->close();
	}
	public static function deleteCompany($id)
	{
		 $db_connection = new mysqli(mysqlServer, mysqlUser, mysqlPass, mysqlDB);
		 $statement = $db_connection->prepare("Delete from companies where id = ?");
		 $statement->bind_param('i', $id);
		 $statement->execute();
		 $statement->close();
		 $db_connection->close();
	}
	public static function addStreet( $street, $geo, $keywords)
	{
		 $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
		 $statement = $db_connection->prepare("INSERT INTO streets( name, geolocations, keywords) VALUES( ?, ?, ?)");
		 $statement->bind_param( 'sss', $street, $geo, $keywords);
		 $statement->execute();
		 $statement->close();
		 $db_connection->close();
	}
	public static function getStreetsList()
	{
		$arr = array();
		$db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
		$statement = $db_connection->prepare( "SELECT id, name, geolocations, keywords from streets order by name ASC");
		$statement->bind_result( $id, $name, $geolocations, $keywords);
		$statement->execute();
		while ($statement->fetch()) {
		$arr[] = [ "id" => $id, "name" => $name, "geolocations" => $geolocations, "keywords" => $keywords];
		}
		$statement->close();
		$db_connection->close();
		return $arr;
	}
	public static function updateStreet( $id, $geo, $keywords)
	{
		  $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
		  $statement = $db_connection->prepare( "UPDATE streets SET geolocations = ?, keywords = ? where id = ?");
		  $statement->bind_param( 'ssi', $geo, $keywords, $id);
		  $statement->execute();
		  $statement->close();
		  $db_connection->close();
	}
	public static function deleteStreet($id)
	{
		 $db_connection = new mysqli(mysqlServer, mysqlUser, mysqlPass, mysqlDB);
		 $statement = $db_connection->prepare("Delete from streets where id = ?");
		 $statement->bind_param('i', $id);
		 $statement->execute();
		 $statement->close();
		 $db_connection->close();
	}
	public static function addArea( $area, $geo, $keywords)
	{
		  $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
		  $statement = $db_connection->prepare( "INSERT INTO areas( name, geolocations, keywords ) VALUES(?,?,?)");
		  $statement->bind_param( 'sss', $area, $geo,$keywords);
		  $statement->execute();
		  $statement->close();
		  $db_connection->close();
	}
	public static function getAreasList()
	{
		  $arr = array();
		  $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
		  $statement = $db_connection->prepare( "SELECT id, name, geolocations, keywords from areas order by name ASC");
		  $statement->bind_result( $id, $name, $geolocations, $keywords);
		  $statement->execute();
		  while ($statement->fetch()) {
			$arr[] = [ "id" => $id, "name" => $name, "geolocations" => $geolocations, "keywords" => $keywords];
		  }
		  $statement->close();
		  $db_connection->close();
		  return $arr;
	}
	public static function updateArea( $id, $geo, $keywords)
	{
		  $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
		  $statement = $db_connection->prepare("UPDATE areas SET geolocations = ?, keywords = ? where id = ?");
		  $statement->bind_param( 'ssi', $geo, $keywords, $id);
		  $statement->execute();
		  $statement->close();
		  $db_connection->close();
	}
	public static function deleteArea($id)
	{
		 $db_connection = new mysqli(mysqlServer, mysqlUser, mysqlPass, mysqlDB);
		 $statement = $db_connection->prepare("Delete from areas where id = ?");
		 $statement->bind_param('i', $id);
		 $statement->execute();
		 $statement->close();
		 $db_connection->close();
	}
	public static function getSearchResults($keyword)
	{
		  $arr = array();
		  $jsonData = '{"results":[';
		  $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
		  $db_connection->query( "SET NAMES 'UTF8'" );
		  $statement = $db_connection->prepare("SELECT company, latitude, longitude FROM `companies` where keywords REGEXP ? or company REGEXP ?");
		  $statement->bind_param( 'ss', $keyword, $keyword);
		  $statement->execute();
		  $statement->bind_result( $name, $lat, $lng);
		  while ($statement->fetch()) {
			$arr[] = '{"name":"' . $name. '","latitude":"' . $lat. '","longitude":"' . $lng. '"}';
		  }
		  $statement->close();

		  $statement = $db_connection->prepare( "SELECT name, geolocations FROM `streets` where keywords REGEXP ? or name REGEXP ?");
		  $statement->bind_param( 'ss', $keyword, $keyword);
		  $statement->execute();
		  $statement->bind_result( $name, $geolocations);
		  while ($statement->fetch()) {
			$temp = explode(",",$geolocations);
			$arr[] = '{"name":"' . $name. '","latitude":"' . $temp[1]. '","longitude":"' . $temp[0]. '"}';
		  }
		  $statement->close();

		  $statement = $db_connection->prepare( "SELECT name, geolocations FROM `areas` where keywords REGEXP ? or name REGEXP ?");
		  $statement->bind_param( 'ss', $keyword, $keyword);
		  $statement->execute();
		  $statement->bind_result( $name, $geolocations);
		  while ($statement->fetch()) {
			$temp = explode(",",$geolocations);
			$arr[] = '{"name": "' . $name. '", "latitude": "' . $temp[1]. '","longitude":"' . $temp[0]. '"}';
		  }
		  $statement->close();

		  $db_connection->close();
		  $jsonData .= implode(",", $arr);
		  $jsonData .= ']}';
		  return $jsonData;
	}
 }
?>