<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ReservationEmail;
use App\Models\Reservation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        //$this->middleware('auth:api');
    }

    public function index()
    {
        return Reservation::latest()->paginate(50);
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
            'regular_seats' => 'required',
            'vip_seats' => 'required',
        ]);
        if (($request['regular_seats'] + $request['vip_seats']) > 5) {
            $content = array(
                'success' => false,
                'data' => "An error occurred",
                'message' => "Given data was invalid",
                "errors" => ["max_tickets" => ["You can only purchase maximum of 5 tickets."]]
            );
            return response($content)->setStatusCode(422);
        } else {

            try {
                Reservation::create([
                    'user_id' => $request['user_id'],
                    'event_id' => $request['event_id'],
                    'event_name' => $request['event_name'],
                    'venue_name' => $request['venue_name'],
                    'regular_seats' => $request['regular_seats'],
                    'vip_seats' => $request['vip_seats'],
                    'event_date' => $request['event_date'],
                ]);

                $emailAddress = DB::table('users')
                    ->select('email')
                    ->where('id', $request['user_id'])
                    ->get();

                //Send email
                $toEmail    =   $emailAddress;
                $data       =   array(
                    "message"    =>   "Reservation made successfully."
                );
                // pass dynamic message to mail class
                Mail::to($toEmail)->send(new ReservationEmail($data));
                if (Mail::failures() != 0) {
                    return new JsonResponse(
                        [
                            'success' => true,
                            'message' => "E-mail sent successfully!"
                        ],
                        200
                    );
                } else {
                    return new JsonResponse(
                        [
                            'success' => false,
                            'message' => "E-mail not sent!"
                        ],
                        422
                    );
                }
            } catch (Exception $e) {
                return new JsonResponse(
                    [
                        'success' => false,
                        'message' => "An error occurred!"
                    ],
                    422
                );
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return DB::table('reservations')
            ->select('*')
            ->where('user_id', $id)
            ->paginate(50);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
