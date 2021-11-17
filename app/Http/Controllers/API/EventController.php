<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return Event::latest()->paginate(50);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'event_name' => 'required|unique:events',
            'venue_name' => 'required',
            'max_attendees' => 'required',
            'regular_price' => 'required',
            'vip_price' => 'required',
            'event_date' => 'required',
        ]);
        return Event::create([
            'event_name' => $request['event_name'],
            'venue_name' => $request['venue_name'],
            'max_attendees' => $request['max_attendees'],
            'regular_price' => $request['regular_price'],
            'vip_price' => $request['vip_price'],
            'event_date' => $request['event_date'],
            'remaining_tickets' => $request['max_attendees'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');

        $event = Event::findOrFail($id);
        $this->validate($request, [
            'event_name' => 'required|unique:events,event_name,' . $event->id,
            'venue_name' => 'required',
            'max_attendees' => 'required',
            'regular_price' => 'required',
            'vip_price' => 'required',
            'event_date' => 'required',
        ]);

        $event->update($request->all());

        return ['message' => 'UPdta'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $event = Event::findOrFail($id);
        $event->delete();

        return ['message' => 'Event deleted'];
    }
}
