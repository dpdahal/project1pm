<?php

$connection = mysqli_connect('127.0.0.1', 'root', 'admin', 'project1pm');

if (!$connection) {
    echo "Database not connected";
    die();
}