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

// hold the parsed data
$parsed = array();

// hold the highlight colors
$highlight = array();

foreach ($content as $word => $info){
    //parse the array
    $xml = simplexml_load_string($info);
    $html =  $xml->query->pages->page->extract[0];
    foreach(explode("<hr>", $html) as $language){
        $dom = phpQuery::newDocumentHTML($language);
        if ((strpos($dom->html(), '<span id="Latin">'))!=False){
            $text = $dom->document->textContent;
            $text = str_replace("Latin", "", $text);
            $parsed[$word] = $text;
        }
    }
    //echo $dom->html();
    //print_r($list);
    //$parsed[$word] = $dom->document->textContent;
}

// output the data
echo '<ul class="list-inline">';
foreach ($words as $x){
    echo '<li><span data-toggle="tooltip" data-placement="top" title="'.$parsed[$x].'">'.$x.'</span></li> ';
}

echo '</ul><script>$(document).ready(function(){$(\'[data-toggle=\"tooltip\"]\').tooltip();});</script>';