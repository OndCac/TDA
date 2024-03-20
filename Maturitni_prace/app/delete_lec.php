<?php

$con = ConnectDB();
DeleteLec($con, $_COOKIE['uuid']);

?>