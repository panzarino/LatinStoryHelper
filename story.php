<?php
require(__DIR__ . '/vendor/autoload.php');

$story = $_GET['story'];

$story = strip_tags($story);

$words = explode(" ", $story);

$content = array(); //Associative array representing what wiktionary returns

foreach ($words as $word){ 
    if (!(array_key_exists($word, $content))){ //make sure key is not already in dictionary.
        $page = file_get_contents("https://en.wiktionary.org/w/api.php?format=xml&action=query&prop=extracts&titles=".$word."&redirects=true&continue"); //get the page from the wiktionary api
        $content[$word] = $page;
    }
    
}

$parsed = array();

foreach ($content as $word => $info){
    //parse the array
    $xml = simplexml_load_string($info);
    $dom = phpQuery::newDocumentHTML($xml->query->pages->page->extract[0]);
}

// output the data
foreach ($words as $x){
    echo $parsed[$x];
}