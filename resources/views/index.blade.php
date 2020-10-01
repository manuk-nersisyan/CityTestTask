@extends('layouts.app')

@section('content')

    @include('__forms.search-city-form')

    @if(isset($cities))
        <div class="container">
            @foreach($cities as $city)
                <div class="p-2 d-inline-block mt-lg-1">
                    <a href="{{route('show_city',['id'=>$city->id])}}" class="btn btn-success mt-8">{{$city->name}}</a>
                </div>
            @endforeach
        </div>
    @endif

@endsection
