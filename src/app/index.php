<?
require("handlers/XXXX.php");

// require("libs/mysql.php");
// require("libs/queries.php");

require("libs/Toro.php");

ToroHook::add("404", function() {
    echo "Not found";
});

Toro::serve(array(
    // "/" => "ArticlesHandler",
    // "/article/:alpha" => "ArticleHandler",
    // "/article/:alpha/comment" => "CommentHandler"
));