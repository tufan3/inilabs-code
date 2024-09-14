<?php
interface LoggerInterface {
    public function log(string $message);
}

class FileLogger implements LoggerInterface {
    private $filePath;

    public function __construct($filePath) {
        $this->filePath = $filePath;
    }

    public function log(string $message) {
        file_put_contents($this->filePath, $message . PHP_EOL, FILE_APPEND);
    }
}

class DatabaseLogger implements LoggerInterface {
    public function log(string $message) {
        echo "Logged to the database: $message\n";
    }
}

$fileLogger = new FileLogger('log.txt');
$fileLogger->log("This is a log message to the file.");

$databaseLogger = new DatabaseLogger();
$databaseLogger->log("This is a log message to the database.");

?>
