<?php
final class Counter
{
    // private $file;
    // private $handle;
    public function __construct()
    {

    }
    public static function count(bool $isCounted, $filePath): int
    {
        if (! file_exists($filePath)) {
            file_put_contents($filePath, 0);
        }
        $count = (int) file_get_contents($filePath);

        if (! $isCounted) {
            $count++;
            file_put_contents($filePath, $count);
        }
        return $count;
    }
}
