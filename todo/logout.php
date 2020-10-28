<?php
// logout.php

session_start();
// remove all session values
session_destroy();
// redirect to login page
header("location:index.php");
?>