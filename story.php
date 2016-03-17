<?php

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

foreach ($content as $word => $info){
    //parse the array      
    
}
