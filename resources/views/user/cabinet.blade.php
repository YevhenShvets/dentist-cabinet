@extends('layouts.app')

@section('title')Кабінет користувача@endsection

@section('content')
    <div class="container">
        @isset($person)
            <h3 class="text-center">Мої записи</h3>
            @isset($records)
            <div class="row justify-content-center">
            @forelse($records as $record)
                <div class="card" style="width: 18rem; margin-right: 10px; margin-bottom: 10px;">
                    <div class="card-body">
                        <h5 class="card-title">Дата: {{ date('d.m.Y H:i', strtotime($record->date_record)) }}</h5>
                        <p class="card-text">Лікар: {{ $record->surname }} {{ $record->name }}  {{ $record->middlename }}</p>
                        <a href="{{ route('record_info', ['id' => $record->id]) }}" class="card-link">Детальніше</a>
                        @if($record->date_record != $record->date_first)
                        <br>
                        <div class="text-right">
                        <span style="font-weight:bold;">дата змінена*</span>
                        </div>
                        @endif
                    </div>
                </div>
            @empty
                <h2>Пусто</h2>
            @endforelse
            </div>
            @endisset
        @else
            <h3 class="text-center">Записи до мене</h3>
            <div>
                <h3>На сьогодні ({{ date('d.m.Y', strtotime(now())) }})</h3>
                <hr>
                <div class="container row justify-content-center">
                    @isset($today)
                    @forelse($today as $t)
                    <div class="card" style="width: 18rem; margin-right: 10px; margin-bottom: 10px;">
                        <div class="card-body">
                            <h5 class="card-title">{{ date('d.m.Y H:i', strtotime($t->date_record)) }}</h5>
                            <p class="card-text">{{ $t->surname }} {{ $t->name }}  {{ $t->middlename }} - {{ $t->phone }}</p>
                            <a href="{{ route('record_info', ['id' => $t->id]) }}" class="card-link">Детальніше</a>
                        </div>
                    </div>
                    @empty
                        <h2>Пусто</h2>
                    @endforelse
                    @endisset
                </div>
                <br>
                <h3>На завтра ({{ date('d.m.Y', strtotime("+ 1 days", strtotime(now()))) }})</h3>
                <hr>
                <div class="container row justify-content-center">
                    @isset($tomorrow)
                    @forelse($tomorrow as $t)
                    <div class="card" style="width: 18rem; margin-right: 10px; margin-bottom: 10px;">
                        <div class="card-body">
                            <h5 class="card-title">{{ date('d.m.Y H:i', strtotime($t->date_record)) }}</h5>
                            <p class="card-text">{{ $t->surname }} {{ $t->name }}  {{ $t->middlename }} - {{ $t->phone }}</p>
                            <a href="{{ route('record_info', ['id' => $t->id]) }}" class="card-link">Детальніше</a>
                        </div>
                    </div>
                    @empty
                        <h2>Пусто</h2>
                    @endforelse
                    @endisset
                </div>
                <br>
                <h3>Інші дні</h3>
                <hr>
                <div class="container row justify-content-center">
                    @isset($another)
                    @forelse($another as $t)
                    <div class="card" style="width: 18rem; margin-right: 10px; margin-bottom: 10px;">
                        <div class="card-body">
                            <h5 class="card-title">{{ date('d.m.Y H:i', strtotime($t->date_record)) }}</h5>
                            <p class="card-text">{{ $t->surname }} {{ $t->name }}  {{ $t->middlename }} - {{ $t->phone }}</p>
                            <a href="{{ route('record_info', ['id' => $t->id]) }}" class="card-link">Детальніше</a>
                        </div>
                    </div>
                    @empty
                        <h2>Пусто</h2>
                    @endforelse
                    @endisset
                </div>
            </div>
        @endisset
        @isset($person)
        <hr>
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <div class="card">
                    <div class="card-header text-center" style="font-size: 30px;">{{ __('Залишити відгук') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('cabinet_feedback') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="message" class="col-md-4 col-form-label text-md-right">{{ __('Повідомлення') }}</label>

                                <div class="col-md-6">
                                    <textarea id="message" type="text" class="form-control" name="message" required></textarea>
                                </div>
                            </div>

                
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Відправити') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endisset
    </div>
@endsection
