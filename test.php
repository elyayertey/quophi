<?php
require "vendor/autoload.php";
use quophi\product;

$prod = new product();
$prod->listMoreActiveProducts(1);