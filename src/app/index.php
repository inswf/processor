<?php
//Handlers
require("handlers/XXX.php");

//Libs
require("libs/Array2.php");
require("libs/BitField.php");
require("libs/ByteArray.php");
require("libs/FileIO.php");
//Sina app engine
require("libs/SaeCounter.php");
require("libs/SaeKV.php");
//Toro @see: http://toroweb.org/
require("libs/Toro.php");

//Http status code handlers
ToroHook::add("404", function() {
    echo "Not found";
});

Toro::serve(array(
    // "/" => "ArticlesHandler",
    // "/article/:alpha" => "ArticleHandler",
    // "/article/:alpha/comment" => "CommentHandler"
));