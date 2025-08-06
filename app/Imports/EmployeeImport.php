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
use Mail;

class EmployeeImport implements ToModel, WithHeadingRow
{
    private $duplicateEntries = [];
    // Method to retrieve duplicate entries
    public function getDuplicateEntries()
    {
        return $this->duplicateEntries;
    }

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

         // Check if a user with this email already exists
         $existingUser = User::where('email', $row['email'])->where('deleted_at', null)->first();

         // Check if the email already exists in the database
        if ($existingUser) {
            // Store the duplicate entry with the ID and email
            $this->duplicateEntries[] = [
                'id' => $row['employee_id'],     // Assuming the ID is in the first column
                'email' => $row['email'],  // Assuming the email is in the second column
            ];
            return null; // Skip this row
        }

        // send email
        $maildata = [
            'title' => "Your account as a company employee has been created. You can now login to our website using the following credentials:",
            'subject' => "Your login Credentials",
            'link' => "sitara.my/login",
            'linktitle' => "Click here to Login",
            'name' => $row['last_name'],
            'email' => $employee_id,
            'sendemail' => $row['email'],
            'password' => $row['ic_number'],
        ];

        Mail::send('email.password.employeesend', $maildata, function ($message) use ($maildata) {
            $message->from('noreply.sitara@gmail.com', 'SITARA');
            $message->sender('noreply.sitara@gmail.com', 'SITARA');
            $message->to($maildata['sendemail'], $maildata['name']);
            $message->subject('Your login credentials');
            $message->priority(1);
        });

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
