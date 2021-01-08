@extends('layouts.app')
@section('css')

    <style>
        .text-header{
            font-size: 18px;
        }
    </style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('My Profile') }}</div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="table-user">
                            <thead>
                               <tr>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>E-mail</th>
                                    <th>Gender</th>
                                    <th>Social</th>
                                    <th width="15%">Profile images</th>
                               </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $item)
                                @php
                                     $social = App\Social::WhereIn('socail_id',explode(",",$item->social))->get();
                                     $social = $social->pluck('socail_name')->toArray();
                                @endphp
                                 <tr>
                                    <td>{{$item->firstname}} {{$item->lastname}}</td>
                                    <td>{{age($item->birthday)}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->gender_name}}</td>
                                    <td>{{implode(",",$social)}}</td>
                                    <td>
                                        @if ($item->images != null)
                                            <img width="50%" class="img-fluid" src="{{asset('storage').'/'.$item->images}}" />
                                        @else 
                                            -
                                        @endif
                                       
                                    </td>
                                 </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')

@endsection
