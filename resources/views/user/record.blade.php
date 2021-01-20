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
    @endisset
@endsection
