<?php

abstract class BaseController {
    
    protected $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
}
