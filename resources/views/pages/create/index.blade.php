@extends('layout.app-layout')

@section('title', 'Create | Gallery App')

@section('page-title', 'Create')

@section('content')
    <form action="{{ route('create.store') }}" class="flex gap-8 w-full" method="POST" enctype="multipart/form-data"
        onsubmit="return validateForm()">
        @csrf
        <div class="flex flex-col gap-2 w-1/4">
            <input type="file" accept="image/*" name="image"
                class="p-2 border border-gray-300 rounded-md w-full bg-white focus:outline-none" required>
            <div id="preview-image"
                class="w-full max-h-[30rem] overflow-auto p-2 border border-gray-300 rounded-md text-center bg-white">
                Preview Image
            </div>
            <div class="flex gap-2">
                <div class="flex gap-2 items-center">
                    <input checked type="radio" id="private" name="is_public" value="0"
                        class="border border-gray-300 rounded-md p-2" required>
                    <label for="private">Private</label>
                </div>
                <div class="flex gap-2 items-center">
                    <input type="radio" id="public" name="is_public" value="1"
                        class="border border-gray-300 rounded-md p-2" required>
                    <label for="public">Public</label>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-2 w-3/4 px-4 overflow-y-auto max-h-[90vh]">
            <div class="flex flex-col gap-1">
                <label for="description">Description</label>
                <textarea required placeholder="Description" name="description" id="description" cols="30" rows="10"
                    class="p-2 border border-gray-300 rounded-md w-full bg-white focus:outline-none resize-none"></textarea>
            </div>

            <div class="flex flex-col gap-2">
                <label for="categories">Categories</label>
                <div id="tag-container" class="flex flex-wrap gap-2 p-2 border border-gray-300 rounded-md bg-white">
                    <input type="text" id="tag-input" placeholder="Add a category"
                        class="p-2 border-none outline-none flex-grow">
                </div>
                <small class="text-gray-500">Press 'Enter' to add category</small>
                <div id="category-error" class="text-red-500 mt-1 hidden">Please add at least one category.</div>
            </div>

            <button
                class="w-1/6 bg-yellow-400 text-white p-2 rounded-md mt-4 hover:bg-yellow-500 hover:text-black transition duration-100"
                type="submit">Create Post</button>
        </div>
    </form>

    <script>
        const imageInput = document.querySelector('input[name="image"]');
        const previewImage = document.getElementById('preview-image');
        const tagContainer = document.getElementById('tag-container');
        const tagInput = document.getElementById('tag-input');
        const categoryError = document.getElementById('category-error');

        imageInput.addEventListener('change', function() {
            const file = imageInput.files[0];
            const reader = new FileReader();

            reader.addEventListener('load', function() {
                const imageUrl = reader.result;
                previewImage.innerHTML =
                    `<img src="${imageUrl}" alt="Preview Image" class="w-full">`;
            });

            if (file) {
                reader.readAsDataURL(file);
            } else {
                previewImage.innerHTML = '';
            }
        });

        function addTag(tag) {
            const tagElement = document.createElement('span');
            tagElement.classList.add('tag', 'flex', 'items-center', 'gap-1', 'bg-yellow-400', 'rounded-md', 'p-1');

            const tagText = document.createElement('span');
            tagText.textContent = tag;
            tagText.classList.add('text-gray-700');

            const removeButton = document.createElement('button');
            removeButton.innerHTML = '&times;';
            removeButton.classList.add('text-red-500', 'cursor-pointer');
            removeButton.onclick = () => {
                tagContainer.removeChild(tagElement);
                validateCategories();
            };

            tagElement.appendChild(tagText);
            tagElement.appendChild(removeButton);

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'categories[]';
            hiddenInput.value = tag;
            tagElement.appendChild(hiddenInput);

            tagContainer.insertBefore(tagElement, tagInput);
            tagInput.value = '';
            validateCategories();
        }

        tagInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                const tag = tagInput.value.trim();
                if (tag) addTag(tag);
            }
        });

        function validateCategories() {
            const categoryCount = document.querySelectorAll('input[name="categories[]"]').length;
            if (categoryCount < 1) {
                categoryError.classList.remove('hidden');
                return false;
            } else {
                categoryError.classList.add('hidden');
                return true;
            }
        }

        function validateForm() {
            return validateCategories();
        }
    </script>
@endsection
