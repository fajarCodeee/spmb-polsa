<?php

namespace App\Rules;

use Closure;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;

class Age implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $dateOfBirth = Carbon::parse($value);

        // Periksa jika usia kurang dari 17 tahun
        if ($dateOfBirth->diffInYears(now()) < 16) {
            $fail('Usia minimal harus 17 tahun.');
        }
    }
}
