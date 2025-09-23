<?php

// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

use Modules\Kepegawaian\Entities\ProfilPegawai;
use Modules\Sindikat\Entities\Institusi;
use Modules\Kepegawaian\Entities\Users;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            'captcha' => 'required|captcha'
        ], [
            'captcha.captcha' => 'Captcha tidak sesuai. Ulangi lagi.'
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            // Authentication passed...
            $user = Auth::user();
        
            // dd($user);
            if ($user->level == 0 || $user->level == 1) {
                return redirect(route('kepegawaian.dashboard'));
            } 
            elseif ($user->level == 2) {
                return redirect(route('pegawai.profil'));
            }
            elseif ($user->level == 3) {
            // dd($user);
                return redirect(route('persuratan.klasifikasi.index'));
            }
            elseif ($user->level == 4) {
                return redirect(route('sindikat.kategori.index'));
            }
            elseif ($user->level == 5) {
                $email = $user->email;
                $institusi = Institusi::where('email', $email)->first();
                // dd($institusi);
                return  redirect()->route('sindikat.institusi.show', $institusi->id);
            }
            elseif ($user->level == 7) {
                return redirect(route('karir.data_sanggah'));
            }
        }

        return redirect()->back()->withErrors(['Mohon Maaf! Username atau Password tidak sesuai.']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username|regex:/^[a-zA-Z0-9_]+$/',
            'password' => 'required|min:8',
            'captcha' => 'required|captcha'
        ], [
            'username.unique' => 'Nomor Induk sudah terdaftar, silahkan hubungi admin',
            'captcha.captcha' => 'Captcha tidak sesuai. Ulangi lagi.'
        ]);

        // $key = 'register-attempts:' . $request->ip();

        // if (RateLimiter::tooManyAttempts($key, 3)) {
        //     return response()->json(['message' => 'Kamu terlalu banyak melakukan pendaftaran. Coba daftar lagi nanti ya atau gunakan perangkat lain dengan jaringan internet di luar jaringan RSUD Brebes.'], 429);
        // }

        // RateLimiter::hit($key, 60);

        try{
            Users::create([
                'name'  => strtoupper($request->nama),
                'email' => $request->nip_nipppk_nrpk_nrpblud."@rsudbrebes.go.id",
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'level' => '2'
            ]);

            ProfilPegawai::create([
                'status_kepegawaian'      => $request->status_kepegawaian,
                'nip_nipppk_nrpk_nrpblud' => $request->username,
                'nama'                    => strtoupper($request->nama),
                'gelar_depan'             => $request->gelar_depan, 
                'gelar_belakang'          => $request->gelar_belakang,   
                'status_pegawai'          => '1'
            ]);
    
            return redirect()->back()->with('success', 'Pendaftaran Berhasil, Silahkan Login.');
            // dd($request);
            
        }catch (QueryException $e) {
            return redirect()->back()->withErrors('Proses pendaftaran gagal, hubungi admin.');
        
        }


    }

    public function register_institusi(Request $request)
    {

        // dd($request);
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,username',
        ], [
            'email.unique' => 'Email sudah terdaftar, silahkan hubungi admin',
        ]);

        try{
            Users::create([
                'name'  => strtoupper($request->nama),
                'email' => $request->email,
                'username' => $request->email,
                'password' => Hash::make($request->password),
                'level' => '5'
            ]);

            Institusi::create([
                'nama'                    => strtoupper($request->nama),
                'level'                   => $request->level, 
                'akreditasi'              => $request->akreditasi,   
                'nama_pimpinan'           => $request->nama_pimpinan,
                'telp'                    => $request->telp,
                'email'                   => $request->email,
                'alamat'                  => $request->alamat,
                'kota'                    => $request->kota,
                'provinsi'                => $request->provinsi,
                'status'                  => 0
            ]);
    
            return redirect()->route('login.sindikat')->with('success', 'Pendaftaran Berhasil, Silahkan Login.');
            // dd($request);
            
        }catch (QueryException $e) {
            return redirect()->back()->withErrors('Proses pendaftaran gagal, hubungi admin.');
        
        }


    }


    public function logout()
    {
        Auth::logout();

        return redirect(route('kepegawaian.login'));
    }

    public function logout_sindikat()
    {
        Auth::logout();

        return redirect(route('sindikat.landing'));
    }

}
