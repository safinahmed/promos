<?php
include_once("promos.php");
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
<meta charset="UTF-8">
<title>Hiper Promos</title>

<style>

#search-form {
	margin: 0 auto; 
	
	background: #e1e1e1; /* Fallback color for non-css3 browsers */
	width: 600px;

	/* Gradients */
	background: -webkit-gradient( linear,left top, left bottom, color-stop(0, rgb(243,243,243)), color-stop(1, rgb(225,225,225)));
	background: -moz-linear-gradient( center top, rgb(243,243,243) 0%, rgb(225,225,225) 100%);

	/* Rounded Corners */
	border-radius: 17px;
	-webkit-border-radius: 17px;
	-moz-border-radius: 17px;

	/* Shadows */
	box-shadow: 1px 1px 2px rgba(0,0,0,.3), 0 0 2px rgba(0,0,0,.3);
	-webkit-box-shadow: 1px 1px 2px rgba(0,0,0,.3), 0 0 2px rgba(0,0,0,.3);
	-moz-box-shadow: 1px 1px 2px rgba(0,0,0,.3), 0 0 2px rgba(0,0,0,.3);
}

/*** TEXT BOX ***/
input[type="text"]{
	background: #fafafa; /* Fallback color for non-css3 browsers */

	/* Gradients */
	background: -webkit-gradient( linear, left bottom, left top, color-stop(0, rgb(250,250,250)), color-stop(1, rgb(230,230,230)));
	background: -moz-linear-gradient( center top, rgb(250,250,250) 0%, rgb(230,230,230) 100%);

	border: 0;
	border-bottom: 1px solid #fff;
	border-right: 1px solid rgba(255,255,255,.8);
	font-size: 16px;
	margin: 8px;
	padding: 5px;
	padding-left: 10px;
	width: 450px;
	height: 30px;

	/* Rounded Corners */
	border-radius: 17px;
	-webkit-border-radius: 17px;
	-moz-border-radius: 17px;

	/* Shadows */
	box-shadow: -1px -1px 2px rgba(0,0,0,.3), 0 0 1px rgba(0,0,0,.2);
	-webkit-box-shadow: -1px -1px 2px rgba(0,0,0,.3), 0 0 1px rgba(0,0,0,.2);
	-moz-box-shadow: -1px -1px 2px rgba(0,0,0,.3), 0 0 1px rgba(0,0,0,.2);
}

/*** USER IS FOCUSED ON TEXT BOX ***/
input[type="text"]:focus{
	outline: none;
	background: #fff; /* Fallback color for non-css3 browsers */

	/* Gradients */
	background: -webkit-gradient( linear, left bottom, left top, color-stop(0, rgb(255,255,255)), color-stop(1, rgb(235,235,235)));
	background: -moz-linear-gradient( center top, rgb(255,255,255) 0%, rgb(235,235,235) 100%);
}

/*** SEARCH BUTTON ***/
input[type="submit"]{
	background: #44921f;/* Fallback color for non-css3 browsers */

	/* Gradients */
	background: -webkit-gradient( linear, left top, left bottom, color-stop(0, rgb(79,188,32)), color-stop(0.15, rgb(73,157,34)), color-stop(0.88, rgb(62,135,28)), color-stop(1, rgb(49,114,21)));
	background: -moz-linear-gradient( center top, rgb(79,188,32) 0%, rgb(73,157,34) 15%, rgb(62,135,28) 88%, rgb(49,114,21) 100%);

	border: 0;
	color: #eee;
	cursor: pointer;
	float: right;
	font: 16px Arial, Helvetica, sans-serif;
	font-weight: bold;
	height: 42px;
	margin: 8px 8px 0;
	text-shadow: 0 -1px 0 rgba(0,0,0,.3);
	width: 100px;
	outline: none;

	/* Rounded Corners */
	border-radius: 30px;
	-webkit-border-radius: 30px;
	-moz-border-radius: 30px;

	/* Shadows */
	box-shadow: -1px -1px 1px rgba(255,255,255,.5), 1px 1px 0 rgba(0,0,0,.4);
	-moz-box-shadow: -1px -1px 1px rgba(255,255,255,.5), 1px 1px 0 rgba(0,0,0,.2);
	-webkit-box-shadow: -1px -1px 1px rgba(255,255,255,.5), 1px 1px 0 rgba(0,0,0,.4);
}
/*** SEARCH BUTTON HOVER ***/
input[type="submit"]:hover {
	background: #4ea923; /* Fallback color for non-css3 browsers */

	/* Gradients */
	background: -webkit-gradient( linear, left top, left bottom, color-stop(0, rgb(89,222,27)), color-stop(0.15, rgb(83,179,38)), color-stop(0.8, rgb(66,143,27)), color-stop(1, rgb(54,120,22)));
	background: -moz-linear-gradient( center top, rgb(89,222,27) 0%, rgb(83,179,38) 15%, rgb(66,143,27) 80%, rgb(54,120,22) 100%);
}
input[type="submit"]:active {
	background: #4ea923; /* Fallback color for non-css3 browsers */

	/* Gradients */
	background: -webkit-gradient( linear, left bottom, left top, color-stop(0, rgb(89,222,27)), color-stop(0.15, rgb(83,179,38)), color-stop(0.8, rgb(66,143,27)), color-stop(1, rgb(54,120,22)));
	background: -moz-linear-gradient( center bottom, rgb(89,222,27) 0%, rgb(83,179,38) 15%, rgb(66,143,27) 80%, rgb(54,120,22) 100%);
}

</style>
</head>
<body>

<br/><br/><br/><br/>
<form id="search-form">
  <input type="text" id="search-txt" placeholder="Produto, Categoria ou Loja (batatas, bebidas, continente...)"/>
  <input type="submit" value="Procurar" id="search-btn" />
</form>
<br/><br/><br/><br/>

<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
            	<th>Favorito</th>
                <th>Imagem</th>
                <th>Produto</th>
                <th>Novo Pre&ccedil;o</th>
                <th>Desconto</th>
                <th>Pre&ccedil;o Antigo</th>
                <th>Categoria</th>
                <th>Loja</th>
                <th>Inicio</th>
                <th>Fim</th>
            </tr>
        </thead>

        <tbody>
 	<?php 
 		$promos = allPromosForWeb(false);
 		foreach ($promos as $promo) {		
 	?>
 	        <tr>
 	        	<th>
 	        	<input type="checkbox" name="favorito" value='<?php echo $promo["id"]; ?>'/>
 	        	</th>
                <th>
                <?php
					$imgSrc = $promo["image_url"];
					if($imgSrc == "NO_IMAGE")
						$imgSrc = "http://seniorcapital.eu/wp-content/themes/patus/images/no-image-half-landscape.png";
					else 
						$imgSrc = "./images/".$imgSrc; ?>
					<img src="<?php echo $imgSrc?>" style="width: 120px;height: 120px;"/>
                </th>
                <th><?php echo $promo["product_name"]; ?></th>
                <th><?php echo format($promo["new_price"]); ?>&euro;</th>
                <th><?php echo format($promo["discount"]); ?>%</th>
                <th><?php echo format($promo["old_price"]); ?>&euro;</th>
                <th><?php echo $promo["category_name"]; ?></th>
                <th><?php echo $promo["store_name"]; ?></th>
                <th><?php echo $promo["start_date"]; ?></th>
                <th><?php echo $promo["end_date"]; ?></th>
            </tr>
	<?php } ?>
   
  	    </tbody>
    </table>
</body>
<script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="//cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">

var data;
$(document).ready(function() {

	

    data = $('#example').DataTable({
    	"dom": '<"top"l>rt<"bottom"ip><"clear">',
        "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0 ] } ],
    	"order": [[1, "asc"]],
    	 "lengthMenu": [[50, 100, 200], [50, 100, 200]],
    	"oLanguage":{ "sUrl": "//cdn.datatables.net/plug-ins/725b2a2115b/i18n/Portuguese.json" }
    });

    $("#search-btn").click(function(event) {
        data.search($("#search-txt").val()).draw();
        event.preventDefault();
    });

    $("input[name=favorito]").click(function(event) {
        console.log("YOU NEED TO REGISTER " + $(this).val());
    });
    
});
</script>
</html>