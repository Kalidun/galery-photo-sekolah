<script>
    function showToast(type, message) {
        const toastrContainer = document.getElementById('toastr-container');
        const toast = document.createElement('div');

        toast.classList.add(
            'flex', 'items-center', 'gap-2', 'px-4', 'py-3', 'rounded-md', 'shadow-md', 'transition-opacity',
            'duration-300', 'opacity-0'
        );

        switch (type) {
            case 'success':
                toast.classList.add('bg-green-500', 'text-white');
                break;
            case 'error':
                toast.classList.add('bg-red-500', 'text-white');
                break;
            case 'info':
                toast.classList.add('bg-blue-500', 'text-white');
                break;
            default:
                toast.classList.add('bg-gray-500', 'text-white');
        }

        toast.innerHTML = `
          <span>${message}</span>
          <button onclick="this.parentElement.remove()" class="text-xl ml-2 transition duration-300">&times;</button>
      `;

        toastrContainer.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('opacity-100');
        }, 100);

        setTimeout(() => {
            toast.classList.remove('opacity-100');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }

    @if (session('success'))
        showToast('success', '{{ session('success') }}');
    @endif
    @if (session('error'))
        showToast('error', '{{ session('error') }}');
    @endif
    @if (session('info'))
        showToast('info', '{{ session('info') }}');
    @endif
</script>
