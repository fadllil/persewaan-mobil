<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterMobil extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_merek',
        'id_model',
        'nama',
        'tahun',
        'no_plat',
        'tarif',
        'status'
    ];

    public function dataMerek()
    {
        return $this->belongsTo(MasterMerek::class, 'id_merek', 'id');
    }

    public function dataModel()
    {
        return $this->belongsTo(MasterModel::class, 'id_model', 'id');
    }
}
