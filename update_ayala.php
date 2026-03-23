<?php
use App\Models\FortuneSpot;

$spot = FortuneSpot::where('name', 'like', '%Ayala%')->first();
if ($spot) {
    $spot->image = 'https://cdn-ak.f.st-hatena.com/images/fotolife/n/newyorker24/20160720/20160720214257.png';
    $spot->save();
    echo "Updated {$spot->name}!\n";
} else {
    echo "Not found: Ayala\n";
}
