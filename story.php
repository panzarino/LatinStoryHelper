<?php

$story = $_GET['story'];

$story = strip_tags($story);

$words = explode(" ", $story);

$content = array();

foreach ($words as $word){
    if (!(array_key_exists($word, $content))){
        $page = file_get_contents("https://en.wiktionary.org/w/api.php?format=xml&action=query&prop=extracts&titles=".$word."&redirects=true&continue");
        $content[$word] = $page;
    }
    
}


foreach ($content as $x){
        
}
