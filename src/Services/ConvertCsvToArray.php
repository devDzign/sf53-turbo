<?php

namespace App\Services;

class ConvertCsvToArray
{
    /**
     * @param        $filename
     * @param string $delimiter
     *
     * @return array|null
     */
    public function convert($filename, $delimiter = ';'): ?array
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return null;
        }

        $header = null;
        $data = array();

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }
}
