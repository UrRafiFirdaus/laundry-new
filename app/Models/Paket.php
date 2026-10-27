<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;
    protected $table = 'paket';
    protected $primaryKey = 'id_paket';
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
    public function detail()
    {
        return $this->hasMany(PaketDetail::class, 'id_paket', 'id_paket');
    }
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_paket', 'id_paket');
    }
    /*public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket', 'id_paket');
    }*/
    public function kategori() {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}
