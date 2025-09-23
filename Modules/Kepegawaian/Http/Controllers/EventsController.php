<?php

namespace Modules\Kepegawaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Kepegawaian\Entities\Event;


class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
            $events = Event::paginate(15);

        return view('kepegawaian.event.index', compact('events'));

    }
}