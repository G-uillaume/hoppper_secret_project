<?php
function dbConnect() {
    return new PDO("mysql:host=localhost;dbname=hopper_secret_project;charset=utf8", 
        "root", 
        "root", 
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
}