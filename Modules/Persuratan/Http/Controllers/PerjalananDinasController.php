<?php

namespace Modules\Persuratan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Database\QueryException;

use Modules\Persuratan\Entities\Perjadin;


class PerjalananDinasController extends Controller
{
    public function index()
    {
        
        return view('Persuratan::perjalanan_dinas.index');
    }
}
