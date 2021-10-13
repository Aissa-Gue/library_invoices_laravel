<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public function show()
    {
        return view('settings.database');
    }

    public function exportDB()
    {
        $username = env('DB_USERNAME');
        $dbname = env('DB_DATABASE');
		$dbport = env('DB_PORT');
        $ignoreUsers = '--ignore-table=' . $dbname . '.users';
        $ignoreMigrations = '--ignore-table=' . $dbname . '.migrations';

        $d = date('Y-m-d');
        $t = time();
        $dir = 'D:/library_invoices_backups/' . $d . '/';
        $path = $dir . $dbname . '_' . $t . '.sql';
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $command = "C:/xampp/mysql/bin/mysqldump.exe -u $username --port=$dbport $dbname $ignoreUsers $ignoreMigrations >" . $path;

        exec($command . ' 2>&1', $output);

        if (count($output) == 0) {
            $successExportDbAlert = "تم استخراج نسخة احتياطية بنجاح، تفقد المسار: D:\library_invoices_backups";
            return redirect()->back()->with(compact('successExportDbAlert'));

        } else {
            $failExportDbAlert = "حدثت مشكلة ! لم يتم استخراج قاعدة البيانات";
            return redirect()->back()->with(compact('failExportDbAlert'));
        }
    }

    public function importDB()
    {
        if (isset($_FILES['db'])) {
            $file = $_FILES['db'];
            $file_name = $_FILES['db']['name'];
            $file_type = $_FILES['db']['type'];
            $file_size = $_FILES['db']['size'];
            $file_temp = $_FILES['db']['tmp_name'];
            move_uploaded_file($file_temp, "$file_name");

            $servername = env('DB_HOST').':'.env('DB_PORT');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $dbname = env('DB_DATABASE');

            function restoreDatabaseTables($servername, $username, $password, $dbname, $filePath)
            {
                set_time_limit(600); //used to temporarily extend the time limit.
                // Temporary variable, used to store current query
                $templine = '';
                // Read in entire file
                $lines = file($filePath);
                $error = '';
                // Loop through each line
                foreach ($lines as $line) {
                    // Skip it if it's a comment
                    if (substr($line, 0, 2) == '--' || $line == '') {
                        continue;
                    }
                    // Add this line to the current segment
                    $templine .= $line;
                    // If it has a semicolon at the end, it's the end of the query
                    if (substr(trim($line), -1, 1) == ';') {
                        // Perform the query
                        //if (!$db->query($templine)) {
                        if (!DB::unprepared($templine)) {
                            $error .= 'Error performing query "<b>' . $templine . '</b>": ' . $db->error . '<br /><br />';
                        }
                        // Reset temp variable to empty
                        $templine = '';
                    }
                }
                return !empty($error) ? $error : true;
            }

            $filePath = $file_name;
            if (
                restoreDatabaseTables($servername, $username, $password, $dbname, $filePath)
                and $file_name != ""
            ) {
                unlink("$file_name");
                $successImportDbAlert = "تم استيراد قاعدة البيانات بنجاح";
                return redirect()->back()->with(compact('successImportDbAlert'));
            } else {
                $failImportDbAlert = "حدثت مشكلة ! لم يتم استيراد قاعدة البيانات";
                return redirect()->back()->with(compact('failImportDbAlert'));
            }
        }
    }

    public function dropDB()
    {
        // drop all the data from the database (no need for doctrine)
        DB::statement("SET foreign_key_checks=0");
        $databaseName = DB::getDatabaseName();
        $tables = DB::select("SELECT *  FROM information_schema.tables WHERE table_schema = '$databaseName'");
        foreach ($tables as $table) {
            $name = $table->TABLE_NAME;
            //if you don't want to truncate migrations, users
            if ($name == 'migrations' or $name == 'users') {
                continue;
            }
            DB::table($name)->truncate();
        }
        DB::statement("SET foreign_key_checks=1");

        $dropDbAlert = "تم حذف قاعدة البيانات بنجاح";
        return redirect()->back()->with(compact('dropDbAlert'));

    }
}
