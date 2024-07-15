<?php

require_once 'C:\xampp\htdocs\DICT-prereg\src\setup.php';

try {
        
    $pdo = new PDO("mysql:host=localhost;dbname=prereg", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT timestart, timeend FROM timeslots");
    
    $stmt->execute();  
    $time_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} 

catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
