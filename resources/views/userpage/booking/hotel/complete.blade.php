@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h3>予約完了！</h3>
    <p>ホテル名: {{ $reservation->hotel->name }}</p>
    <p>日程: {{ $reservation->checkin_date }} 〜 {{ $reservation->checkout_date }}</p>
    <p>人数: {{ $reservation->guests }}</p>
    <p>合計金額: ¥{{ number_format($reservation->price_total) }}</p>
    <a href="{{ route('hotels.index') }}" class="btn btn-primary">ホテル一覧に戻る</a>
</div>
@endsection
