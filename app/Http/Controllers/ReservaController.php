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
    public function index(Request $request)
    {
        $validated = $request->validate([
            'mesTexto' => ['nullable', 'date_format:Y-m'],
        ]);

        $mesTexto = $validated['mesTexto'] ?? now()->format('Y-m');

        $data = Carbon::createFromFormat('!Y-m', $mesTexto);

        // Margem de uma semana
        $começo = $data->copy()->startOfMonth()->subWeek();
        $fim   = $data->copy()->endOfMonth()->addWeek();

        // obtendo reservas
        $reservas = Reserva::where('começo', '>=', $começo)->where('fim', '<=', $fim)->get();
        return Inertia::render('Dashboard', [
            'reservas' => ReservaCalendarResource::collection($reservas)->resolve(),
            'mesTexto' => $mesTexto
        ]);
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
        $validated = $request->validate([
            'notas' => 'required|string',
            'começo' => 'required|date',
            'fim' => 'nullable|sometimes|date|after:começo',
            'preço' => 'nullable|sometimes|numeric|min:0',
            'cliente_id' => 'nullable|sometimes|exists:clientes,id',
            'personalizado' => 'boolean'
        ]);

        // set defaults
        if (!$request->filled('preço')) {
            $validated['preço'] = 60;
        }
        if (!$request->filled('cliente_id')) {
            $validated['cliente_id'] = Cliente::where('nome', 'Não informado')->first()->id;;
        }
        if (!$request->filled('fim')) {
            $validated['fim'] = Carbon::parse($validated['começo'])->addDay()->setTime(20, 0, 0);
        }
        $validated["reserva_status_id"] = ReservaStatus::where('tipo', 'pendente')->first()->id;
        $reserva = Reserva::create($validated);

        return to_route('reservas.show', ['reserva' => $reserva])
            ->with('success', 'Reserva criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        $reserva->loadMissing(['cliente', 'status']);
        return Inertia::render('Reservas/Show', [
            'reserva' => $reserva,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        return Inertia::render('Reservas/Edit', [
            'reserva' => $reserva,
            "clientes" => Cliente::all(),
            "statuses" => ReservaStatus::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserva $reserva)
    {
        $validated = $request->validate([
            'notas' => 'required|string',
            'começo' => 'required|date',
            'fim' => 'required|date|after:começo',
            'preço' => 'required|numeric|min:0',
            'valor_pago' => 'required|numeric|min:0',
            'cliente_id' => 'required|exists:clientes,id',
            'reserva_status_id' => 'required|exists:reserva_statuses,id',
            'personalizado' => 'boolean'
        ]);

        $reserva->update($validated);
        return to_route('reservas.show',['reserva' => $reserva])
            ->with('success', 'Reserva atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        $reserva->delete();
        return to_route('reservas.index')
            ->with('success', 'Reserva desmarcada com sucesso.');
    }
}
