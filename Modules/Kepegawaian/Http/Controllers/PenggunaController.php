<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Modules\Kepegawaian\Entities\Users;


class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $cari = request('cari');
        if(!empty($cari)){
            $users = Users::where(function($query) use ($cari) {
                $query->where('username', 'like', "%".$cari."%")
                    ->orWhere('name', 'like', "%".$cari."%");
            })
            ->latest()
            ->paginate(100);
            $user_count = Users::where('username', 'like',"%".$cari."%")->count();
        }else{
            if (Auth::user()->level == 0) {
                $users = Users::latest()->paginate(15);
                $user_count = Users::count();

            }else if (Auth::user()->level == 1) {
                $users = Users::where('level', '2')->latest()->paginate(15);
                $user_count = Users::where('level', '2')->count();

            }
            
        }

        return view('kepegawaian.pengguna.index', compact('users', 'user_count'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('kepegawaian::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'level' => 'required|in:0,1,2,3,4,5,6,7,8',
        ], [
            'username.unique' => 'Username sudah terdaftar, silahkan hubungi admin',
            'email.unique' => 'Email sudah terdaftar, silahkan hubungi admin'
        ]);
        
        try{
            // dd($request);
            Users::create([
                'name' => strtoupper($request->name),
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make('123456'),
                'level' => $request->level,
            ]);
    
            return redirect()->back()->with('success', 'Data berhasil disimpan.');
            
        }catch (QueryException $e) {
            return redirect()->back()->with('error', 'Data Gagal disimpan.');
        
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('kepegawaian::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $user = Users::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        // dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);
        
        $user = Users::findOrFail($id);

        $user->update([
            'username' => $request->username,
            'name' => strtoupper($request->name),
            'email' => $request->email,
            'level' => $request->level ?? $user->level,
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }
    public function reset_password(Request $request, $id)
    {
        $user = Users::findOrFail($id);
        // dd($request);

        $user->update([
            'password' => Hash::make('123456'),
        ]);

        return redirect()->back()->with('success', 'Password User berhasil direset');
    }


    public function ubah_password(Request $request, $id)
    {
        $user = Users::findOrFail($id);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', 'Password Baru berhasil diganti');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $user = Users::find($id);
        
        if ($user) {
            $user->delete();

            return redirect()->back()->with('success', 'Akun Pengguna berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Akun Pengguna tidak ditemukan.');
        }
    }

}
