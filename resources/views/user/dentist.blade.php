@extends('layouts.app')

@section('title')Запис до стоматолога@endsection

@section('content')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.css"/>
    
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
                <span>Стоматологія: </span><span class="text-info"><a href="{{ route('clinic', $dentist->clinic_id) }}" target="_blank">{{ $dentist->title }}</a></span><br>
                <span>Адреса: </span><span class="text-secondary">{{ $dentist->address }}</span><br>
            </div>
            <div class="row mt-3">
                <div class="col-8 offset-2">
                    {!! $calendar->calendar() !!}
                    {!! $calendar->script() !!}
                </div>

                <button id="record_modal" data-toggle="modal" data-target="#rmodal" hidden></button>
                <div class="modal fade" id="rmodal" tabindex="-1" role="dialog" aria-labelledby="rmodal" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">Запис</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <form action="{{ route('dentist_record_create', ['id'=>$dentist->id]) }}" method="POST">
                            @csrf
                            <input type="text" name="person_id" value="{{ Auth::user()->id }}" hidden>
                            <input type="text" name="dentist_id" value="{{ $dentist->id }}" hidden>
                            <input id="date_record" class="form-control" style="margin-bottom: 10px" name="date_record"  required readonly autocomplete="date_record">
                            <input type="text" name="time_record" id="time_record" class="form-control" style="margin-bottom: 10px" readonly>

                            <div style="text-align:center;">
                                <input type="submit" value="Записатися" class="btn btn-success" style="">
                            </div>
                        </form>
                        </div>
                        </div>
                    </div>
                </div>

                <script>
                    $(document).ready(function(){
                        $('#record_modal').on('show.bs.modal', function (event) {
                            var data = button.data('whatever');
                            var modal = $(this);
                            modal.find('.modal-body #time_record').val(data);
                        });
                    });
        </script>
            </div>
        @endisset
        
    </div>
    
@endsection
