<?php

$story = $_GET['story'];

$story = strip_tags($story);

$array = explode(" ", $story);

$content = [];

foreach ($array as $x){
    $page = file_get_contents("https://en.wiktionary.org/w/api.php?format=xml&action=query&prop=extracts&titles=".$x."&redirects=true&continue");
    array_push($content, $page);
}

foreach($content as $x){
    echo $x." ";
}
                