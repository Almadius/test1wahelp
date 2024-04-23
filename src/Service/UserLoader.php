<?php
namespace Src\Service;

use Src\Database\DatabaseConnector;
use Src\Model\User;

class UserLoader {
    private $db;

    public function __construct(DatabaseConnector $db) {
        $this->db = $db->getConnection();
    }

    public function loadFromCSV($filename) {
        $file = fopen($filename, 'r');
        while (($row = fgetcsv($file)) !== FALSE) {
            $this->insertUser(new User($row[0], $row[1]));
        }
        fclose($file);
    }

    private function insertUser(User $user) {
        $stmt = $this->db->prepare("INSERT INTO users (number, name) VALUES (:number, :name)");
        $stmt->execute([':number' => $user->number, ':name' => $user->name]);
    }
}