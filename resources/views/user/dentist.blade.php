@extends('layouts.app')

@section('title')Запис до стоматолога@endsection

@section('content')
    <div class="container">
        <div class="">
                @isset($dentist->photo)
                    <img src="data:image/png;base64,{{ chunk_split(base64_encode($dentist->photo)) }}" style="height: 200px; width: 180px;" class="card-img-top img-thumbnail mx-auto d-block" alt="...">
                @else
                    <img src="https://img.icons8.com/color/512/000000/dentist.png" style="height: 200px; width: 180px;" class="card-img-top img-thumbnail mx-auto d-block" alt="...">
                @endisset
        </div>
        @isset($dentist)
            <div class="text-center" style="font-size: 30px;">
                {{ $dentist->surname }}<br>
                {{ $dentist->name }}
                {{ $dentist->middlename }}<br>
            </div>
            <hr class="hr">
            <div class="text-left" style="font-size: large;">
                <span>Вік: </span><span>{{ intval(date('Y', time() - strtotime($dentist->date_birthday))) - 1970 }}</span><br>
                <span>Номер телефону: </span><span>{{ $dentist->phone }}</span><br>
                <span>Стоматологія: </span><span class="text-info"><a href="#" target="_blank">{{ $dentist->title }}</a></span><br>
                <span>Адреса: </span><span class="text-secondary">{{ $dentist->address }}</span><br>
            </div>
            <div class="row mt-3">
                <div class="col-6 offset-3">
                    <div class="card text-center">
                        <div class="card-header" style="font-size:large;">Запис</div>
                        <div class="card-body">
                            <form action="{{ route('dentist_record_create', ['id'=>$dentist->id]) }}" method="POST">
                                @csrf
                                <input type="text" name="person_id" value="{{ Auth::user()->id }}" hidden>
                                <input type="text" name="dentist_id" value="{{ $dentist->id }}" hidden>
                                <div class="form-group row">
                                    <label for="date_record" class="col-md-4 col-form-label text-md-right">{{ __('Дата') }}</label>
                                    <div class="col-md-6">
                                        <!-- value="{{ date('Y-m-d') }}" -->
                                        <input id="date_record" type="date" min="{{ date('Y-m-d') }}" class="form-control @error('date_record') is-invalid @enderror" name="date_record"  required autocomplete="date_record">
                                        @error('date_record')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="time_record" class="col-md-4 col-form-label text-md-right">{{ __('Час') }}</label>
                                    <div class="col-md-6">
                                        <!-- value="{{ date('Y-m-d') }}" -->
                                        <!-- <input id="time_record" type="time" min="10:00" max="21:00" step="3600" class="form-control @error('time_record') is-invalid @enderror" name="time_record"  required autocomplete="time_record"> -->
                                        <select id="time_record" class="form-control @error('time_record') is-invalid @enderror" name="time_record"  required autocomplete="time_record">
                                            @for($i = 10; $i < 21; $i+=1)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                        @error('time_record')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group mb-0">
                                    <div class="d-flex justify-content-center">
                                        <button submit class="btn btn-outline-info btn-lg">Вибрати</button>
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
