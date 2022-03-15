<?php

header( "content-type: text/xml" );
$doc = new DOMDocument();
$doc -> load( "games.xml" );

//pobieranie wartości węzła
//echo $doc->getElementsByTagName("w")->item(1)->nodeValue;

//pobieranie wartości atrybutu
//$tag= $doc->getElementsByTagName("w")->item(0);
//echo $tag->getAttribute("plec")." ".$tag->getAttribute("lat");

//tworzenie węzła
// $co=$doc->createElement("w","Oli");
// $gdzie=$doc->getElementsByTagName("root")->item(0);
// $gdzie->appendChild($co);

//tworzenie atrybutu
// $co=$doc->createTextNode("M");
// $attr=$doc->createAttribute("plec");
// $attr->appendChild($co);
// $gdzie=$doc->getElementsByTagName("w")->item(3);
// $gdzie->appendChild($attr);

// //usuwanie węzła
// $co=$doc->getElementsByTagName("w")->item(2);
// $skad=$doc->getElementsByTagName("root")->item(0);
// $skad->removeChild($co);

// //zamiana węzła
// $co=$doc->getElementsByTagName("w")->item(3);
// $jakis=$doc->createElement("w","TESCIOR");
// $co->parentNode->replaceChild($jakis, $co); 

echo $doc->saveXML();
// $doc->save("testNNN.xml");

?>