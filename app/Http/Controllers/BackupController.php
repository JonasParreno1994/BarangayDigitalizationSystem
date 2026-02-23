<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BackupController extends Controller
{
    /**
     * Download an SQL dump of the entire database.
     */
    public function exportSql()
    {
        $databaseName = DB::getDatabaseName();
        $tables = DB::select('SHOW TABLES');

        // Extract "Tables_in_dbname" dynamically base on object keys
        $tableKey = 'Tables_in_' . $databaseName;

        $response = new StreamedResponse(function () use ($tables, $tableKey) {
            $handle = fopen('php://output', 'w');

            fwrite($handle, "-- --------------------------------------------------------\n");
            fwrite($handle, "-- System Database Backup\n");
            fwrite($handle, "-- Generated: " . now()->format('Y-m-d H:i:s') . "\n");
            fwrite($handle, "-- --------------------------------------------------------\n\n");
            fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n\n");

            foreach ($tables as $tableItem) {
                // Determine the correct property name for the table (PDO results vary by configuration)
                $tableName = null;
                if (isset($tableItem->$tableKey)) {
                    $tableName = $tableItem->$tableKey;
                } elseif (isset(array_values((array)$tableItem)[0])) {
                    $tableName = array_values((array)$tableItem)[0];
                }

                if (!$tableName) {
                    continue;
                }

                fwrite($handle, "--\n-- Table structure for table `{$tableName}`\n--\n\n");
                
                // Drop if exists
                fwrite($handle, "DROP TABLE IF EXISTS `{$tableName}`;\n");

                // Create Table syntax
                $createResp = DB::select("SHOW CREATE TABLE `{$tableName}`");
                if (isset($createResp[0]->{'Create Table'})) {
                    $createSql = $createResp[0]->{'Create Table'};
                    fwrite($handle, "{$createSql};\n\n");
                }

                // Dump Data
                $rows = DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    fwrite($handle, "--\n-- Dumping data for table `{$tableName}`\n--\n\n");

                    foreach ($rows->chunk(500) as $chunk) {
                        foreach ($chunk as $row) {
                            $rowArray = (array)$row;
                            $columns = array_keys($rowArray);
                            $values = array_values($rowArray);

                            // Escape and format values
                            $escapedValues = array_map(function ($value) {
                                if (is_null($value)) {
                                    return 'NULL';
                                }
                                // Escape single quotes and backslashes
                                $value = str_replace(['\\', "'"], ['\\\\', "''"], $value);
                                return "'{$value}'";
                            }, $values);

                            $colStr = implode("`, `", $columns);
                            $valStr = implode(", ", $escapedValues);

                            fwrite($handle, "INSERT INTO `{$tableName}` (`{$colStr}`) VALUES ({$valStr});\n");
                        }
                    }
                    fwrite($handle, "\n");
                }
            }

            fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n\n");
            fclose($handle);
        });

        // Setup headers to trigger a download
        $fileName = 'system_backup_' . date('Y_m_d_His') . '.sql';
        $response->headers->set('Content-Type', 'application/sql');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Cache-Control', 'must-revalidate, post-check=0, pre-check=0');
        $response->headers->set('Expires', '0');

        return $response;
    }
}
