<?php
require(__DIR__ . '/vendor/autoload.php');

$story = $_GET['story'];

$story = strip_tags($story);

$words = explode(" ", $story);

$content = array(); //Associative array representing what wiktionary returns

foreach ($words as $word){ 
    if (!(array_key_exists($word, $content))){ //make sure key is not already in dictionary.
        $query = preg_replace('#[^a-zA-Z]#', '', $word);
        $page = file_get_contents("https://en.wiktionary.org/w/api.php?format=xml&action=query&prop=extracts&titles=".$query."&redirects=true&continue"); //get the page from the wiktionary api
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
        if ((strpos($dom->html(), '<span id="Latin">'))!=false){
            $text = $dom->document->textContent;
            $text = str_replace("Latin", "", $text);
            $text = str_replace("Etymology", "", $text);
            $parsed[$word] = $text;
            if ((strpos($text, 'Participle')!=false) || (strpos($text, 'participle')!=false)){
                $highlight[$word] = "yellow";
            }
            elseif ((strpos($text, 'infinitive'))!=false && (strpos($text, 'Pronunciation'))==false){
                $highlight[$word] = "green";
            }
            elseif ((strpos($text, 'Subjunctive'))!=false || (strpos($text, 'subjunctive')!=false)){
                $highlight[$word] = "blue";
            }
            elseif ((strpos($text, 'Verb'))!=false || (strpos($text, 'verb')!=false)){
                $highlight[$word] = "orange";
            }
        }
    }
    //echo $dom->html();
    //print_r($list);
    //$parsed[$word] = $dom->document->textContent;
}

// output the data
echo '<ul class="list-inline">';
foreach ($words as $x){
    if (isset($highlight[$x])){
        echo '<li><span class="highlight-'.$highlight[$x].'" data-toggle="tooltip" data-placement="top" title="'.$parsed[$x].'">'.$x.'</span></li> ';
    }
    else {
        echo '<li><span data-toggle="tooltip" data-placement="top" title="'.$parsed[$x].'">'.$x.'</span></li> ';
    }
}

echo '</ul><script>$(document).ready(function(){$(\'[data-toggle=\"tooltip\"]\').tooltip();});</script>';