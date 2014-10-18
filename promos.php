<?php

include_once("dbProps.php");

function test(){
	// Display custom 404 page
	echo 'Maniac world!';
}

//To be called via Ajax by DataTables, not working currently
function allPromosWeb() {
	header("Content-type: application/json; charset=UTF-8");

	global $DBServer;
	global $DBUser;
	global $DBPass;
	global $DBName;
	global $DBPort;
	global $storeIds;
		

	try {

		$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName,$DBPort);

		if ($conn->connect_error)
			throw new Exception("Could not connect to DB " . $conn.connect_error);

		else if (!$conn->set_charset("utf8"))
			throw new Exception("Could set charset ". $conn->error);

		$sql="SELECT * FROM products ORDER BY product_name";

		$rs=$conn->query($sql);

		if(!$rs) {
			throw new Exception("Could not select - $sql - $conn->error");
		} else {
			$prods = $rs->fetch_all(MYSQLI_NUM);
		}

		mysqli_free_result($rs);
		$conn->close();


		echo json_encode(array('data' => $prods));

	} catch (Exception $e) {
		echo json_encode(array('id' => -1, 'error' => $e->getMessage()));
	}
}


function allPromosForWeb() {

	global $DBServer;
	global $DBUser;
	global $DBPass;
	global $DBName;
	global $DBPort;
		
	try {

		$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName,$DBPort);

		if ($conn->connect_error)
			throw new Exception("Could not connect to DB " . $conn.connect_error);

		else if (!$conn->set_charset("utf8"))
			throw new Exception("Could set charset ". $conn->error);

		$sql="SELECT p.id, p.image_url, p.product_name, s.name as 'store_name', c.name as 'category_name',p.start_date, p.end_date, p.old_price, p.new_price, p.discount
			  FROM products p, product_categories c, stores s
			  WHERE p.category_id = c.id
			  AND p.store_id = s.id
			  ORDER BY product_name";

		$rs=$conn->query($sql);

		if(!$rs) {
			return null;
		} else {
			$prods = $rs->fetch_all(MYSQLI_ASSOC);
		}

		mysqli_free_result($rs);
		$conn->close();
		
		return $prods;

	} catch (Exception $e) {
		return null;
	}
}


function allPromos() {	
	header("Content-type: application/json; charset=UTF-8");
	
	global $DBServer;
	global $DBUser;
	global $DBPass;
	global $DBName;
	global $DBPort;
	global $storeIds;
		 

	try {

		$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName,$DBPort);

		if ($conn->connect_error) 
			throw new Exception("Could not connect to DB " . $conn.connect_error);
		
		else if (!$conn->set_charset("utf8"))
			throw new Exception("Could set charset ". $conn->error);

		$sql="SELECT * FROM products ORDER BY product_name";
		
		$rs=$conn->query($sql);

		if(!$rs) {
			throw new Exception("Could not select - $sql - $conn->error");
		} else {
			$prods = $rs->fetch_all(MYSQLI_ASSOC);
		}
		
		mysqli_free_result($rs);
		$conn->close();
		
		
		 echo json_encode(array('id' => 0, 'results' => $prods ));

    } catch (Exception $e) {
    	echo json_encode(array('id' => -1, 'error' => $e->getMessage()));
	}
}


function allCategories() {
	header("Content-type: application/json; charset=UTF-8");

	global $DBServer;
	global $DBUser;
	global $DBPass;
	global $DBName;
	global $DBPort;
	global $storeIds;
		

	try {

		$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName,$DBPort);

		if ($conn->connect_error)
			throw new Exception("Could not connect to DB " . $conn.connect_error);

		else if (!$conn->set_charset("utf8"))
			throw new Exception("Could set charset ". $conn->error);


		$sql="SELECT * FROM product_categories";

		$rs=$conn->query($sql);

		if(!$rs) {
			throw new Exception("Could not select - $sql - $conn->error");
		} else {
			$categories = $rs->fetch_all(MYSQLI_ASSOC);
		}
		mysqli_free_result($rs);
		$conn->close();
		
		echo json_encode(array('id' => 0, 'results' =>$categories));

	} catch (Exception $e) {
		echo json_encode(array('id' => -1, 'error' => $e->getMessage()));
	}
}


function allStores() {
	header("Content-type: application/json; charset=UTF-8");

	global $DBServer;
	global $DBUser;
	global $DBPass;
	global $DBName;
	global $DBPort;
	global $storeIds;
		

	try {

		$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName,$DBPort);

		if ($conn->connect_error)
			throw new Exception("Could not connect to DB " . $conn.connect_error);

		else if (!$conn->set_charset("utf8"))
			throw new Exception("Could set charset ". $conn->error);

		$sql="SELECT * FROM stores";

		$rs=$conn->query($sql);

		if(!$rs) {
			throw new Exception("Could not select - $sql - $conn->error");
		} else {
			$stores = $rs->fetch_all(MYSQLI_ASSOC);
		}
		mysqli_free_result($rs);
		$conn->close();

		echo json_encode(array('id' => 0, 'results' => $stores));

	} catch (Exception $e) {
		echo json_encode(array('id' => -1, 'error' => $e->getMessage()));
	}
}


function format($number) {
	return str_ireplace(".00", "",$number);
}
?>