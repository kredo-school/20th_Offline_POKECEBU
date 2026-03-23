<?php
use App\Models\FortuneSpot;

$spots = [
    'Ayala' => 'https://th.bing.com/th/id/OIP.vH0YYynDw92yC-NWmxuNnAHaE8?w=277&h=185&c=7&r=0&o=7&pid=1.7&rm=3',
    'Magellan' => 'https://miro.medium.com/v2/resize:fit:965/1*_ODZre7ijbY3jk9adrs1jg.jpeg',
    'Temple' => 'https://cebuinsider.com/wp-content/uploads/2023/08/Temple-of-Leah-Cebu-City.jpg',
    'Sirao' => 'https://sugbo.ph/wp-content/uploads/2018/12/siraopictorialgardencebu-6-3.jpg',
    'Tops' => 'https://www.topscebu.ph/_next/image?url=https:%2F%2Fcdn.sanity.io%2Fimages%2Foxei9udv%2Fproduction%2Fed70279bc18ddae5802d5554adb858f1ef87c89d-2048x1152.jpg%3Frect%3D0%2C0%2C1703%2C1152%26fm%3Dwebp&w=3840&q=75'
];

foreach ($spots as $key => $url) {
    echo "Updating spot containing $key...\n";
    $spot = FortuneSpot::where('name', 'like', '%' . $key . '%')->first();
    if ($spot) {
        $spot->image = $url;
        $spot->save();
        echo "Updated {$spot->name}!\n";
    } else {
        echo "Not found: $key\n";
    }
}
