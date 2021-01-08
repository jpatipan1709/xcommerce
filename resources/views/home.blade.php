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
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('My Profile') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <img class="img-fluid" src="{{asset('storage').'/'.$user->images}}" />
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4 text-header">
                                    firstname : 
                                </div>
                                <div class="col-8">
                                    {{$user->firstname}}
                                </div>
                            </div>
                            <div class="row  mt-2">
                                <div class="col-4 text-header">
                                    lastname : 
                                </div>
                                <div class="col-8">
                                    {{$user->lastname}}
                                </div>
                            </div>
                            <div class="row  mt-2">
                                <div class="col-4 text-header">
                                    E-mail : 
                                </div>
                                <div class="col-8">
                                    {{$user->email}}
                                </div>
                            </div>
                            <div class="row  mt-2">
                                <div class="col-4 text-header">
                                    Date of Birth : 
                                </div>
                                <div class="col-8">
                                    {{-- {{date("d m Y",$user->birthday)}} --}}
                                @php
                                    $date = strtotime($user->birthday);
                                @endphp
                                {{date('d F Y',$date) }}
                                </div>
                            </div>
                            <div class="row  mt-2">
                                <div class="col-4 text-header">
                                    Gender :  
                                </div>
                                <div class="col-8">
                                    {{$user->gender_name}}
                                </div>
                            </div>
                            <div class="row  mt-2">
                                <div class="col-4 text-header">
                                    Socail : 
                                </div>
                                <div class="col-8">
                                    {{implode(",",$social)}}
                                    {{-- @foreach ($social as $item)
                                        {{$item->socail_name}},
                                    @endforeach --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
