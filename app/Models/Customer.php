<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    protected $primaryKey = 'id_customer';
    protected $guarded = [];


    public static function generateKode(): string {
        $next = (int) static::max('id_customer') + 1;

        do {
            $kode = 'CS' . tambah_nol_didepan($next, 6);
            $next++;
        } while (static::where('kode_customer', $kode)->exists());

        return $kode;
    }
}
