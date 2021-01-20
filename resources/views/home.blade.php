@extends('layouts.app')

@section('title')Головна сторінка@endsection

@section('content')
<div class="container">
    @isset($person)
    <div class="text-center">
        @foreach($dentists as $d)
            <div class="card shadow-sm p-3 mb-5 bg-white rounded" style="width: 14rem; display:inline-block; margin: 8px 5px;">
                
                @isset($d->photo)
                    <img src="data:image/png;base64,{{ chunk_split(base64_encode($d->photo)) }}" height="10%"  class="card-img-top" alt="...">
                @else
                    <img src="https://img.icons8.com/color/512/000000/dentist.png" height="10%"  class="card-img-top" alt="...">
                @endisset

                <div class="card-body">
                    <div class="card-title">
                        <span>{{ $d->surname }}</span>
                        <span>{{ $d->name }}</span><br>
                        <span>{{ $d->middlename }}</span>
                    </div>
                    <div class="card-text text-left">
                        <span class="text-info">{{ $d->title }}</span><br>
                        <span class="text-secondary">{{ $d->address }}</span>
                    </div>
                    <a href="{{ route('dentist_record', ['id' => $d->id]) }}" class="btn btn-outline-success">Записатися</a>
                </div>
            </div>
        @endforeach
    </div>
    @else
        <div class="text-center">
            <h1>Привіт, на даний час ця сторінка ще не реалізована</h1>
            <a href="{{ route('cabinet') }}" class="btn btn-success">Мій кабінет</a>
        </div>
    @endisset
</div>
@endsection
