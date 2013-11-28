<?php


if(getenv("PREFIX_URL")){
	$prefix_url  =   getenv("PREFIX_URL");
}elseif(isset($GLOBALS['testing.maindomain'])){
	$prefix_url  =   $GLOBALS['testing.maindomain'];
}else{
	$prefix_url =   "http://www.PROJECTDOMAIN.COM";
}
define("PREFIX_URL", $prefix_url);