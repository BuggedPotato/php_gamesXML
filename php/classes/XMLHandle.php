<?php
header( "content-type: text/xml" );

class XMLHandle
{
    private const FILENAME = "../../games.xml";


    public static function addGame( string $game )
    {
        $doc = new DOMDocument( "1.0", "utf-8" );
        $doc -> load( self::FILENAME );
        $root = $doc -> getElementsByTagName( "root" )[0];
        $newGame = new DOMDocument( "1.0", "utf-8" );
        $newGame -> loadXML( $game );

        $newGame = $doc -> importNode( $newGame -> documentElement, true );
        // var_dump( $newGame );
        $root -> appendChild( $newGame );
        $doc -> save( self::FILENAME );
    }

    public static function removeGame( int $id )
    {
        $doc = new DOMDocument( "1.0", "utf-8" );
        $doc -> load( self::FILENAME );
        $root = $doc -> getElementsByTagName( "root" )[0];
        $toRemove = $doc -> getElementsByTagName( "game" )[ $id ];
        $root -> removeChild( $toRemove );
        $doc -> save( self::FILENAME );
    }

    public static function moveGame( int $id, string $direction )
    {
        $doc = new DOMDocument( "1.0", "utf-8" );
        $doc -> load( self::FILENAME );

        $games = $doc -> getElementsByTagName( "game" );
        $toMove = $games[ $id ];

        $referenceNodeId = $id + ( $direction == "up" ? -1 : 2 );
        if( $referenceNodeId > count( $games ) || $referenceNodeId < 0 )
        {
            return;
        }

        if( $referenceNodeId == count( $games ) )
        {
            $root = $doc -> getElementsByTagName( "root" )[0];
            $root -> appendChild( $toMove );
        }
        else
        {
            $referenceNode = $games[ $referenceNodeId ];
            $referenceNode -> parentNode -> insertBefore( $toMove, $referenceNode );
        }

        $doc -> save( self::FILENAME );
    }

    public static function editGame( int $id, string $newGame )
    {
        $doc = new DOMDocument( "1.0", "utf-8" );
        $doc -> load( self::FILENAME );

        $toEdit = $doc -> getElementsByTagName( "game" )[ $id ];
        
        $newGameDoc = new DOMDocument( "1.0", "utf-8" );
        $newGameDoc -> loadXML( $newGame );
        $newGameDoc = $doc -> importNode( $newGameDoc -> documentElement, true );

        $toEdit -> parentNode -> replaceChild( $newGameDoc, $toEdit );

        // return $doc -> saveXML();

        $doc -> save( self::FILENAME );
    }
}

?>