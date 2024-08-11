<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Customer;

class UniqueCustomerId implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Verificar si el customer_id ya existe en la base de datos
        return !Customer::where('customer_id', $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El :customer_id ya existe en la base de datos. Verifica que tu documento no tenga ids repetidos';
    }
}