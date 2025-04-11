<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EventoController extends Controller
{
    public function index(){        
        return view('admin.eventos.eventos');
    }

    public function allEventos(){
        $hoy = Carbon::today();
        $eventos = Evento::where('fecha', '>=', $hoy)
                     ->orderBy('fecha', 'asc')
                     ->get();
        return response()->json($eventos);
    }

    public function show($id)
    {
        $evento = Evento::find($id);
        if (!$evento) return response()->json(['error' => 'No encontrado'], 404);
        return response()->json($evento);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required',
            'lugar_evento' => 'required|string|max:255',
            'long_lat' => 'nullable|string',
            'fecha' => 'required|date',
            'img_evento' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('img_evento')) {
            $path = $request->file('img_evento')->store('eventos', 'public');
        }

        $evento = Evento::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'lugar_evento' => $request->lugar_evento,
            'long_lat' => $request->long_lat,
            'fecha' => $request->fecha,
            'img_evento' => $path,
        ]);

        return response()->json(['message' => 'Evento creado', 'evento' => $evento]);
    }

    public function update(Request $request, $id)
    {
        $evento = Evento::find($id);
        if (!$evento) return response()->json(['error' => 'Evento no encontrado'], 404);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required',
            'lugar_evento' => 'required|string|max:255',
            'long_lat' => 'nullable|string',
            'fecha' => 'required|date',
            'img_evento' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('img_evento')) {
            if ($evento->img_evento) {
                Storage::disk('public')->delete($evento->img_evento);
            }
            $evento->img_evento = $request->file('img_evento')->store('eventos', 'public');
        }

        $evento->update($request->except('img_evento'));
        return response()->json(['message' => 'Evento actualizado', 'evento' => $evento]);
    }

    public function destroy($id)
    {
        $evento = Evento::find($id);
        if (!$evento) return response()->json(['error' => 'No encontrado'], 404);
        $evento->delete();
        return response()->json(['message' => 'Evento eliminado (soft delete)']);
    }
}
