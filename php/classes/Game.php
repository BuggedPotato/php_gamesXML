<?php

class Game
{
    private static int $lastId = -1;

    public int $id;
    public string $title;
    public string $imageSrc;
    public string $author;
    public string $source;

    public function __construct( string $t, string $img, string $a, string $src )
    {
        $this -> id = self::getNewId();
        $this -> title = $t;
        $this -> imageSrc = $img;
        $this -> author = $a;
        $this -> source = $src;
    }

    public function getTableRow( bool $showImage = false )
    {
        $dom = new DOMDocument( '1.0', 'utf-8' );
        $row = $dom -> createElement( "tr" );

        if( !$showImage )
        {
            $cell = $dom -> createElement( "td" );
            $arrowUp = self::getSubmitButton( $dom, $this -> id, "./php/actions/moveGame.php", "/\\" );
            $valueAttr = $dom -> createAttribute( "value" );
            $valueAttr -> value = "up";
            $arrowUp -> appendChild( $valueAttr );
            $nameAttr = $dom -> createAttribute( "name" );
            $nameAttr -> value = "direction";
            $arrowUp -> appendChild( $nameAttr );

            $arrowDown = self::getSubmitButton( $dom, $this -> id, "./php/actions/moveGame.php", "\\/" );
            $valueAttr = $dom -> createAttribute( "value" );
            $valueAttr -> value = "down";
            $arrowDown -> appendChild( $valueAttr );
            $nameAttr = $dom -> createAttribute( "name" );
            $nameAttr -> value = "direction";
            $arrowDown -> appendChild( $nameAttr );

            $cell -> appendChild( $arrowUp );
            $cell -> appendChild( $arrowDown );

            $row -> appendChild( $cell );
    
            $cell = $dom -> createElement( "td" );
            $editButton = self::getSubmitButton( $dom, "gamesForm", "games.php", "Edytuj" );
            $valueAttr = $dom -> createAttribute( "value" );
            $valueAttr -> value = $this -> id;
            $editButton -> appendChild( $valueAttr );
            $nameAttr = $dom -> createAttribute( "name" );
            $nameAttr -> value = "id";
            $editButton -> appendChild( $nameAttr );
            $cell -> appendChild( $editButton );
            $row -> appendChild( $cell );
        }

        $cell = $dom -> createElement( "td", $this -> id );
        $idInput = self::getInput( $dom, $this -> id, "id", "hidden" );
        $valueAttr = $dom -> createAttribute( "value" );
        $valueAttr -> value = $this -> id;
        $idInput -> appendChild( $valueAttr );
        $cell -> appendChild( $idInput );
        $row -> appendChild( $cell );

        $cell = $dom -> createElement( "td", $this -> title );
        $row -> appendChild( $cell );

        
        if( !$showImage )
        {
            $cell = $dom -> createElement( "td", $this -> imageSrc );
        }
        else
        {
            $cell = $dom -> createElement( "td" );
            $img = $dom -> createElement( "img" );
            $srcAttr = $dom -> createAttribute( "src" );
            $srcAttr -> value = "./gfx/" . $this -> imageSrc;
            $img -> appendChild( $srcAttr );
            $cell -> appendChild( $img );
        }
        $row -> appendChild( $cell );

        // source cell with working html tags
        $cell = $dom -> createElement( "td", $this -> author );
        $row -> appendChild( $cell );
        $cell = $dom -> createElement( "td" );

        $fragment = $dom -> createDocumentFragment();
        $fragment -> appendXML( $this -> source );
        $cell -> appendChild( $fragment );
        $row -> appendChild( $cell );
        // ==================

        // remove button
        if( !$showImage )
        {
            $cell = $dom -> createElement( "td" );
            $button = self::getSubmitButton( $dom, $this -> id, "./php/actions/removeGame.php", "Usuń" );
            $cell -> appendChild( $button );
            $row -> appendChild( $cell );
        }
        // ===========================

        return $dom -> saveHTML( $row );
    }

    public static function getInputRow( int $id = null, Array $values = null, bool $isEdit = false )
    {
        $dom = new DOMDocument( '1.0', 'utf-8' );
        $row = $dom -> createElement( "tr" );
        $formId = $isEdit ? "editGame" : "addGame";

        // hidden input cell
        if( $id == null )
        {
            $id = self::$lastId;
        }
        $cell = $dom -> createElement( "td" );
        $attr = $dom -> createAttribute( "colspan" );
        $attr -> value = 3;
        $cell -> appendChild( $attr );

        $idInput = self::getInput( $dom, $formId, "id", "hidden" );
        $valueAttr = $dom -> createAttribute( "value" );
        $valueAttr -> value = $id;
        $idInput -> appendChild( $valueAttr );

        $cell -> appendChild( $idInput );
        $row -> appendChild( $cell );
        // =========================

        $arr = Array( "title", "imageSrc", "author", "source" );
        for( $i = 0; $i < 4; $i++ )
        {
            $cell = $dom -> createElement( "td" );
            $foo = self::getInput( $dom, $formId, $arr[ $i ] );
            if( $isEdit && $values != null )
                $foo -> setAttribute( "value", $values[ $i ] );
            $cell -> appendChild( $foo );
            $row -> appendChild( $cell );
        }
        $cell = $dom -> createElement( "td" );
        $button = null;
        if( $isEdit )
        {
            $button = self::getSubmitButton( $dom, "editGame", "./php/actions/editGame.php", "Zapisz" );
        }
        else
        {
            $button = self::getSubmitButton( $dom, "addGame", "./php/actions/addGame.php" );
        }
        $cell -> appendChild( $button );
        $row -> appendChild( $cell );

        return $dom -> saveHTML( $row );
    }

    private static function getInput( $parentDom, string $form, string $name, string $type = "text" )
    {
        $input = $parentDom -> createElement( "input" );

        $typeAttr = $parentDom -> createAttribute( "type" );
        $typeAttr -> value = $type;
        $input -> appendChild( $typeAttr );

        $nameAttr = $parentDom -> createAttribute( "name" );
        $nameAttr -> value = $name;
        $input -> appendChild( $nameAttr );

        $formAttr = $parentDom -> createAttribute( "form" );
        $formAttr -> value = $form;
        $input -> appendChild( $formAttr );

        $requiredAttr = $parentDom -> createAttribute( "required" );
        $requiredAttr -> value = "required";
        $input -> appendChild( $requiredAttr );

        return $input;
    }

    private static function getSubmitButton( $parentDom, string $form, string $action, string $text = "Dodaj" )
    {
        $button = $parentDom -> createElement( "button", $text );
        
        $typeAttr = $parentDom -> createAttribute( "type" );
        $typeAttr -> value = "submit";
        $button -> appendChild( $typeAttr );

        $formAttr = $parentDom -> createAttribute( "form" );
        $formAttr -> value = $form;
        $button -> appendChild( $formAttr );

        $actionAttr = $parentDom -> createAttribute( "formaction" );
        $actionAttr -> value = $action;
        $button -> appendChild( $actionAttr );

        return $button;
    }

    public function getXML()
    {
        $doc = new DOMDocument( "1.0", "utf-8" );
        $game = $doc -> createElement( "game" );
        // $idAttr = $doc -> createAttribute( "id" );
        // $idAttr -> value = $this -> id;
        // $game -> appendChild( $idAttr );
     
        $title = $doc -> createElement( "title", $this -> title );

        $image = $doc -> createElement( "image" );
        $srcAttr = $doc -> createAttribute( "src" );
        $srcAttr -> value = $this -> imageSrc;
        $image -> appendChild( $srcAttr );

        $author = $doc -> createElement( "desc_author", $this -> author );
        $source = $doc -> createElement( "desc_source", $this -> source );

        $game -> appendChild( $title );
        $game -> appendChild( $image );
        $game -> appendChild( $author );
        $game -> appendChild( $source );

        return $doc -> saveXML( $game );
    }

    private static function getNewId()
    {
        return ++self::$lastId;
    }
    public static function setLastId( int $newId )
    {
        self::$lastId = $newId;
    }
    public static function getLastId()
    {
        return self::$lastId;
    }
}

?>