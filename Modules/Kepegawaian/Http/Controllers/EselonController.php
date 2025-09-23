<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Kepegawaian\Entities\Eselon;


class EselonController extends Controller
{
    public function getEselons()
    {
        $eselon = Eselon::all();
        return response()->json($eselon);
    }
}
