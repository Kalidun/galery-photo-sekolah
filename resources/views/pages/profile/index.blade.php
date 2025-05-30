@extends('layout.app-layout')

@section('title', 'Profile | Galery App')

@section('page-title', 'Profile')

@section('main-content')
    <div class="px-4 flex flex-col gap-2 items-center h-full max-h-[90vh] overflow-y-auto">
        <div class="flex flex-col gap-2 items-center mb-6 pb-2 w-full">
            @if ($profile_image != null)
                <img src="{{ asset('storage/profile/' . $profile_image) }}" class="w-1/6 rounded-full">
            @else
                <img src="{{ asset('assets/images/profile-image.jpg') }}" class="w-1/6 rounded-full border border-black">
            @endif
            <div class="text-xl font-bold">
                {{ $name }}
            </div>
            <div class="flex gap-4">
                <a href="{{ route('profile.edit') }}"
                    class="px-4 py-2 bg-yellow-300 hover:bg-yellow-400 transition-colors duration-100 rounded-xl">Edit
                    Profile</a>
                <a href="{{ route('photos.index') }}"
                    class="px-4 py-2 bg-yellow-300 hover:bg-yellow-400 transition-colors duration-100 rounded-xl">Add
                    Photo</a>
            </div>
        </div>
        <div class="w-full flex flex-col gap-2 p-4 h-full border-t-2 border-yellow-300">
            <div class="w-full text-center font-bold text-xl">Galeri Kamu</div>
            <div class="columns-2 md:columns-3 lg:columns-4 xl:columns-5 gap-2 px-2 py-6 space-y-2">
                @foreach ($photoData as $photo)
                    <div onclick="setImage('{{ asset('storage/images/' . $photo->image) }}', {{ $photo->id }})" data-modal-target="image-modal" data-modal-toggle="image-modal" class="p-2 border border-gray-300 rounded-md bg-white hover:scale-105 transition duration-100">
                        <img src="{{ asset('storage/images/' . $photo->image) }}" class="w-ful">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="image-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Foto
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="image-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div id="image-container" class="p-4 md:p-5 space-y-4">

                </div>
                <div class="flex justify-between items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="image-modal" onclick="onEdit()" type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Edit</button>
                    <button data-modal-hide="image-modal" type="button" onclick="onDelete()"
                        class="text-red-600 bg-red-100 hover:bg-red-200 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const imageContainer = document.getElementById('image-container');

        const setImage = (image, id) => {
            imageContainer.innerHTML = `
                <img src="${image}" class="w-full" id="${id}">
            `
        }
        const onEdit = () => {
            const id = imageContainer.querySelector('img').id

            window.location.href = `{{ route('photos.edit', ':id') }}`.replace(':id', id)
        }
        const onDelete = () => {
            const id = imageContainer.querySelector('img').id

            fetch(`{{ route('photos.destroy', ':id') }}`.replace(':id', id), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(res => {
                if (res.ok) {
                    location.reload();
                }
            })
        }
    </script>
@endsection
