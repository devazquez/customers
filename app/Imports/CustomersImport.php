<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;  
use Illuminate\Validation\Validator;
use App\Rules\UniqueCustomerId;



class CustomersImport implements ToModel, WithHeadingRow,  WithValidation
{
    public function model(array $row)
    {
        //dd($row);
        
        return new Customer([
            'customer_id'        => $row['customer_id'],
            'first_name'         => $row['first_name'],
            'last_name'          => $row['last_name'],
            'company'            => $row['company'],
            'city'               => $row['city'],
            'country'            => $row['country'],
            'phone_1'            => $row['phone_1'],
            'phone_2'            => $row['phone_2'],
            'email'              => $row['email'],
            'subscription_date'  => $row['subscription_date'],
            'website'            => $row['website'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.customer_id' => ['required', new UniqueCustomerId],
            // ... otras reglas de validación para las demás columnas si es necesario
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'        
        ]);

        Excel::import(new CustomersImport, $request->file('file'));
        return redirect()->back()->with('success', '¡Importación completada!');
    }
}
