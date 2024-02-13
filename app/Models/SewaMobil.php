<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SewaMobil extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
        'id_user',
        'id_mobil',
        'no_plat',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_hari',
        'status',
        'tarif',
        'total',
    ];

    public function dataUser()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    public function dataMobil()
    {
        return $this->hasOne(MasterMobil::class, 'id', 'id_mobil');
    }
}
