<?php
    $user="root";
    $mdp="";
    $serveur="localhost";
    $bd="cebg";
    $host="mysql:host=$serveur;dbname=$bd";
   
        $con = new PDO($host, $user, $mdp);
