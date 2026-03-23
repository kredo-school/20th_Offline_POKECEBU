<?php

namespace App\Http\Controllers;

use App\Models\DailyFortuneLog;
use App\Models\FortuneSpot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyFortuneController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $fortuneLog = DailyFortuneLog::with('fortuneSpot')
            ->where('user_id', $user->id)
            ->where('fortune_date', $today)
            ->orderBy('id', 'desc')
            ->first();

        return view('daily_fortune', compact('fortuneLog'));
    }

    public function draw()
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $spot = FortuneSpot::where('is_active', true)
            ->inRandomOrder()
            ->first();

        if (!$spot) {
            return redirect()->route('home')
                ->with('error', 'No recommended spots are registered.');
        }

        DailyFortuneLog::updateOrCreate(
            ['user_id' => $user->id, 'fortune_date' => $today],
            ['fortune_spot_id' => $spot->id]
        );

        if (request()->wantsJson()) {
            return response()->json(['spot' => $spot]);
        }

        return redirect()->route('user.daily.fortune.show')
            ->with('success', 'Your fortune has been drawn!');
    }
}
