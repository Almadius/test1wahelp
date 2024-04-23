<?php

use PHPUnit\Framework\TestCase;
use Src\Service\Messenger;
use Src\Database\DatabaseConnector;

class MessengerTest extends TestCase {
    private $dbConnector;
    private $messenger;

    protected function setUp(): void {
        $this->dbConnector = new DatabaseConnector();
        $this->messenger = new Messenger($this->dbConnector);
        $this->pdo = $this->dbConnector->getConnection();
        $this->pdo->beginTransaction();

        $this->pdo->query("DELETE FROM users");
        $this->pdo->query("INSERT INTO users (number, name, sent) VALUES ('1234567890', 'Test User', 0)");
    }

    protected function tearDown(): void {
        $this->pdo->rollBack();
    }

    public function testSendMessages() {
        $this->pdo->query("UPDATE users SET sent = 0");

        $this->messenger->sendMessages();

        $stmt = $this->pdo->query("SELECT COUNT(*) as sentCount FROM users WHERE sent = 1");
        $result = $stmt->fetch();
        $this->assertEquals(1, $result['sentCount'], "All users should be marked as sent");
    }
}
