<?php

namespace Src\Service;

use Src\Database\DatabaseConnector;

class Messenger {
    private $db;

    public function __construct(DatabaseConnector $db) {
        $this->db = $db->getConnection();
    }

    public function sendMessages() {
        $stmt = $this->db->query("SELECT * FROM users WHERE sent = 0");
        while ($user = $stmt->fetch()) {
            $this->markAsSent($user['id']);
        }
    }

    private function markAsSent($userId) {
        $stmt = $this->db->prepare("UPDATE users SET sent = 1 WHERE id = ?");
        $stmt->execute([$userId]);
    }
}
