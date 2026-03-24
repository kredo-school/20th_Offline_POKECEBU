<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JeepneyStop;
use App\Models\JeepneyRoute;

class JeepneyController extends Controller
{
    public function index()
    {
        $stops = JeepneyStop::orderBy('name')->get();
        return view('jeepney', compact('stops'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'from_stop_id' => 'required|different:to_stop_id|exists:jeepney_stops_table,id',
            'to_stop_id'   => 'required|exists:jeepney_stops_table,id',
        ]);

        $stops = JeepneyStop::orderBy('name')->get();

        $fromStop = JeepneyStop::findOrFail($request->from_stop_id);
        $toStop   = JeepneyStop::findOrFail($request->to_stop_id);

        // --- 直接ルート検索 ---
        $routes = JeepneyRoute::with(['stops' => function ($query) {
                $query->orderBy('route_stop.stop_order');
            }])
            ->whereHas('stops', function ($query) use ($fromStop) {
                $query->where('jeepney_stops_table.id', $fromStop->id);
            })
            ->whereHas('stops', function ($query) use ($toStop) {
                $query->where('jeepney_stops_table.id', $toStop->id);
            })
            ->get()
            ->filter(function ($route) use ($fromStop, $toStop) {
                $fromOrder = optional($route->stops->firstWhere('id', $fromStop->id))->pivot->stop_order ?? null;
                $toOrder   = optional($route->stops->firstWhere('id', $toStop->id))->pivot->stop_order ?? null;
                return $fromOrder !== null && $toOrder !== null && $fromOrder < $toOrder;
            })
            ->values();

        // --- 乗り換えルート検索（1回乗り換えまで） ---
        $fromRoutes = JeepneyRoute::with('stops')
            ->whereHas('stops', fn($q) => $q->where('jeepney_stops_table.id', $fromStop->id))
            ->get();

        $toRoutes = JeepneyRoute::with('stops')
            ->whereHas('stops', fn($q) => $q->where('jeepney_stops_table.id', $toStop->id))
            ->get();

        $transferOptions = [];
        foreach ($fromRoutes as $fr) {
            foreach ($toRoutes as $tr) {
                // 共通停留所を探す
                $commonStops = $fr->stops->pluck('id')->intersect($tr->stops->pluck('id'));
                if ($commonStops->isNotEmpty()) {
                    $transferOptions[] = [
                        'firstRoute'   => $fr,
                        'secondRoute'  => $tr,
                        'transferStop' => JeepneyStop::find($commonStops->first()),
                    ];
                }
            }
        }

        return view('jeepney', compact('stops', 'routes', 'fromStop', 'toStop', 'transferOptions'));
    }
}

