<?php
// header( "content-type: text/xml" );

// var_dump( $_POST );
if( !isset( $_POST[ "id" ] ) )
{
    header( "Location: ../../games.php" );
    die();
}

require( "../classes/XMLHandle.php" );
require( "../classes/Game.php" );

$title = $_POST[ "title" ];
$imageSrc = $_POST[ "imageSrc" ];
$author = $_POST[ "author" ];
$source = $_POST[ "source" ];

$game = new Game( $title, $imageSrc, $author, $source );
// XMLHandle::editGame( $_POST[ 'id' ], $game );
var_dump( XMLHandle::editGame( $_POST[ 'id' ], $game -> getXML() ) );

header( "Location: ../../games.php" );
die();
?>