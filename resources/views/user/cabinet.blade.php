@extends('layouts.app')

@section('title')Кабінет користувача@endsection

@section('content')
    @isset($records)
        <div class="container">
            <h3 class="text-center">Мої записи</h3>
            @isset($person)
                @foreach($records as $record)
                    <a href="{{ route('record_info', ['id' => $record->id]) }}" class="mb-2" style="text-decoration: none;">
                        <div class="card m-1">
                            <div class="card-body">
                                {{ $record->date_record }} <hr>
                                {{ $record->address }}
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                @foreach($recordsDentist as $record)
                    <a href="{{ route('record_info', ['id' => $record->id]) }}" class="mb-2" style="text-decoration: none;">
                        <div class="card m-1">
                            <div class="card-body">
                                {{ $record->date_record }} 
                            </div>
                        </div>
                    </a>
                @endforeach
            @endisset
        </div>
    @endisset
@endsection
