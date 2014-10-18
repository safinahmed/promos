<?php

include_once("db.php");

function crawl() {

	header("Content-type: application/json; charset=utf-8");
	
	$lineDelim = "#";
	$valueDelim = "*";
	$imageURL = "http://www.promoclick.pt/mob/img/";
	$i = 0;
	try {
	   error_reporting(E_ALL);
	
	   $contents = file_get_contents('http://www.promoclick.pt/mob/ajaxresponse.php?p=1&id=&src=&list=&search=0');
	   $contents = substr($contents, strpos($contents, "</div>")+6);
	   if(strlen($contents) < 1000) {
	       echo json_encode(array('count' => 0));
	       return;
	   }
	   $linetok = strtok($contents, $lineDelim);
	   
	   while ($linetok !== false) {
	       $linetok = trim($linetok);
	       list($id, $img, $cat, $name, $location, $dates, $old_price, $price, $discount) = explode($valueDelim, $linetok);
	       insertProduct($id,$img, $cat, $name, $location, $dates, $old_price, $price, $discount,$linetok);  
	       $linetok = strtok($lineDelim);
	       $i++;
	   }
	} catch (Exception $e) {
	   echo json_encode(array('count' => -1, 'msg' => utf8_encode($e->getMessage())));
	   return;
	}
	echo json_encode(array('count' => $i));
}

?>