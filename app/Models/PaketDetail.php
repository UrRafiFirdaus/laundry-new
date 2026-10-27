<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketDetail extends Model
{
    use HasFactory;
    protected $table = 'paket_detail';
    protected $primaryKey = 'id_paket_detail';
    protected $guarded = [];

    public function kategori() {
        return $this -> hasOne(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function customer() {
        return $this -> hasOne(Customer::class, 'id_customer', 'id_customer');
    }
    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket');
    }
    

}



