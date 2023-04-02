<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use App\Jobs\ImportEmployees;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class EmployeesController extends Controller
{
    public function searchEmployees(Request $request)
    {
        $q = $request->q;
        $dbUser = $request->dbUser;
        if (!isset($q)) return $this->sendValidationError('q Parameter must exist');

        $dbEmployees = Employee::where('name', 'like', "%$q%")->get();
        $this->createUserLog($dbUser->id, "User $dbUser->name that has Id $dbUser->id searched the employees with query ($q)");
        return response()->json($dbEmployees);
    }

    public function single($id, Request $request)
    {
        $dbEmployee = Employee::find($id);
        $dbUser = $request->dbUser;
        $this->createUserLog($dbUser->id, "User $dbUser->name that has Id $dbUser->id accessed the employee $dbEmployee->name that has Id $dbEmployee->id");
        return response()->json($dbEmployee);
    }

    public function employeeManagers($id, Request $request)
    {
        $dbEmployee = Employee::find($id);
        $dbUser = $request->dbUser;
        $this->createUserLog($dbUser->id, "User $dbUser->name that has Id $dbUser->id accessed the employee's managers $dbEmployee->name that has Id $dbEmployee->id");
        return response()->json($this->getEmployeeManagersNames($dbEmployee));
    }

    public function employeeManagersWithSalaries($id, Request $request)
    {
        $dbEmployee = Employee::find($id);
        $dbUser = $request->dbUser;
        $this->createUserLog($dbUser->id, "User $dbUser->name that has Id $dbUser->id accessed the employee's managers with salaries $dbEmployee->name that has Id $dbEmployee->id");
        return response()->json($this->getEmployeeManagersNamesWithSalaries($dbEmployee));
    }

    public function exportEmployees(Request $request)
    {
        $dbUser = $request->dbUser;
        $this->createUserLog($dbUser->id, "User $dbUser->name that has Id $dbUser->id exported employees as CSV");
        return Excel::download(new EmployeesExport(), 'employees.csv');
    }

    public function importEmployees(Request $request)
    {
        $CSVFile = $request->file('CSVFile');
        if ($CSVFile) {
            $CSVFileFullPath = $CSVFile->store('export');
            ImportEmployees::dispatch(storage_path('app/'.$CSVFileFullPath));
            $dbUser = $request->dbUser;
            $this->createUserLog($dbUser->id, "User $dbUser->name that has Id $dbUser->id imported employees from CSV file");
            return $CSVFileFullPath;
        } else {
            return $this->sendValidationError('CSVFile is required');
        }
    }

    public function getEmployeeManagersNames($dbEmployee)
    {
        $managers = [];
        $currentEmployee = $dbEmployee;
        array_unshift($managers, $currentEmployee->name);

        while ($currentEmployee = $currentEmployee->manager) {
            array_unshift($managers, $currentEmployee->name);
        }

        return implode(' - ', $managers);
    }

    public function getEmployeeManagersNamesWithSalaries($dbEmployee)
    {
        $managersWithSalaries = (object)[];
        $currentEmployee = $dbEmployee;
        $managersWithSalaries->{$currentEmployee->name} = $currentEmployee->salary . '$';

        while ($currentEmployee = $currentEmployee->manager) {
            $managersWithSalaries->{$currentEmployee->name} = $currentEmployee->salary . '$';
        }

        return $managersWithSalaries;
    }
}
