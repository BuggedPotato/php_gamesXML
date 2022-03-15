<?php

if( !isset( $_POST[ "title" ] ) )
{
    header( "Location: ../../games.php" );
    die();
}

require( "../classes/Game.php" );
require( "../classes/XMLHandle.php" );

$title = $_POST[ "title" ];
$imageSrc = $_POST[ "imageSrc" ];
$author = $_POST[ "author" ];
$source = $_POST[ "source" ];

Game::setLastId( $_POST[ "id" ] );
$game = new Game( $title, $imageSrc, $author, $source );
$gameXmlString =  $game -> getXML();
XMLHandle::addGame( $gameXmlString );

header( "Location: ../../games.php" );
die();
?>