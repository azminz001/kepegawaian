<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatPendidikan extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'riwayat_pendidikan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    //tambah kolom baru Jurusan
    protected $fillable = ['id', 'nomor_ijazah', 'tanggal_lulus', 'tahun_lulus', 'gelar_depan', 'gelar_belakang', 'nama_sekolah_pt', 'jurusan','kepala', 'dokumen_ijazah', 'dokumen_nilai', 'is_pendidikan_terakhir', 'jenjang_pendidikan_id','pegawai_id'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\RiwayatPendidikanFactory::new();
    }


    public function pegawai() 
    {
        return $this->belongsTo(ProfilPegawai::class, "pegawai_id");
    }

    public function jenjang_pendidikan() 
    {
        return $this->belongsTo(JenjangPendidikan::class, "jenjang_pendidikan_id");
    }
}
