@extends('layouts.guest')
@section('content')
    @include('client.home.noibat')
    @include('client.home.trending')
    @include('client.home.tinmoi')
    <div class="container-fluid pb-4 pt-4 paddding">
        <div class="container paddding">
            <div class="row mx-0">
                @include('client.home.tintrongloai')
                @include('client.blocks.tag_tinhot')
            </div>
        </div>
    </div>
@endsection