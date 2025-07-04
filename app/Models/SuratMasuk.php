<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';

    protected $primaryKey = 'id_surat_masuk';

    public $timestamps = false;

    protected $fillable = [
        'no_surat_masuk',
        'tanggal_masuk',
        'pengirim',
        'file',
        'jenis_surat_id',
    ];

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }
}
