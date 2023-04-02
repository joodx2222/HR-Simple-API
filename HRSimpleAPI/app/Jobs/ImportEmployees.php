<?php

namespace App\Jobs;

use App\Exports\EmployeesExport;
use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportEmployees implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $CSVFilePath;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($CSVFilePath)
    {
        $this->CSVFilePath = $CSVFilePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file = fopen($this->CSVFilePath, 'r');
        $row = null;
        $excludedHeaders = false;
        while($row = fgetcsv($file, 0 ,',')){
            if(!$excludedHeaders){
                $excludedHeaders = true;
                continue;
            }
            $newDBEmployee = new Employee();
            $newDBEmployee->name = $row[0];
            $newDBEmployee->age = $row[1];
            $newDBEmployee->gender = $row[2];
            $newDBEmployee->salary = $row[3];
            $newDBEmployee->hiredDate = $row[4];
            $newDBEmployee->jobTitle = $row[5];
            $newDBEmployee->save();
        }
    }
}
