@extends('layout.app-layout')

@section('title', 'Dashboard | Galery App')

@section('page-title', 'Dashboard')

@section('main-content')
    <div class="flex flex-col gap-2 max-h-[90vh]">
        <input type="text" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Search">
        <div class="overflow-y-auto columns-2 md:columns-3 lg:columns-4 xl:columns-5 max-h-[92vh] gap-2 px-2 py-6 space-y-2">
            @foreach ($postData as $post)
                <div class="p-2 border border-gray-300 rounded-md bg-white hover:scale-105 transition duration-100">
                    <img src="{{ asset('storage/images/' . $post->image) }}" class="w-ful">
                </div>
            @endforeach
        </div>
    </div>
@endsection
