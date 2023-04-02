<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeesExport implements FromCollection
{

    public function collection()
    {
        $dbEmployees = Employee::with(['manager'])->get()->toArray();
        $headers = [
            'name',
            'age',
            'salary',
            'gender',
            'hired date',
            'job title',
            'manager'
        ];
        $data = [];
        array_push($data, $headers);

        foreach($dbEmployees as $employee){
            array_push($data, [
                $employee['name'],
                $employee['age'],
                $employee['gender'],
                $employee['salary'].'$',
                $employee['hiredDate'],
                $employee['jobTitle'],
                $employee['manager']?$employee['manager']['name']:'',
            ]);
        }
        return new Collection($data);
    }
}
