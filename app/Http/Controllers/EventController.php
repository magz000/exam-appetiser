<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;

class EventController extends Controller
{
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'from' => 'required',
            'to' => 'required'
        ]);

        $event = new Event;
        $event->name = $request->name;
        $event->from = $request->from;
        $event->to = $request->to;
        $event->days_of_week = json_encode($request->daysOfWeek);
        $event->save();

        return response($event, 201);
    }
}
