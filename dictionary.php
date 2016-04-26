<?php
require(__DIR__ . '/vendor/autoload.php');

/**
 * @deprecated
 */
function getElementsByClass(&$parentNode, $tagName, $className) {
    $nodes=array();

    $childNodeList = $parentNode->getElementsByTagName('div');
    var_dump($parentNode);
    for ($i = 0; $i < $childNodeList->length; $i++) {
        $temp = $childNodeList->item($i);
        if (stripos($temp->getAttribute('class'), $className) !== false) {
            echo $temp;
            $nodes[]=$temp;
        }
    }

    return $nodes;
}
$data = $_GET['word'];
$page = file_get_contents("http://latin-dictionary.net/search/latin/$data");

$dom = phpQuery::newDocumentHTML($page);
$matches = $dom->find('.entry');
$i=0;
foreach($matches as $match){
    if($i==0){ //for some reason $matches[0] does not work
        $text = $match->nodeValue;
        if(strpos($text, 'Age')!=false){
            $text = substr($text, 0, strpos($text, 'Age'));
        }        
    }
    $i++;
    
}
$text = str_replace("#1", "", $text);
$text = str_replace("Definitions:", "<strong>Definitions:</strong>", $text);
echo $text;