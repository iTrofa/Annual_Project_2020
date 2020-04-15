<?php
spl_autoload_register(    function (string $class){
        require  "class/{$class}.php";
    });
