@extends('layouts.app')

@section('title')Контакти@endsection

@section('content')
<div class="container">
@isset($contacts)
<table class="table">
  <thead>
    <tr>
      <th scope="col">Ім'я</th>
      <th scope="col">Телефон</th>
      <th scope="col">Повідомлення</th>
      <th scope="col">Дія</th>
    </tr>
  </thead>
  <tbody>
    @forelse($contacts as $c)
    <tr>
      <td>{{ $c->user_name }}</td>
      <td>{{ $c->user_phone }}</td>
      <td>{{ $c->message }}</td>
      <td>
        <form action="{{ route('admin.show_contacts_submit') }}" method="POST">
            @csrf
            <input type="text" hidden name="id" value="{{ $c->id }}">
            <button type="submit" class="btn" style="outline: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                    <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                </svg>
            </button>
        </form>
      </td>
    </tr>
    @empty
    <tr>
        <th>Пусто</th>
    </tr>
    @endforelse
  </tbody>
</table>
@endisset
</div>
@endsection
