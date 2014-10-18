<?php 

include_once("dbProps.php");

$categoryIds = array();
$storeIds = array();

function insertProduct($id, $img, $cat, $name, $location, $dates, $old_price, $price, $discount,$line)
{
   global $DBServer;
   global $DBUser;
   global $DBPass;
   global $DBName;
   global $DBPort;
   
   $conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName,$DBPort);
   
   if (!$conn->set_charset("utf8"))
   	throw new Exception("Could set charset ". $conn->error);
   
   $sql="SELECT * FROM products WHERE ID = $id";

   $rs=$conn->query($sql);

   if(!$rs) {
       throw new Exception("Could not select - $sql - $conn->error");
   } else {
       if($conn->affected_rows > 0)
           return;
   }
   
   mysqli_free_result($rs);
      
   list($date_start,$date_end) = explode(" - ", $dates);
   $start_date = createDate($date_start);
   $end_date = createDate($date_end);
   
   $old_price = trim($old_price);
   if(!empty($old_price)) {
       $old_prices = explode(" ", $old_price);
       $old_price = $old_prices[0];
       $old_price = parseNumber($old_price);
       if(empty($old_price))
       	$old_price = 0;
   } else {
       $old_price = 0;
   }
   
   if($discount != null) {
       $discounts = explode(" ", $discount);
       $discount = $discounts[1];
       $discount = parseNumber($discount);
   } else {
       $discount = 0;
   }
   
   //DESCONTOS GERAIS
   if($price == null)
       $price = 0;
   else 
   		$price = parseNumber($price);
   
   $name = $conn->real_escape_string($name);
   
   
   $categoryId = getCategoryId($cat);
   $storeId = getStoreId($location);
           
   // check connection
   if ($conn->connect_error) {
     throw new Exception('Database connection failed: '  . $conn->connect_error);
   } else {
   	   $img = storeImage($img);
       $insertSQL = "INSERT INTO `products`(`id`,`image_url`, `category_id`, `product_name`, `store_id`, `start_date`, `end_date`,`old_price`, `new_price`,`discount`) VALUES ($id,'$img', $categoryId, '$name', $storeId, STR_TO_DATE('$start_date', '%d.%m.%Y'), STR_TO_DATE('$end_date', '%d.%m.%Y'), $old_price, $price, $discount)";
       if($conn->query($insertSQL) === false) {
           throw new Exception("Could not insert - $insertSQL - $conn->error");
       }

   }

   $conn->close();
}

function storeImage($img) {
	$imgDir = "images/";
	$imgLoc = "http://promoclick.pt/mob/img/";
	try {
		if(strcmp($img, "logosplash.png") == 0)
			return "NO_IMAGE";
		else {
			$imgName = uniqid() . ".jpg";
			$localImg = $imgDir . $imgName;
			$remoteImg = str_replace(" ", "%20",$imgLoc . $img);			
			$curl_handle = curl_init();
			curl_setopt($curl_handle, CURLOPT_URL, $remoteImg);
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
			$fileData = curl_exec($curl_handle);
			file_put_contents($localImg,$fileData);
			curl_close($curl_handle);
			return $imgName;
		}
	} catch (Exception $e) {
    	echo "Error getting image " . $e->getMessage();
	}
}

function getCategoryId($category_name)
{
   global $DBServer;
   global $DBUser;
   global $DBPass;
   global $DBName;
   global $DBPort;
   global $categoryIds;
   
   if(array_key_exists($category_name, $categoryIds))
   		return $categoryIds[$category_name];
   
   $conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName,$DBPort);
   
   // check connection
   if ($conn->connect_error)
   	throw new Exception('Database connection failed: '  . $conn->connect_error);
   
   
   if (!$conn->set_charset("utf8"))
   	throw new Exception("Could set charset ". $conn->error);
   
   $category_name = $conn->real_escape_string($category_name);

   $sql="SELECT * FROM product_categories WHERE NAME = '$category_name'";

   $rs=$conn->query($sql);

   if(!$rs) {
       throw new Exception("Could not select - $sql - $conn->error");
   } else {
       $arr = $rs->fetch_array();
   }

   if($arr[0] != null) {
   		$categoriesId[$category_name] = $arr[0];
       return $arr[0];
   }

   $insertSQL = "INSERT INTO `product_categories`(`name`) VALUES ('$category_name')";
   if($conn->query($insertSQL) === false) {
       throw new Exception("Could not insert - $insertSQL - $conn->error");
   } else {
   	   $categoriesId[$category_name] = mysqli_insert_id($conn);
       return $categoriesId[$category_name];
   }
   
   mysqli_free_result($rs);
   $conn->close();
}

function getStoreId($store_name)
{
   global $DBServer;
   global $DBUser;
   global $DBPass;
   global $DBName;
   global $DBPort;
   global $storeIds;
   
   if(array_key_exists($store_name, $storeIds))
   		return $storeIds[$store_name];
   
   $conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName,$DBPort);
   
   
   if ($conn->connect_error) 
   	throw new Exception('Database connection failed: '  . $conn->connect_error);

   
   if (!$conn->set_charset("utf8"))
   	throw new Exception("Could set charset ". $conn->error);
   
   $store_name = $conn->real_escape_string($store_name);

   // check connection

   $sql="SELECT * FROM stores WHERE NAME = '$store_name'";

   $rs=$conn->query($sql);

   if(!$rs) {
       throw new Exception("Could not select - $sql - $conn->error");
   } else {
       $arr = $rs->fetch_array();
   }

   if($arr[0] != null) {
   		$storeIds[$store_name] = $arr[0];
       return $arr[0];
   }

   $insertSQL = "INSERT INTO `stores`(`name`) VALUES ('$store_name')";
   if($conn->query($insertSQL) === false) {
       throw new Exception("Could not insert - $insertSQL - $conn->error");
   } else {
   		$storeIds[$store_name] = mysqli_insert_id($conn);
       return $storeIds[$store_name];
   }
   
   mysqli_free_result($rs);
   $conn->close();
}

function parseNumber($num) {
	$num = str_replace(",", ".", $num);
	$num = preg_replace("/[^0-9\.]/","",$num);
	return $num;
}

function createDate($aDate) 
{
   $returnDate = $aDate . "." . date("Y");  
   return $returnDate; 
}

?>