<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\ReservaCalendarResource;
use App\Models\Cliente;
use App\Models\ReservaStatus;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // reservas do mês atual
        $reservas = Reserva::where('começo', '>=', now()->startOfMonth())->where('fim', '<=', now()->endOfMonth())->get();
        return Inertia::render('Dashboard', ['reservas' => ReservaCalendarResource::collection($reservas)->resolve()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->query('data');
        if ($data) {
            $dataSelecionada = Carbon::parse($data)->format('Y-m-d\TH:i');
        }

        return Inertia::render('Reservas/Create', [
            "dataSelecionada" => $dataSelecionada ?? '',
            "clientes" => Cliente::all(),
            "statuses" => ReservaStatus::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        $reserva->loadMissing(['cliente', 'status']);
        return Inertia::render('Reservas/Show', ['reserva' => $reserva]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserva $reserva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        //
    }
}
