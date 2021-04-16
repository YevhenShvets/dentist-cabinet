@extends('layouts.app')

@section('title')Добавлення стоматолога@endsection

@section('content')
<div class="container">
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background-color: rgba(226,206,242,0.53)">
                <div class="card-header">{{ __('Добавлення стоматолога') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.add_dentist_submit') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="user_id" class="col-md-4 col-form-label text-md-right">{{ __('Користувач') }}</label>

                            <div class="col-md-6">
                                <select id="user_id" class="form-select form-control @error('user_id') is-invalid @enderror" name="user_id" value="{{ old('user_id') }}" required autocomplete="user_id" autofocus>
                                    @isset($users)
                                        @foreach($users as $u)
                                            <option value="{{ $u->id }}">{{ $u->surname }}  {{ $u->name }}    {{ $u->phone }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="clinic_id" class="col-md-4 col-form-label text-md-right">{{ __('Клініка') }}</label>

                            <div class="col-md-6">
                                <select id="clinic_id" class="form-select form-control @error('clinic_id') is-invalid @enderror" name="clinic_id" value="{{ old('clinic_id') }}" required autocomplete="clinic_id" autofocus>
                                    @isset($clinics)
                                        @foreach($clinics as $c)
                                            <option value="{{ $c->id }}">{{ $c->title }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                                @error('clinic_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-info">
                                    {{ __('Добавити') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
