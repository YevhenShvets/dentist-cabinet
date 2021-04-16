@extends('layouts.app')

@section('title'){{ $clinic->title }}@endsection

@section('content')
<div class="container">
    @isset($clinic)
    <div class="text-center">
        @forelse($dentists as $d)
            <div class="card shadow-sm p-3 mb-5 bg-white rounded" style="width: 14rem; display:inline-block; margin: 8px 5px;">
                
                @isset($d->photo)
                    <img src="data:image/png;base64,{{ chunk_split(base64_encode($d->photo)) }}" height="10%"  class="card-img-top" alt="...">
                @else
                    <img src="https://img.icons8.com/color/512/000000/dentist.png" height="10%"  class="card-img-top" alt="...">
                @endisset

                <div class="card-body">
                    <div class="card-title">
                        <span>{{ $d->surname }}</span>
                        <span>{{ $d->name }}</span><br>
                        <span>{{ $d->middlename }}</span>
                    </div>
                    <div class="card-text text-left">
                        <span class="text-info">{{ $d->email }}</span><br>
                        <span class="text-secondary">{{ $d->phone }}</span>
                    </div>
                    @auth('')
                        @isset($person_id)
                        <a href="{{ route('dentist_record', ['id' => $d->id]) }}" class="btn btn-outline-success">Записатися</a>
                        @endisset
                    @endauth
                </div>
            </div>
        @empty
        <h2 class="text-center">На даний момент, інформація відсутня</h2>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-frown-fill" viewBox="0 0 16 16">
  <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm-2.715 5.933a.5.5 0 0 1-.183-.683A4.498 4.498 0 0 1 8 9.5a4.5 4.5 0 0 1 3.898 2.25.5.5 0 0 1-.866.5A3.498 3.498 0 0 0 8 10.5a3.498 3.498 0 0 0-3.032 1.75.5.5 0 0 1-.683.183zM10 8c-.552 0-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5S10.552 8 10 8z"/>
</svg>
        @endforelse
    </div>
    @else
    <h2 class="text-center">На даний момент, інформація відсутня</h2>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-frown-fill" viewBox="0 0 16 16">
  <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm-2.715 5.933a.5.5 0 0 1-.183-.683A4.498 4.498 0 0 1 8 9.5a4.5 4.5 0 0 1 3.898 2.25.5.5 0 0 1-.866.5A3.498 3.498 0 0 0 8 10.5a3.498 3.498 0 0 0-3.032 1.75.5.5 0 0 1-.683.183zM10 8c-.552 0-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5S10.552 8 10 8z"/>
</svg>
    @endisset
</div>
@endsection
