@extends('layout.app-layout')

@section('title', 'Album | Galery App')

@section('page-title', 'Album')

@section('main-content')
    <div class="flex flex-col gap-2 max-h-[90vh] overflow-y-auto">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 max-h-[92vh] gap-2 p-4 h-full">
            <a href="{{ route('album.read-all')}}"
                class="p-2 border border-gray-300 rounded-md bg-white hover:shadow-lg transition duration-100 w-full h-52 flex flex-col justify-between items-center max-h-52">
                @if (auth()->user()->photos->count() > 0)
                    <div class="max-h-4/5 overflow-auto flex justify-center">
                        <img src="{{ asset('storage/images/' . auth()->user()->photos->sortByDesc('created_at')->first()->image) }}"
                            class="w-[75%] overflow-auto">
                    </div>
                @else
                    <div class="max-h-4/5 overflow-auto flex justify-center">
                        <img src="{{ asset('assets/images/dummy-photo.png') }}" class="w-[75%]">
                    </div>
                @endif
                <div class="flex justify-between w-full">
                    <span>Semua Foto</span>
                    <span>{{ auth()->user()->photos->count() }}</span>
                </div>
            </a>
            @forelse($albumData as $album)
                <a href="{{ route('album.read', $album->id) }}"
                    class="p-2 border border-gray-300 rounded-md bg-white hover:shadow-lg transition duration-100 w-full h-52 flex flex-col justify-between items-center max-h-52">
                    @if ($album->photos->where('user_id', auth()->user()->id)->count() > 0)
                        <div class="max-h-4/5 overflow-auto flex justify-center">
                            <img src="{{ asset('storage/images/' . $album->photos->where('user_id', auth()->user()->id)->first()->image) }}"
                                class="w-[75%] overflow-auto">
                        </div>
                    @else
                        <div class="max-h-4/5 overflow-auto flex justify-center">
                            <img src="{{ asset('assets/images/dummy-photo.png') }}" class="w-[75%]">
                        </div>
                    @endif
                    <div class="flex justify-between w-full">
                        <span>{{ $album->name }}</span>
                        <span>{{ $album->photos->where('user_id', auth()->user()->id)->count() }}</span>
                    </div>
                </a>
            @empty
            @endforelse
            <div data-modal-toggle="add-album-modal" data-modal-target="add-album-modal"
                class="p-2 border border-gray-300 rounded-md bg-white hover:shadow-lg cursor-pointer transition duration-100 w-full h-52 flex flex-col justify-between items-center">
                <img src="{{ asset('assets/images/plus-image.png') }}" class="w-[75%]">
                <div>Tambah Album</div>
            </div>
        </div>
    </div>
    <div id="add-album-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-4 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-[calc(100vh-3rem)]">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 w-full">
                <div class="flex flex-col w-full p-4">
                    <div class="w-full flex justify-between mb-4 border-b border-gray-200">
                        <div class="text-xl font-bold">Tambah Album</div>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="add-album-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form action="{{ route('album.store') }}" class="w-full" method="post">
                        @csrf
                        <div class="w-full">
                            <label for="album-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Nama Album
                            </label>
                            <input type="text" id="album-name" name="name" class="p-2 border border-gray-300 w-full"
                                placeholder="Nama Album" autocomplete="off">
                        </div>
                        <button
                            class="w-full bg-yellow-300 hover:bg-yellow-400 transition duration-100 text-white p-2 rounded-md mt-4"
                            type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
