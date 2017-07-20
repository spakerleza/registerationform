<?php
define("BASEURL", TRUE);

require "class.php";
require "function.php";

$reg = new registeration;
$reg->post($_POST, $_FILES)


?>