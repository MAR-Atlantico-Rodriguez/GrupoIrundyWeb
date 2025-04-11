<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function home(){
        $eventos = $this->allEventos();

        return view('home', compact('eventos'));
    }

    public function biografia(){
        $eventos = $this->allEventos();
        return view('biografia', compact('eventos'));
    }

    private function allEventos(){
        $hoy = Carbon::today();
        $eventos = Evento::where('fecha', '>=', $hoy)
                     ->orderBy('fecha', 'asc')
                     ->get();
        return $eventos;
    }

  
}
