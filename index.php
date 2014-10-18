<?php 

require 'flight/Flight.php';
require 'crawler.php';
require 'promos.php';

Flight::route('/nightcrawler', 'crawl');

Flight::route('/promos', 'allPromos');
Flight::route('/stores', 'allStores');
Flight::route('/categories', 'allCategories');

Flight::route('/t', 'test');

Flight::route('/', function(){
	// Display custom 404 page
	include 'test.php';
});

Flight::map('notFound', function(){
	// Display custom 404 page
	echo 'bad world!';
});

Flight::start();

?>