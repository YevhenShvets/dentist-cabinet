@extends('layouts.app')

@section('title')Головна сторінка адміністратора@endsection

@section('content')
<div class="container">
   <h1 class="text-center">Адмін панель</h1>
   <div class="text-center" >
        <a href="{{ route('admin.add_clinic') }}" class="btn btn-outline-primary m-2">Добавити поліклініку</a><br>
        <a href="{{ route('admin.add_dentist') }}" class="btn btn-outline-secondary m-2">Добавити стоматолога</a><br>

        <a href="{{ route('admin.delete_user') }}" class="btn btn-outline-danger m-2">Вилучити користувача</a>
   </div>
</div>
@endsection
