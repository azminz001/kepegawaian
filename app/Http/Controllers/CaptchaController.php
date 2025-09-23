<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mews\Captcha\Facades\Captcha;

class CaptchaController extends Controller
{
    public function generate()
    {
        return Captcha::create('default');
    }
    public function generate_login()
    {
        return Captcha::create('login');
    }


    public function refresh()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}