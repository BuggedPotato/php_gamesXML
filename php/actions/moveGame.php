<?php
// header( "content-type: text/xml" );

var_dump( $_POST );
if( !isset( $_POST[ "id" ] ) || !isset( $_POST[ "direction" ] ) )
{
    header( "Location: ../../games.php" );
    die();
}

// require( "../classes/Game.php" );
require( "../classes/XMLHandle.php" );

// var_dump( XMLHandle::moveGame( $_POST[ "id" ], $_POST[ "direction" ] ) );
XMLHandle::moveGame( $_POST[ 'id' ], $_POST[ "direction" ] );

header( "Location: ../../games.php" );
die();
?>