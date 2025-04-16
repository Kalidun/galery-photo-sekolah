@extends('layout.app-layout')

@section('title', 'Dashboard | Galery App')

@section('page-title', 'Dashboard')

@section('main-content')
    <div class="flex flex-col gap-2 max-h-[90vh] overflow-y-auto">
        <div class="overflow-y-auto columns-2 md:columns-3 lg:columns-4 xl:columns-5 max-h-[92vh] gap-2 px-2 py-6 space-y-2">
            @foreach ($postData as $post)
                <div data-modal-target="image-modal" data-modal-toggle="image-modal"
                    class="p-2 border border-gray-300 rounded-md bg-white hover:scale-105 transition duration-100"
                    onclick="setData({{ $post->id }}, '{{ asset('storage/images/' . $post->image) }}')">
                    <img src="{{ asset('storage/images/' . $post->image) }}" class="w-full">
                </div>
            @endforeach
        </div>
    </div>
    <div id="image-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-4 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-[calc(100vh-3rem)]">
        <div class="relative w-full max-w-4xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 w-full">
                <div class="flex flex-col xs:flex-row w-full min-h-[25rem] max-h-[30rem]">
                    <div id="image-container"
                        class="w-full xs:w-1/2 flex items-center bg-black max-h-[35rem] overflow-y-auto"></div>
                    <div class="w-full xs:w-1/2 border-gray-200 rounded-b dark:border-gray-600">
                        <div class="p-1 flex justify-between h-[10%] xs:h-[12%] border-b border-gray-200 items-center">
                            <div class="flex gap-2 max-w-10">
                                <img id="profile-image" class="w-[2rem] sm:w-[3rem] border border-gray-300 p-2 rounded-full"
                                    src="{{ asset('assets/images/profile-image.jpg') }}">
                                <span id="username-container" class="flex items-center">{{ auth()->user()->name }}</span>
                            </div>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="image-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <div class="h-[80%] xs:h-[80%] border-b border-gray-200">
                            <div id="desc-container" class="h-[90%] max-h-[90%] overflow-y-auto p-4">
                            </div>
                            <form action="#" class="h-[10%] max-h-[10%] w-full flex border-t border-gray-200"
                                id="comment-form" data-photo-id="">
                                <input class="w-[90%] focus:outline-none focus:ring-0 border-none" type="text"
                                    name="comment" id="comment_input" placeholder="Type here to add a Comment" />
                                <button
                                    class="w-[10%] text-yellow-300 hover:text-black transition-all duration-100">Post</button>
                            </form>
                        </div>
                        <div class="h-[10%] xs:h-[7%] p-2 flex gap-2">
                            <i id="like-icon" onclick="toggleLike()"
                                class="cursor-pointer fa-regular fa-heart text-red-600 text-2xl"></i>
                            <div class="text-sm" id="like-count">
                                999
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const imageContainer = document.getElementById('image-container');
        const usernameContainer = document.getElementById('username-container');
        const profileImage = document.getElementById('profile-image');
        const likeIcon = document.getElementById('like-icon')
        const descContainer = document.getElementById('desc-container');
        const likeCount = document.getElementById('like-count');
        const commentForm = document.getElementById('comment-form')
        const commentInput = document.getElementById('comment_input')

        function commentComponent(data) {
            let posterImage = data.posterImage ? `{{ asset('storage/profile/') }}/${data.posterImage}` : "{{ asset('assets/images/profile-image.jpg') }}"
            let posterName = data.posterName ? data.posterName : data.user.name
            let comment = data.photoDescription ?? data.comment

            return `
                <div class="flex items-center gap-3 mb-3">
                    <img src="${posterImage}" class="w-9 h-9 rounded-full border border-gray-300 object-cover">
                    <div class="bg-white p-1 rounded-md">
                        <span class="font-semibold">${posterName}</span>
                        <p class="text-sm">${comment}</p>
                    </div>
                </div>
            `;
        }


        async function setData(photo_id, image) {
            imageContainer.innerHTML = ``
            usernameContainer.innerText = ``
            descContainer.innerHTML = ``
            imageContainer.innerHTML = `
            <img src="${image}" class="w-full" id="image">`

            const data = await getData(photo_id)

            commentForm.setAttribute('data-photo-id', photo_id)
            usernameContainer.innerText = data.posterName
            profileImage.src = data.posterImage ? `{{ asset('storage/profile/') }}/${data.posterImage}` : "{{ asset('assets/images/profile-image.jpg') }}"
            likeCount.innerText = data.likeCount

            if(data.isLiked) {
                if(likeIcon.classList.contains('fa-regular')) {
                    likeIcon.classList.remove('fa-regular')
                    likeIcon.classList.add('fa-solid')
                } 
            } else {
                if(likeIcon.classList.contains('fa-solid')) {
                    likeIcon.classList.remove('fa-solid')
                    likeIcon.classList.add('fa-regular')
                }
            }

            if (data.photoDescription) {
                descContainer.insertAdjacentHTML('beforeend', commentComponent({
                    posterImage: data.posterImage,
                    posterName: data.posterName,
                    comment: data.photoDescription
                }))
            }

            data.comments.forEach(comment => {
                descContainer.insertAdjacentHTML('beforeend', commentComponent(comment))
            })
        }


        async function getData(photo_id) {
            const response = await fetch(`{{ route('home.get-data', ':id') }}`.replace(':id', photo_id), {
                method: 'GET',
            })

            const data = await response.json()
            return data
        }

        const toggleLike = () => {
            let photo_id = commentForm.getAttribute('data-photo-id')
            if (likeIcon.classList.contains('fa-regular')) {
                fetch(`{{ route('like.store') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        'photo_id': photo_id
                    })
                }).then(() => {
                    setData(photo_id, imageContainer.querySelector('img').src)
                })
            } else{
                fetch(`{{ route('like.destroy') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        'photo_id': photo_id
                    })
                }).then(() => {
                    setData(photo_id, imageContainer.querySelector('img').src)
                })
            }
        }

        document.getElementById('comment-form').addEventListener('submit', async (e) => {
            e.preventDefault()
            const comment = commentInput.value
            const photo_id = commentForm.getAttribute('data-photo-id')

            const response = await fetch(`{{ route('comment.store') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    'photo_id': photo_id,
                    'comment': comment
                })
            })

            if (response.ok) {
                const data = await response.json()
                descContainer.insertAdjacentHTML('beforeend', commentComponent(data))

                commentInput.value = ''
            } else {
                alert('Something went wrong')
            }
        })
    </script>
@endsection
