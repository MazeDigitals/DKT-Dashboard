@extends('layouts.admin.app', [ 'page' => 'blog_management', 'title'=> $title ])

@push('css')

@endpush

@section('content')

<div class="row row-eq-height my-3">

    <x-panel-card class="" >
        <x-slot name="title">
            {{$title}}
        </x-slot>
        
        <form action="{{$action_url}}" method="POST" enctype="multipart/form-data" class="needs-validation @if($errors->any()) was-validated @endif" novalidate>
            @csrf

            {{-- <input type="hidden" name="{{$blog?'updated_by_id':'created_by_id'}}" value="{{auth()->user()->id}}"> --}}

            <div class="form-row">
                <input type="hidden" name="blog_id" value="{{$blog?$blog->id:''}}" >
                <div class="form-group col-6 mb-2">
                    <label for="title" class="w-100 text-left">title <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" name="title" placeholder="title" value="{{$blog?$blog->title:old('title')}}" required>
                    @error('title')
                        <div class="invalid-feedback"> {{$message}} </div>
                    @enderror
                </div>

                <div class="form-group col-6 mb-2">
                    <label for="category" class="w-100 text-left">Category <span class="text-danger">*</span> </label>
                    <select class="form-control" name="category" required>
                        <option>--Select--</option>
                        @foreach($arr as $ar)
                        <option value={{strtolower($ar)}}>{{$ar}}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="invalid-feedback"> {{$message}} </div>
                    @enderror
                </div>

                <div class="form-group col-6 mb-2">
                    <label for="terms" class="w-100 text-left">Content </label>
                    <textarea class="form-control" name="content" cols="10" rows="3">{{$blog?$blog->content:old('content')}}</textarea>
                    @error('content')
                        <div class="invalid-feedback"> {{$message}} </div>
                    @enderror
                </div>

                <div class="form-group col-2 my-2 mb-2 pl-4">
                    <label for="status" class="xcol-form-label s-12 mr-4">Status</label>
                    <div class="d-flex justify-content-left align-items-center">
                        <div class="material-switch">
                            <input id="statusOption" name="status" type="checkbox"  {{($blog && ($blog->status==App\Models\Blogs::STATUS_ACTIVE))?'checked':''}} >
                            <label for="statusOption" class="bg-success"></label>
                        </div>
                    </div>
                </div>

                <div class="form-group col-12 mb-3">
                    <label for="image" class="w-100 text-left">Image</label>
                    <input type="file" class="form-control dropify" name="image" id="categoryImage" data-allowed-file-extensions="jpg png jpeg" data-max-file-size="1M" @if($blog && $blog->image) data-default-file="{{$blog->m_image}}" @endif>
                    @error('image')
                        <div class="invalid-feedback"> {{$message}} </div>
                    @enderror
                </div>

                <div class="col-12">
                    <hr>
                </div>
            <div>
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>

        </form>

    </x-panel-card>

</div>

@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>


@endpush