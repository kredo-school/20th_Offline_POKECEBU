<?php
use App\Models\FortuneSpot;

$spot = FortuneSpot::where('name', 'like', '%Sirao%')->first();
if ($spot) {
    $spot->image = 'https://tse1.mm.bing.net/th/id/OIP.MhThNU4C5DwJFCKqd9kMxAHaLk?rs=1&pid=ImgDetMain&o=7&rm=3';
    $spot->save();
    echo "Updated {$spot->name}!\n";
} else {
    echo "Not found: Sirao\n";
}
