@extends('layouts.app')

@section('title')Кабінет користувача@endsection

@section('content')
    @isset($record)
        <div class="container">
            <div class="text-center">
            @isset($person_info)
                <h3>Інформація про клієнта</h3>
                <div class="card shadow-sm p-1 bg-white rounded" style="width:22rem; display:inline-block;">
                    <img src="https://img.icons8.com/officel/512/000000/person-male.png" style="width:100px; height:100px"  class="card-img-top" alt="...">
                    <div class="card-body">
                        <div class="card-title">
                            <span>{{ $person_info->surname }}</span>
                            <span>{{ $person_info->name }}</span><br>
                            <span>{{ $person_info->middlename }}</span><br>
                            <span>{{ $person_info->email }}</span><br>
                            <span>{{ $person_info->phone }}</span>
                        </div>
                    </div>
                </div>
                <hr height="1px" width="40%" class="bg-primary">
                <div style="font-size:large;">
                    <span>Запис на: </span><span>{{ date('d.m.Y H:i', strtotime($record->date_record)) }}</span>
                </div>
                <hr height="4px" width="100%" class="bg-warning">
            @else
                <div class="card shadow-sm p-1 bg-white rounded" style="width:22rem; display:inline-block;">
                    
                    @isset($record->photo)
                        <img src="data:image/png;base64,{{ chunk_split(base64_encode($record->photo)) }}" style="width:100px; height:100px" class="card-img-top" alt="...">
                    @else
                        <img src="https://img.icons8.com/color/512/000000/dentist.png" style="width:100px; height:100px"  class="card-img-top" alt="...">
                    @endisset

                    <div class="card-body">
                        <div class="card-title">
                            <span>{{ $record->surname }}</span>
                            <span>{{ $record->name }}</span><br>
                            <span>{{ $record->middlename }}</span>
                        </div>
                        <div class="card-text text-left">
                            <span class="text-info">{{ $record->title }}</span><br>
                            <span class="text-secondary">{{ $record->address }}</span>
                        </div>
                    </div>
                </div>
                <hr height="1px" width="40%" class="bg-primary">
                <div style="font-size:large;">
                    <span>Запис на: </span><span>{{ date('d.m.Y H:i', strtotime($record->date_record)) }}</span>
                </div>
                <hr height="4px" width="100%" class="bg-warning">
            @endisset
            </div>

        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-1 mt-3">
                    <div class="portlet portlet-default">
                        <div class="portlet-heading">
                            <div class="portlet-title">
                                <h4><i class="fa fa-circle text-green"></i>Чат</h4>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="chat" class="panel-collapse collapse show">
                            <div>
                            <div class="portlet-body chat-widget" style="overflow-y: auto; width: auto; height: 300px;">
                                @isset($messages)
                                    @foreach($messages as $message)
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="media">
                                                    <!-- <a class="pull-left" href="#">
                                                        <img class="media-object img-circle img-chat" src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                                                    </a> -->
                                                    <div class="media-body">
                                                        <h4 class="media-heading">{{ $message->name }} 
                                                            <span class="small pull-right">{{ date('d.m H:i', strtotime($message->date_create)) }}</span>
                                                        </h4>
                                                        <p>{{ $message->message_text }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                @endisset
                            </div>
                            </div>
                            <div class="portlet-footer">
                                <form method="POST" action="{{ route('message_create', ['id' => $record->id]) }}">
                                    @csrf
                                    <input type="text" hidden name="user_id" value="{{ Auth::user()->id }}">
                                    <div class="form-group">
                                        <textarea class="form-control" name="message" required placeholder="Введіть повідомлення"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" style="float:right;" class="btn btn-primary btn-sm  btn-lg pull-right">Надіслати</button>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @isset($person_info)
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModal">
                Перенести запис
                </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Виберіть дату та час</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="{{ route('record_new_date', $record->id) }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="date_record" class="col-md-4 col-form-label text-md-right">{{ __('Дата') }}</label>
                        <div class="col-md-6">
                            <!-- value="{{ date('Y-m-d') }}" -->
                            <input id="date_record" type="date" min="{{ date('Y-m-d') }}" class="form-control @error('date_record') is-invalid @enderror" name="date_record" value="{{ date('Y-m-d',strtotime($record->date_record)) }}"  required autocomplete="date_record">
                            @error('date_record')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="time_record" class="col-md-4 col-form-label text-md-right">{{ __('Час') }}</label>
                        <div class="col-md-6">
                            <!-- value="{{ date('Y-m-d') }}" -->
                            <!-- <input id="time_record" type="time" min="10:00" max="21:00" step="3600" class="form-control @error('time_record') is-invalid @enderror" name="time_record"  required autocomplete="time_record"> -->
                            <select id="time_record" class="form-control @error('time_record') is-invalid @enderror" name="time_record"  required autocomplete="time_record">
                                @for($i = 10; $i < 21; $i+=1)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('time_record')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group mb-0">
                        <div class="d-flex justify-content-center">
                            <button submit class="btn btn-outline-info btn-lg">Змінити</button>
                        </div>
                    </div>    
                </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
                </div>
            </div>
            </div>
        @else
            <div class="d-flex justify-content-center">
            <form action="{{ route('record_delete', $record->id) }}" method="POST">
                @csrf
                <input type="text" hidden name="record_id" value="{{ $record->id }}">
                <button type="submit" class="btn btn-danger">Відказатись від запису</button>
            </form>
            </div>
        @endisset
    @endisset
@endsection
