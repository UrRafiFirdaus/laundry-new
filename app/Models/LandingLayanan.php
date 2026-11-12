<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingLayanan extends Model
{
    protected $table = 'landing_layanan';
    protected $guarded = [];
    protected $casts = ['aktif' => 'boolean'];

    public function scopeTampil($q) {
        return $q->where('aktif', true)-> orderBy('urutan')->orderBy('id');   
    }
}
