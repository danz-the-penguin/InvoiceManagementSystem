<?php

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    private $mysqli;

    protected function setUp(): void
    {
        // Simulate database connection
        $this->mysqli = new mysqli('localhost', 'root', '', 'invoice_management');

        // Verify connection
        if ($this->mysqli->connect_error) {
            $this->fail("Database connection failed: " . $this->mysqli->connect_error);
        }

        // Seed the database with test data
        $this->mysqli->query("INSERT INTO users (username, password) VALUES 
                              ('testuser', '" . password_hash('testpassword', PASSWORD_DEFAULT) . "')");
    }

    protected function tearDown(): void
    {
        // Cleanup test data
        $this->mysqli->query("DELETE FROM users WHERE username = 'testuser'");

        // Close the database connection
        $this->mysqli->close();
    }

    public function testSuccessfulLogin()
    {
        // Simulate POST request
        $_POST['username'] = 'testuser';
        $_POST['password'] = 'testpassword';

        // Include the login.php script
        ob_start();  // Start output buffering
        include 'login.php';
        $output = ob_get_clean();  // Get output

        $this->assertEquals(1, $output, "Login should succeed for valid credentials");
    }

    public function testIncorrectPassword()
    {
        $_POST['username'] = 'testuser';
        $_POST['password'] = 'wrongpassword';

        ob_start();
        include 'login.php';
        $output = ob_get_clean();

        $this->assertEquals(0, $output, "Login should fail for incorrect password");
    }

    public function testNonExistentUser()
    {
        $_POST['username'] = 'nonexistentuser';
        $_POST['password'] = 'any_password';

        ob_start();
        include 'login.php';
        $output = ob_get_clean();

        $this->assertEquals(0, $output, "Login should fail for non-existent username");
    }
}