<?php
require("Toro.php");

class HelloHandler {
    public function HelloHandler()
    {
        echo "HelloHandler";
    }
    function get() {
      echo "Hello, world";
    }
}
Toro::serve(array(
    "/" => "HelloHandler"
));