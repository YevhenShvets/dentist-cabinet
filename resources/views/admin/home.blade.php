@extends('layouts.app')

@section('title')Головна сторінка адміністратора@endsection

@section('content')
<div>
<div class="container">
   <h1 class="text-center">Адмін панель</h1>
   <div class="text-center" >
      <div class="d-flex justify-content-center">
        <a href="{{ route('admin.add_clinic') }}" class="btn btn-outline-primary m-2">Добавити поліклініку</a><br>
        <a href="{{ route('home') }}" class="btn btn-warning m-2">Редагувати поліклініку</a><br>
        <a href="{{ route('home') }}" class="btn btn-danger m-2">Вилучити поліклініку</a><br>
      </div>
        <a href="{{ route('admin.add_dentist') }}" class="btn btn-outline-secondary m-2">Добавити стоматолога</a><br>
        <a href="{{ route('admin.delete_user') }}" class="btn btn-outline-danger m-2">Вилучити користувача</a><br>
      <div>
         <a href="{{ route('admin.show_contacts') }}" class="btn btn-info m-2">Переглянути консультації</a>
      </div>
      <a href="{{ route('admin.show_feedbacks') }}" class="btn btn-dark m-2">Опублікувати відгуки</a>
   </div>
</div>
</div>
@endsection
