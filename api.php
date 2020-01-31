<?php
error_reporting(0);
//$data = file_get_contents('https://onions.danwin1210.me/?cat=19&pg=0&lang=en'); // Scrape all links from Daniel Winzen Link List

$data = file_get_contents('https://onions.danwin1210.me/?q='.$argv[1].'&pg=0'); // Scrape search (via arguments in command line)
//$data = file_get_contents('https://onions.danwin1210.me/?q='.$_GET["query"].'&pg=0'); // Scrape search (via parameter 'query')

// Scraping by Category
//$data = file_get_contents('https://onions.danwin1210.me/?cat=1&pg=0&lang=en'); // Adult/Porn
//$data = file_get_contents('https://onions.danwin1210.me/?cat=18&pg=0&lang=en'); // Autodetected scam (unchecked)
//$data = file_get_contents('https://onions.danwin1210.me/?cat=14&pg=0&lang=en'); // Cryptocurrencies
//$data = file_get_contents('https://onions.danwin1210.me/?cat=13&pg=0&lang=en'); // Empty/Error/Unknown
//$data = file_get_contents('https://onions.danwin1210.me/?cat=3&pg=0&lang=en'); // Forums
//$data = file_get_contents('https://onions.danwin1210.me/?cat=16&pg=0&lang=en'); // Fun/Games/Joke
//$data = file_get_contents('https://onions.danwin1210.me/?cat=4&pg=0&lang=en'); // Hacking/Programming/Software
//$data = file_get_contents('https://onions.danwin1210.me/?cat=5&pg=0&lang=en'); // Hosting
//$data = file_get_contents('https://onions.danwin1210.me/?cat=6&pg=0&lang=en'); // Libraries/Wikis
//$data = file_get_contents('https://onions.danwin1210.me/?cat=7&pg=0&lang=en'); // Link Lists
//$data = file_get_contents('https://onions.danwin1210.me/?cat=8&pg=0&lang=en'); // Market/Shop/Store
//$data = file_get_contents('https://onions.danwin1210.me/?cat=9&pg=0&lang=en'); // Other
//$data = file_get_contents('https://onions.danwin1210.me/?cat=10&pg=0&lang=en'); // Personal Sites/Blogs
//$data = file_get_contents('https://onions.danwin1210.me/?cat=15&pg=0&lang=en'); // Scams
//$data = file_get_contents('https://onions.danwin1210.me/?cat=17&pg=0&lang=en'); // Search
//$data = file_get_contents('https://onions.danwin1210.me/?cat=11&pg=0&lang=en'); // Security/Privacy/Encryption
//$data = file_get_contents('https://onions.danwin1210.me/?cat=0&pg=0&lang=en'); // Unsorted
//$data = file_get_contents('https://onions.danwin1210.me/?cat=12&pg=0&lang=en'); // Whistleblowing
//

// $data = file_get_contents('https://onions.danwin1210.me/onions.php?cat=20&pg=0&lang=en'); // Latest added links (Max 50)

$dom = new domDocument;
@$dom->loadHTML($data);
$dom->preserveWhiteSpace = false;
$tables = $dom->getElementsByTagName('table');
$counter = 0;
$rows = $tables->item(1)->getElementsByTagName('tr'); 

$skip_first = 0; // We skip first row because it contains headers like "Onion link" "Description"  "Last tested" ..
$future_json = '{ "onions": [';
foreach ($rows as $row) {
	if ($skip_first == 0){
		$skip_first++;
	} else {
		$cols = $row->getElementsByTagName('td'); 
    	$future_json .= '{ ';
    	$future_json .= '"Link": "'. $cols->item(0)->nodeValue . '",';
    	$future_json .= '"Description": "'. $cols->item(1)->nodeValue . '",';
    	$future_json .= '"Created": "'. $cols->item(4)->nodeValue . '"';
    	$future_json .= '},';
	}
    
}
$future_json .= '] }';
$future_json = str_replace("},] }","} ] }",$future_json);
die($future_json);

?>