<?php
require 'config.php';
session_destroy();
header("Location: login.php");
exit;
// menambah fitur logout akun
