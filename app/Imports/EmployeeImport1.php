<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Validator;

class EmployeeImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $employee_id = $row['employee_id'];
        $company = Auth::user();

        if (str_starts_with($employee_id, $company->id . '-')) {
            $employee_id = $row['employee_id'];
        } else {
            $employee_id = $company->id . '-' . $employee_id;
        }

        Validator::make($row, [
            '*.employee_id' => 'unique:App\Models\User,employee_id',
        ])->validate();

        return new User([
            'employee_id' => $employee_id,
            'company_id' => $company->id,
            'first_name' => $row['first_name'],
            'middle_name' => $row['middle_name'],
            'last_name' => $row['last_name'],
            'post' => $row['post'],
            'date_of_birth' => Date::excelToDateTimeObject($row['date_of_birth'])->format('Y-m-d'),
            'gender' => $row['gender'],
            'race' => $row['race'],
            'ic_number' => $row['ic_number'],
            'password' => Hash::make($row['ic_number']),
            'email' => $row['email'],
            'phone_number' => $row['phone_number'],
            'address' => $row['address'],
            'per_visit_claim' => $row['per_visit_claim'],
            'email_verified_at' => Carbon::now(),
        ]);
    }
}
