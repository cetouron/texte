<?php

namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Http\Resources\Form\CalendarResource;
use App\Models\Form\Calendar;
use Illuminate\Support\Facades\Log;

class CalendarController extends Controller
{
    public function index()
    {
        return view('form.index');
    }

    public function indexApi()
    {
        $calendar = '[{"id":1,"title":"test","start":"2021-12-17 12:00:00","end":"2021-12-17 13:00:00","allDay":1,"resource":"B","reserve":1,"color":"red","created_at":null,"updated_at":null}]';
        return $calendar; //CalendarResource::collection($calendar); //->paginate(5)
    }

    public function show(Calendar $cours) //Chercher  news
    {
        return new CalendarResource($cours);
    }

    public function store()
    {
        Log::info($this);
        $new = Calendar::create($this->validateCours());

        return $new;
    }

    public function update(Calendar $cours) //Mettre à jour une news
    {
        $cour=$cours;
        $cours->update($this->validateCours());

        return $cour;
    }

    public function destroy(Calendar $cours) //effacer 1 news
    {
        $cours->delete();

        return response()->noContent();
    }

    protected function validateCours()
    {
        return request()->validate([
            'title'=>'required|max:25',
            'start'=>'required',
            'end'=>'sometimes',
            'allDay'=>'sometimes',
            'resource'=>'sometimes',
            'reserve'=>'sometimes',
            'color'=>'sometimes',
        ]);
    }
}
