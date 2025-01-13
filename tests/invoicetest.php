<?php

use PHPUnit\Framework\TestCase;

class InvoiceTest extends TestCase
{
    private $mysqli;

    protected function setUp(): void
    {
        $this->mysqli = new mysqli('localhost', 'root', '', 'invoice_management');

        if($this->mysqli->connect_error){
            $this->fail("Database connection failed: " . $this->mysqli->connect_error);

        }

        $this->mysqli->query("");
    }
}

?>