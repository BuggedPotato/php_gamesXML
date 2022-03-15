<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gry</title>
</head>
<body>

<form id="gamesForm" method="POST" action="games.php">
    <button type="submit" name="displayMode" value="edit">Pozycje</button>
    <button type="submit" name="displayMode" value="view">Podgląd</button>
</form>
<form method="POST" id="moveGame" action="./php/actions/moveGame.php"></form>
<form method="POST" id="editGame" action="./php/actions/editGame.php"></form>

<?php

require( "./php/classes/Game.php" );

$isView = false;
if( isset( $_POST[ "displayMode" ] ) && $_POST[ "displayMode" ] == "view" )
{
    $isView = true;
}

$xml = simplexml_load_file( "games.xml" );
$res = $xml -> xpath( "/root/game" );


echo "<br/><br/>";

for( $i = 0; $i < sizeof( $res ); $i++ )
{
    echo sprintf( '<form method="POST" id="%s"></form>', $i );
}
echo '<form method="POST" id="addGame"></form>';
echo '<form method="POST" id="removeGame"></form>';

echo "<table>";
echo <<<EOD
    <thead>
        <tr>
EOD;
if( !$isView )
echo "<td colspan='2'></td>";

echo <<<EOD
            <td>Nr</td>
            <td>Nazwa</td>
            <td>Zdjęcie</td>
            <td>Autor</td>
            <td>Źródło</td>
            <td></td>
        </tr>
    </thead>
EOD;

foreach( $res as $k => $game )
{
    $title = (string)$game -> title;
    $imageSrc = (string)$game -> image -> attributes()[ "src" ];
    $author = (string)$game -> desc_author;
    $source = (string)$game -> desc_source;
    // var_dump( $title );
    $foo = new Game( $title, $imageSrc, $author, $source );
    if( isset( $_POST[ "id" ] ) && $_POST[ "id" ] == $k )
        echo ( $foo -> getInputRow( null, Array( $title, $imageSrc, $author, $source ), true ) );
    else
        echo ( $foo -> getTableRow( $isView ) );
}
if( !$isView && !isset( $_POST[ "id" ] ) )
    echo Game::getInputRow();

?>

    </table>
</body>
</html>