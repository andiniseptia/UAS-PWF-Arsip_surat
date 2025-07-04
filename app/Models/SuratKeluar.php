<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';

    protected $primaryKey = 'id_surat_keluar';

    public $timestamps = false;

    protected $fillable = [
        'no_surat_keluar',
        'tanggal_keluar',
        'tujuan',
        'file',
        'jenis_surat_id',
    ];

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }
}
