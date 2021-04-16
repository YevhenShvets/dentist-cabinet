@extends('layouts.app')

@section('title')Контакти@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background: rgba(214,193,17,0.41);">
                <div class="card-header text-center" style="font-size: 30px;">{{ __('Замовлення консультації') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('contacts_submit') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __("Ім'я") }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __("Номер телефону") }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" required >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="message" class="col-md-4 col-form-label text-md-right">{{ __("Повідомлення") }}</label>

                            <div class="col-md-6">
                                <textarea id="message" type="text" class="form-control" name="message" required></textarea>
                            </div>
                        </div>
                       

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-warning">
                                    {{ __('Відправити') }}
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
