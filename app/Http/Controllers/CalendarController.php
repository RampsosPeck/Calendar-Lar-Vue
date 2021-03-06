<?php

namespace Calendarlarvue\Http\Controllers;

use Calendarlarvue\Calendar;
use Calendarlarvue\Http\Resources\CalendarResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CalendarResource::collection(Calendar::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 

        $new_calendar = Calendar::create($request->all());

        return response()->json([
            'data' => new CalendarResource($new_calendar),
            'message' => 'El nuevo evento fue creado correctamente!',
            'status' => Response::HTTP_CREATED
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \Calendarlarvue\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function show(Calendar $calendar)
    {
        return response($calendar, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Calendarlarvue\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendar $calendar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Calendarlarvue\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calendar $calendar)
    {
        $calendar->update($request->all());
        return response()->json([
            'data' => new CalendarResource($calendar),
            'message' => 'El evento fue editado correctamente!',
            'status' => Response::HTTP_ACCEPTED
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Calendarlarvue\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calendar $calendar)
    {
        $calendar->delete();
        return response('El evento fue eliminado correctamente!', Response::HTTP_NO_CONTENT);
    }
}
