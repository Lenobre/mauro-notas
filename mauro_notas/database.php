<?php
$pdo = new PDO("mysql:host=localhost;dbname=sistema_notas", 'root', '');
$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);