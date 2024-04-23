<?php

use PHPUnit\Framework\TestCase;
use Src\Service\UserLoader;
use Src\Database\DatabaseConnector;

class UserLoaderTest extends TestCase {
    private $dbConnector;
    private $userLoader;
    private $filename;

    protected function setUp(): void {
        $this->dbConnector = new DatabaseConnector();
        $this->userLoader = new UserLoader($this->dbConnector);
        $this->filename = __DIR__ . '/data/test_csv_file.csv';

        $testData = $this->generateTestData(5);
        $this->createTestCsvFile($testData);
    }

    private function generateTestData($numRecords) {
        $data = [];
        for ($i = 1; $i <= $numRecords; $i++) {
            $number = rand(10000, 99999);
            $name = "Test User $i";
            $data[] = [$number, $name];
        }
        return $data;
    }

    private function createTestCsvFile($data) {
        $handle = fopen($this->filename, 'w');
        foreach ($data as $line) {
            fputcsv($handle, $line);
        }
        fclose($handle);
    }

    public function testLoadFromCSV() {
        if (!file_exists($this->filename)) {
            $this->fail("CSV file does not exist: " . $this->filename);
        }

        $this->userLoader->loadFromCSV($this->filename);

        $pdo = $this->dbConnector->getConnection();
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
        $result = $stmt->fetch();
        $this->assertGreaterThan(0, $result['count'], "No users were loaded into the database");
    }

    protected function tearDown(): void {
        if (file_exists($this->filename)) {
            unlink($this->filename);
        }
    }
}
