<?php
class DataInserter {
    private $endpoint = 'http://localhost:9000/write';
    private $buffer = [];
    private $bufferSize = 10;
    private $flushInterval = 30; // time in seconds
    private $lastFlushTime;

    public function __construct($bufferSize = 10, $flushInterval = 30) {
        $this->bufferSize = $bufferSize;
        $this->flushInterval = $flushInterval;
        $this->lastFlushTime = time();
    }

    public function __destruct() {
        // Attempt to flush any remaining data when script is terminating
        $this->flush();
    }

    public function insertRow($tableName, $symbols, $columns, $timestamp = null) {
        $row = $this->formatRow($tableName, $symbols, $columns, $timestamp);
        $this->buffer[] = $row;
        $this->checkFlushConditions();
    }

    private function formatRow($tableName, $symbols, $columns, $timestamp) {
        $escape = function($value) {
            return str_replace([' ', ',', "\n"], ['\ ', '\,', '\n'], $value);
        };

        $symbolString = implode(',', array_map(
            function($k, $v) use ($escape) { return "$k={$escape($v)}"; }, 
            array_keys($symbols), $symbols
        ));

        $columnString = implode(',', array_map(
            function($k, $v) use ($escape) { return "$k={$escape($v)}"; }, 
            array_keys($columns), $columns
        ));

        // Check if timestamp is provided
        $timestampPart = is_null($timestamp) ? '' : " $timestamp";

        return "$tableName,$symbolString $columnString$timestampPart";
    }

    private function checkFlushConditions() {
        if (count($this->buffer) >= $this->bufferSize || (time() - $this->lastFlushTime) >= $this->flushInterval) {
            $this->flush();
        }
    }

    private function flush() {
        if (empty($this->buffer)) {
            return; // Nothing to flush
        }
        $data = implode("\n", $this->buffer);
        $this->buffer = [];
        $this->lastFlushTime = time();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: text/plain']);
        curl_exec($ch);
        curl_close($ch);
    }
}

// Usage example:
$inserter = new DataInserter(10, 30);

// Inserting rows for London
$inserter->insertRow("test_readings", ["city" => "London", "make" => "Omron"], ["temperature" => 23.5, "humidity" => 0.343], "1650573480100400000");
$inserter->insertRow("test_readings", ["city" => "London", "make" => "Sony"], ["temperature" => 21.0, "humidity" => 0.310]);
$inserter->insertRow("test_readings", ["city" => "London", "make" => "Philips"], ["temperature" => 22.5, "humidity" => 0.333], "1650573480100500000");
$inserter->insertRow("test_readings", ["city" => "London", "make" => "Samsung"], ["temperature" => 24.0, "humidity" => 0.350]);

// Inserting rows for Madrid
$inserter->insertRow("test_readings", ["city" => "Madrid", "make" => "Omron"], ["temperature" => 25.5, "humidity" => 0.360], "1650573480100600000");
$inserter->insertRow("test_readings", ["city" => "Madrid", "make" => "Sony"], ["temperature" => 23.0, "humidity" => 0.340]);
$inserter->insertRow("test_readings", ["city" => "Madrid", "make" => "Philips"], ["temperature" => 26.0, "humidity" => 0.370], "1650573480100700000");
$inserter->insertRow("test_readings", ["city" => "Madrid", "make" => "Samsung"], ["temperature" => 22.0, "humidity" => 0.355]);

// Inserting rows for New York
$inserter->insertRow("test_readings", ["city" => "New York", "make" => "Omron"], ["temperature" => 20.5, "humidity" => 0.330], "1650573480100800000");
$inserter->insertRow("test_readings", ["city" => "New York", "make" => "Sony"], ["temperature" => 19.0, "humidity" => 0.320]);
$inserter->insertRow("test_readings", ["city" => "New York", "make" => "Philips"], ["temperature" => 21.0, "humidity" => 0.340], "1650573480100900000");
$inserter->insertRow("test_readings", ["city" => "New York", "make" => "Samsung"], ["temperature" => 18.5, "humidity" => 0.335]);
?>
