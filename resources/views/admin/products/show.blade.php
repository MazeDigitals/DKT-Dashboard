@extends('layouts.admin.app', [ 'page' => 'product_management', 'title'=> $title ])

@push('css')

@endpush

@section('content')

<div class="row row-eq-height my-3">

    <x-panel-card class="" >
        <x-slot name="title">
            <div class="m-0" style="height: 20px;">
                {{$title}} &nbsp;
                {!!$product?$product->getStatusHtml():''!!}
            </div>
        </x-slot>
        
        <div class="">
            @csrf

            <div class="form-row">
                <div class="form-group col-8 mb-2">
                    <label for="name" class="w-100 text-left">Name</label>
                    @php
                    // dd($product);
                    @endphp
                    <input type="text" class="form-control" value="{{$product->name}}" disabled>
                </div>
                <div class="form-group col-4 mb-2">
                    <label for="name" class="w-100 text-left">Category </label>
                    <input type="text" class="form-control" value="{{ucfirst($product->category->name)}}" disabled>
                </div>

                <div class="form-group col-4 mb-2">
                    <label for="price" class="w-100 text-left">Price (Rs) </label>
                    <input type="text" class="form-control" value="{{$product->price}}" disabled>
                </div>
             
            </div>

            {{-- <div>
                <a href="{{$action_url}}" class="btn btn-primary btn-sm" type="button">Go Back</a>
            </div> --}}

        </div>

    </x-panel-card>

</div>

@endsection
