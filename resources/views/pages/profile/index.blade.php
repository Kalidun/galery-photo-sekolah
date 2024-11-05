@extends('layout.app-layout')

@section('title', 'Profile | Galery App')

@section('page-title', 'Profile')

@section('main-content')
    <div class="px-4 flex flex-col gap-2 items-center h-full max-h-[90vh] overflow-y-auto">
        <div class="flex flex-col gap-2 items-center mb-6 pb-2 w-full">
            @if (Auth::user()->image)
                <img src="{{ asset('storage/images/' . Auth::user()->image) }}" class="w-1/6 rounded-full">
            @else
                <img src="{{ asset('assets/images/profile-image.jpg') }}" class="w-1/6 rounded-full border border-black">
            @endif
            <div class="text-xl font-bold">
                {{ Auth::user()->name }}
            </div>
            <div class="flex gap-4">
                <a href="#"
                    class="px-4 py-2 bg-yellow-300 hover:bg-yellow-400 transition-colors duration-100 rounded-xl">Edit
                    Profile</a>
                <a href="{{ route('create.index') }}"
                    class="px-4 py-2 bg-yellow-300 hover:bg-yellow-400 transition-colors duration-100 rounded-xl">Add
                    Photo</a>
            </div>
        </div>
        <div class="w-full flex flex-col gap-2 p-4 h-full border-t-2 border-yellow-300">
          <div class="w-full text-center font-bold text-xl">Galeri Kamu</div>
          <div class="columns-2 md:columns-3 lg:columns-4 xl:columns-5 gap-2 px-2 py-6 space-y-2">
            @foreach ($photoData as $photo)
                <div class="p-2 border border-gray-300 rounded-md bg-white hover:scale-105 transition duration-100">
                    <img src="{{ asset('storage/images/' . $photo->image) }}" class="w-ful">
                </div>
            @endforeach
          </div>
        </div>
    </div>
@endsection
