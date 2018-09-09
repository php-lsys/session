<?php
include __DIR__."/Bootstarp.php";
$sess=LSYS\Session\DI::get()->session();
echo $sess->get("aa");
$sess->set("aa", "aaa");



