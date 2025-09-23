<?php

namespace Modules\Kepegawaian\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Modules\Sindikat\Entities\EvaluasiPeserta;

class ProfilPegawai extends Model
{
    use HasFactory;

    use HasUuids;
    protected $table = 'profil_pegawai';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $connection = 'mysql';

    protected $fillable = [
                            'id','nip_nipppk_nrpk_nrpblud', 'nip_lama', 'nip_baru', 'nama', 'gelar_depan', 'gelar_belakang', 'foto', 'nik', 'no_kk','npwp', 
                            'no_str', 'agama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'status_pegawai', 'status_kepegawaian','tmt_rsud','no_bpjs_kis', 'kelas_bpjs', 
                            'status_kawin', 'alamat', 'rt', 'rw', 'kelurahan_desa', 'kecamatan', 'kota', 'kode_pos', 'telp', 'no_hp', 'email', 'gol_darah', 
                            'taspen', 'angka_kredit', 'kebangsaan', 'tunjangan', 'motto'];
    
    protected static function newFactory()
    {
        return \Modules\Kepegawaian\Database\factories\ProfilPegawaiFactory::new();
    }

    //Cek Riwayat Kerja Pegawai
    public function riwayat_jabatan_unit() 
    {
        return $this->hasMany(RiwayatJabatanUnit::class, "pegawai_id");
    }

    public function riwayat_jabatan() 
    {
        return $this->hasMany(RiwayatJabatan::class, "pegawai_id");
    }
    public function riwayat_golongan() 
    {
        return $this->hasMany(RiwayatGolongan::class, "pegawai_id");
    }
    public function riwayat_pendidikan() 
    {
        return $this->hasMany(RiwayatPendidikan::class, "pegawai_id")->join('jenjang_pendidikan', 'riwayat_pendidikan.jenjang_pendidikan_id', '=', 'jenjang_pendidikan.id')->orderBy('tanggal_lulus', 'DESC');
    }
    public function riwayat_diklat() 
    {
        return $this->hasMany(RiwayatDiklat::class, "pegawai_id")->orderBy('tahun_diklat', 'DESC');
    }
    public function riwayat_artikel() 
    {
        return $this->hasMany(RiwayatArtikel::class, "pegawai_id");
    }

    public function riwayat_inovasi() 
    {
        return $this->hasMany(RiwayatInovasi::class, "pegawai_id")->orderBy('tahun', 'DESC');
    }

    public function riwayat_karya_buku() 
    {
        return $this->hasMany(RiwayatKaryaBuku::class, "pegawai_id");
    }


    public function riwayat_pekerjaan() 
    {
        return $this->hasMany(RiwayatPekerjaan::class, "pegawai_id")->orderBy('tahun_mulai', 'DESC');
    }

    public function riwayat_organisasi() 
    {
        return $this->hasMany(RiwayatOrganisasi::class, "pegawai_id")->orderBy('tahun_selesai', 'DESC');
    }

    public function instruktur_klinik() 
    {
        return $this->hasMany(PegawaiCI::class, "pegawai_id");
    }

    public function pasangan_hidup() 
    {
        return $this->hasMany(PasanganPegawai::class, "pegawai_id");
    }

    public function anak_pegawai() 
    {
        return $this->hasMany(AnakPegawai::class, "pegawai_id");
    }

    public function dokumen_pegawai() 
    {
        return $this->hasMany(DokumenPegawai::class, "pegawai_id");
    }

    public function kontrak_kerja() 
    {
        return $this->hasMany(RiwayatKontrakKerja::class, "pegawai_id");
    }

    public function evaluasi_peserta() 
    {
        return $this->hasMany(EvaluasiPeserta::class, "pegawai_id");
    }

    //Cek Status Kerja Pegawai Saat ini
    public function unit_jabatan_aktif(){
        return $this->hasOne(RiwayatJabatanUnit::class, 'pegawai_id')
        ->join('unit', 'unit_jabatan_pegawai.unit_id', '=', 'unit.id')
        ->join('jabatan_unit', 'unit_jabatan_pegawai.jabatan_unit_id', '=', 'jabatan_unit.id')
        ->where('is_jabatan_terakhir', 1)
        ->select(['unit_jabatan_pegawai.*', 'unit.nama as nama_unit', 'jabatan_unit.nama as nama_jabatan_unit']);
    }

    public function golongan_aktif(){
        return $this->hasOne(RiwayatGolongan::class, 'pegawai_id')
        ->join('golongan', 'riwayat_golongan.golongan_id', '=', 'golongan.id')
        ->where('is_golongan_terakhir', 1);
    }

    public function awal_kerja(){
        return $this->hasOne(RiwayatJabatan::class, "pegawai_id")
        ->orderBy('tmt_jabatan','ASC')
        ->select(['riwayat_jabatan.*']);
    }
    public function jabatan_aktif(){
        return $this->hasOne(RiwayatJabatan::class, "pegawai_id")
        ->join('jabatan', 'riwayat_jabatan.jabatan_id', '=', 'jabatan.id')
        ->where('is_jabatan_terakhir', 1)
        ->select(['riwayat_jabatan.*', 'jabatan.nama as nama_jabatan']);
    }

    public function pendidikan_terakhir(){
        return $this->hasOne(RiwayatPendidikan::class, "pegawai_id")
        ->join('jenjang_pendidikan', 'riwayat_pendidikan.jenjang_pendidikan_id', '=', 'jenjang_pendidikan.id')
        ->where('is_pendidikan_terakhir', 1);
    }  

    public function pegawai_active(){
        return $this->where('status_pegawai', 0);
    }
    public function pegawai_inactive(){
        return $this->where('status_pegawai', !0);

    }
     
}
