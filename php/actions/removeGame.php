<?php

if( !isset( $_POST[ "id" ] ) )
{
    header( "Location: ../../games.php" );
    die();
}

require( "../classes/XMLHandle.php" );
XMLHandle::removeGame( $_POST[ "id" ] );

header( "Location: ../../games.php" );
die();
?>