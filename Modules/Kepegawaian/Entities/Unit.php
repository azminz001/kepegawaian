<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Sindikat\Entities\JadwalPesertaDidik;


class Unit extends Model
{
    use HasFactory;

    protected $table = 'unit';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['nama','keterangan'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\UnitFactory::new();
    }

    public function unit_jabatan_pegawai() 
    {
        return $this->hasMany(RiwayatJabatanUnit::class, "unit_id")
                    ->where('unit_jabatan_pegawai.is_jabatan_terakhir', 1)
                    ->where('riwayat_jabatan.is_jabatan_terakhir', 1)
                    ->join('profil_pegawai', 'unit_jabatan_pegawai.pegawai_id', '=', 'profil_pegawai.id')
                    ->join('riwayat_jabatan', 'profil_pegawai.id', '=', 'riwayat_jabatan.pegawai_id');
    }
    public function pegawai_aktif()
    {
        return $this->hasMany(RiwayatJabatanUnit::class, "unit_id")
                    ->where('unit_jabatan_pegawai.is_jabatan_terakhir', 1)
                    ->where('riwayat_jabatan.is_jabatan_terakhir', 1)
                    ->join('profil_pegawai', 'unit_jabatan_pegawai.pegawai_id', '=', 'profil_pegawai.id')
                    ->join('riwayat_jabatan', 'profil_pegawai.id', '=', 'riwayat_jabatan.pegawai_id')
                    ->join('jabatan', 'riwayat_jabatan.jabatan_id', '=', 'jabatan.id')
                    ->join('kel_jabatan', 'riwayat_jabatan.kel_jabatan_id', '=', 'kel_jabatan.id')
                    ->join('jabatan_unit', 'unit_jabatan_pegawai.jabatan_unit_id', '=', 'jabatan_unit.id')
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
                        'kel_jabatan.nama as nama_kel_jabatan',
                        'jabatan_unit.nama as nama_jabatan_unit',
                        'unit_jabatan_pegawai.is_jabatan_terakhir',
                        'riwayat_jabatan.is_jabatan_terakhir'
                    ]);
    }

    /**
     * Get all of the comments for the Unit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jadwal_pesertadidik()
    {
        return $this->hasMany(JadwalPesertaDidik::class, 'unit_id');
    }
    
}
