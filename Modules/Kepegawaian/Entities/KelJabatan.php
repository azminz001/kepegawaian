<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KelJabatan extends Model
{
    use HasFactory;

    protected $table = 'kel_jabatan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['nama'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\KelJabatanFactory::new();
    }

    public function riwayat_jabatan() 
    {
        return $this->hasMany(RiwayatJabatan::class, "kel_jabatan_id");
    }

    public function pegawai_aktif()
    {
        return $this->hasMany(RiwayatJabatan::class, "kel_jabatan_id")
                    ->join('profil_pegawai', 'riwayat_jabatan.pegawai_id', '=', 'profil_pegawai.id')
                    ->join('jabatan', 'riwayat_jabatan.jabatan_id', '=', 'jabatan.id')
                    ->join('unit_jabatan_pegawai', 'profil_pegawai.id', '=', 'unit_jabatan_pegawai.pegawai_id')
                    ->join('jabatan_unit', 'unit_jabatan_pegawai.jabatan_unit_id', '=', 'jabatan_unit.id')
                    ->join('unit', 'unit_jabatan_pegawai.unit_id', '=', 'unit.id')
                    ->where('riwayat_jabatan.is_jabatan_terakhir', 1)
                    ->where('unit_jabatan_pegawai.is_jabatan_terakhir', 1)
                    ->select([
                        'profil_pegawai.id as pegawai_id',
                        'profil_pegawai.nama as nama_pegawai', 
                        'profil_pegawai.nip_nipppk_nrpk_nrpblud', 
                        'profil_pegawai.foto', 
                        'profil_pegawai.status_kepegawaian', 
                        'profil_pegawai.email', 
                        'profil_pegawai.no_hp', 
                        'profil_pegawai.gelar_depan', 
                        'profil_pegawai.gelar_belakang', 
                        'jabatan.nama as nama_jabatan', 
                        'unit.nama as nama_unit', 
                        'jabatan_unit.nama as nama_jabatan_unit',
                        'riwayat_jabatan.*'  // Pastikan kolom dari tabel riwayat_jabatan juga disertakan
                    ]);
    }

    public function pegawai_aktif_dashboard()
    {
        return $this->hasMany(RiwayatJabatan::class, "kel_jabatan_id")
                    ->join('profil_pegawai', 'riwayat_jabatan.pegawai_id', '=', 'profil_pegawai.id')
                    ->join('jabatan', 'riwayat_jabatan.jabatan_id', '=', 'jabatan.id')
                    ->join('jabatan_unit', 'unit_jabatan_pegawai.jabatan_unit_id', '=', 'jabatan_unit.id')
                    ->join('unit', 'unit_jabatan_pegawai.unit_id', '=', 'unit.id')
                    ->where('riwayat_jabatan.is_jabatan_terakhir', 1)
                    ->select([
                        'profil_pegawai.id as pegawai_id',
                        'profil_pegawai.nama as nama_pegawai', 
                        'profil_pegawai.nip_nipppk_nrpk_nrpblud', 
                        'profil_pegawai.foto', 
                        'profil_pegawai.status_kepegawaian', 
                        'profil_pegawai.email', 
                        'profil_pegawai.no_hp', 
                        'profil_pegawai.gelar_depan', 
                        'profil_pegawai.gelar_belakang', 
                        'jabatan.nama as nama_jabatan', 
                        'riwayat_jabatan.*'  // Pastikan kolom dari tabel riwayat_jabatan juga disertakan
                    ]);
    }
}
