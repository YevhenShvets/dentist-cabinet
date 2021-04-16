@extends('layouts.app')

@section('title')Вилучення користувача@endsection

@section('content')
<div class="container">
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background-color: rgba(244,208,208,0.69);">
                <div class="card-header">{{ __('Вилучення користувача') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.delete_user_submit') }}">
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
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-danger">
                                    {{ __('Вилучити') }}
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
