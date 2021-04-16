@extends('layouts.app')

@section('title')Головна сторінка@endsection

@section('links')
<link href="{{ asset('css/flipper.css') }}" rel="stylesheet">
<link href="{{ asset('css/clinic.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <form action="" method="GET">
        <div class="col-md-6 offset-md-3 mt-1 border pt-3">
            <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Пошук клініки">
                <div class="input-group-append">
                <button style="outline: none; border: 0;" type="submit">
                    <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg></span>
                </button>
                </div>
            </div>
            <div style="display: flex; justify-content: space-around;">
                <a href="{{ route('home', ['filter' => 'counts']) }}">Фільтрувати по кількістю стоматологів</a>
                <!-- <a href="{{ route('home', ['filter' => 'records']) }}" class="">по кількістю замовлень</a> -->
            </div>
        </div>
    </form>
        @isset($clinics)
        <section id="clinics" class="pb-5">
            <div class="container">
                <div class="row">
                    <!--  member -->
                    @forelse($clinics as $clinic)
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="image-flip" >
                            <div class="mainflip {{ ($loop->first) ? 'flip-0' : '' }}">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center" style="display: flex; justify-content:center; flex-direction: row; align-items: center;">
                                            <div>
                                            <h4 class="card-title">{{ $clinic->title }}</h4>
                                            <p class="card-text">{{ $clinic->description }}</p>
                                            <hr>
                                            <p>{{ $clinic->address }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="backside">
                                    <div class="card">
                                        <div class="card-body text-center mt-4">
                                            <div style="width: 100%"><iframe width="100%" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=200&amp;hl=en&amp;q={{ $clinic->address }}&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe></div>
                                            <a href="{{ route('clinic', $clinic->id) }}" class="text-center btn">Детальніше</a>
                                            @auth('admin')
                                                <a class="btn btn-warning" href="{{ route('admin.edit_clinic', $clinic->id) }}">Редагувати</a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <h2 class='text-center'>Клінік немає</h2>
                    @endforelse
                    <!-- member -->
                </div>
                @if(gettype($clinics) == "objects")
                <div class="text-center" style="width: 100%; height: 200px;">
                    {{ $clinics->links() }}
                </div>
                @endif
            </div>
        </section>
        @endisset

    @isset($feedbacks)
    <div>
    <h3>Відгуки користувачів</h3>
    <div class="row">
    @forelse($feedbacks as $f)
    <div class="col-sm-6">
        <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $f->user_name }}</h5>
            <p class="card-text">{{ $f->message }}</p>
        </div>
        </div>
    </div>
    @empty
    <h5 class="text-center">Відгуки відсутні</h5>
    @endforelse
    </div>
    </div>
    @endisset
    
</div>
@endsection
