<nav class="bg-yellow-300 flex justify-between px-4 shadow select-none">
    <div class="px-3 py-1 flex flex-col justify-center items-start">
        @hasSection('page-title')
            <div class="text-base font-bold">Gallery App</div>
            <div class="flex gap-1 py-[0.1rem]">
                <div class="text-xs font-medium">
                    Gallery App -
                    @yield('page-title')
                    @hasSection('page-subtitle')
                        -
                        @yield('page-subtitle')
                    @endif
                </div>
            </div>
        @else
            <a href="{{ route('home') }}" class="text-xl font-bold py-2">
                Gallery App
            </a>
        @endif
    </div>
    <a href="{{ route('logout') }}" class="p-3 hover:bg-yellow-200 rounded transition-all duration-100">
        Logout
    </a>
</nav>
