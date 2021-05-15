<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class ContactsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return Contact|null
     */
    public function model(array $row)
    {
        return new Customer([
        'name'   => $row['name'],
        'email'  => $row['email'],
        'password'=>\Hash::make($row['password']) 
        ]);
    }
}

