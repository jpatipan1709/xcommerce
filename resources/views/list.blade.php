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
                        <table class="table table-bordered table-hover" id="myTable">
                            <thead>
                               <tr>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>E-mail</th>
                                    <th>Gender</th>
                                    <th>Social</th>
                                    <th>Profile images</th>
                               </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $item)
                                 <tr>
                                    <th>{{$item->firstname}} {{$item->lastname}}</th>
                                    <th>{{age($item->birthday)}}</th>
                                    <th>{{$item->email}}</th>
                                    <th>{{$item->gender_name}}</th>
                                    <th></th>
                                    <th>
                                        <img width="50%" class="img-fluid" src="{{asset('storage').'/'.$item->images}}" />
                                    </th>
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
<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    });
</script>
@endsection
