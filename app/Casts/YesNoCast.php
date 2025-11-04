<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * Cast ini akan mengubah nilai boolean (true/1/false/0)
 * menjadi 'Y' atau 'N' saat menyimpan ke database,
 * dan mengubah 'Y'/'N' dari database menjadi true/false
 * saat dibaca oleh aplikasi.
 */
class YesNoCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): bool
    {
        // Mengubah 'Y' dari DB menjadi true, selain itu false
        return $value === 'Y';
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        // Mengubah true/1/'true' menjadi 'Y', selain itu 'N'
        return $value ? 'Y' : 'N';
    }
}