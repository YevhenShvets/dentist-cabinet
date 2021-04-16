@extends('layouts.app')

@section('title')Налаштування@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Дані користувача') }}</div>

                <div class="card-body">
                    @isset($dentist)
                        <form method="POST" action="{{ route('settings_update_dentist') }}"  enctype="multipart/form-data">
                    @else
                        <form method="POST" action="{{ route('settings_update') }}"  enctype="multipart/form-data">
                    @endisset    
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __("Ім'я") }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="middlename" class="col-md-4 col-form-label text-md-right">{{ __('По батькові') }}</label>

                            <div class="col-md-6">
                                <input id="middlename" type="text" class="form-control @error('middlename') is-invalid @enderror" name="middlename" value="{{ $user->middlename }}" required autocomplete="middlename">

                                @error('middlename')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Прізвище') }}</label>

                            <div class="col-md-6">
                                <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ $user->surname }}" required autocomplete="surname">

                                @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date_birthday" class="col-md-4 col-form-label text-md-right">{{ __('Дата народження') }}</label>

                            <div class="col-md-6">
                                <input id="date_birthday" type="date" class="form-control @error('date_birthday') is-invalid @enderror" name="date_birthday" value="{{ $user->date_birthday }}" required autocomplete="date_birthday">

                                @error('date_birthday')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Номер телефону') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}" required autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @isset($dentist)
                            <div class="form-group row">
                                <label for="clinic_id" class="col-md-4 col-form-label text-md-right">{{ __('Ідентифікатор клініки') }}</label>

                                <div class="col-md-6">
                                    <input id="clinic_id" type="text" readonly class="form-control @error('clinic_id') is-invalid @enderror" name="clinic_id" value="{{ $dentist->clinic_id }}" autocomplete="clinic_id">

                                    @error('clinic_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="dentist_photo" class="col-md-4 col-form-label text-md-right">{{ __('Фото стоматолога') }}</label>

                                <div class="col-md-6">
                                    <input id="dentist_photo" type="file" class="form-control @error('dentist_photo') is-invalid @enderror" name="dentist_photo" accept=".png" required autocomplete="dentist_photo">

                                    @error('dentist_photo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endisset

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-dark">
                                    {{ __('Змінити дані') }}
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
