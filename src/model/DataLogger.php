<?php
class DataLogger
{
    private $logFile;

    public function __construct(string $logFile)
    {
        $this->logFile = $logFile;

        // Create log directory if it doesn't exist
        $logDir = dirname($this->logFile);
        if (! is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
    }

    public function logSubmission(array $formData)
    {
        // Add timestamp to the data
        $formData['timestamp'] = date('Y-m-d H:i:s');

        // Encode as JSON
        $logEntry = json_encode($formData) . "\n";

        // Write to log file
        file_put_contents($this->logFile, $logEntry, FILE_APPEND);
    }
}
