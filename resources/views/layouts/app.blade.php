<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Rice Mill</title>
</head>
<style>
    input, select{
        border: 1px solid rgb(209, 196, 196);
        padding: 12px 5px;
        outline: none;
    }

    nav .active-menu {
        color: white !important;
        background-color: rgba(55,65,81,var(--tw-bg-opacity)) !important;
    }

</style>
<body class="overflow-auto flex items-center justify-center container mx-auto my-20 bg-gray-200">
    <div class="w-full">
        <div x-data="{ sidebarOpen: false }" class="flex">
            <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>

            <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-0 w-64 overflow-y-auto transition duration-300 transform bg-white lg:translate-x-0 lg:static lg:inset-0 rounded-lg shadow-lg mr-4">
                <div class="flex items-center justify-center mt-8">
                    <div class="flex items-center">
                        <a href="{{route('dashboard')}}"><span class="mx-2 text-2xl font-semibold text-white">Rice Mill Admin</span></a>
                    </div>
                </div>

                <nav class="mt-10">
                    <div class="relative group">
                        <a href="{{route('dashboard')}}"
                        class="flex items-center px-6 py-2 mt-4 group-hover:bg-gray-700 group-hover:bg-opacity-25 group-hover:text-gray-900 cursor-pointer"
                        :class="{ 'text-gray-900 bg-gray-700 bg-opacity-25': isActive('dashboard'), 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-900': !isActive('dashboard') }"
                        @click="toggleDropdown('dashboardDropdown')">
                        <x-lucide-home class="h-5 w-5"/>
                            <span class="mx-3">Home</span>
                        </a>
                    </div>

                    <div class="relative group">
                        <a href="{{route('customers.index')}}"
                        class="flex items-center px-6 py-2 mt-4 group-hover:bg-gray-700 group-hover:bg-opacity-25 group-hover:text-gray-900 cursor-pointer {{ request()->routeIs('customers.*') ? 'active-menu' : '' }}"
                        :class="{ 'text-gray-900 bg-gray-700 bg-opacity-25': isActive('customers.index'), 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-900': !isActive('customers.index') }"
                        @click="toggleDropdown('dashboardDropdown')">
                        <x-lucide-users class="h-5 w-5"/>
                            <span class="mx-3">Customers</span>
                        </a>
                    </div>

                    <div class="relative group">
                        <a href="{{route('charges.index')}}"
                        class="flex items-center px-6 py-2 mt-4 group-hover:bg-gray-700 group-hover:bg-opacity-25 group-hover:text-gray-900 cursor-pointer {{ request()->routeIs('charges.*') ? 'active-menu' : '' }}"
                        :class="{ 'text-gray-900 bg-gray-700 bg-opacity-25': isActive('charges.index'), 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-900': !isActive('charges.index') }"
                        @click="toggleDropdown('dashboardDropdown')">
                        <x-lucide-battery-warning class="h-5 w-5"/>
                            <span class="mx-3">Auto Charges</span>
                        </a>
                    </div>

                    <div class="relative group">
                        <a href="{{route('expenses.index')}}"
                        class="flex items-center px-6 py-2 mt-4 group-hover:bg-gray-700 group-hover:bg-opacity-25 group-hover:text-gray-900 cursor-pointer {{ request()->routeIs('expenses.*') ? 'active-menu' : '' }}"
                        :class="{ 'text-gray-900 bg-gray-700 bg-opacity-25': isActive('expenses.index'), 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-900': !isActive('expenses.index') }"
                        @click="toggleDropdown('dashboardDropdown')">
                        <x-lucide-copy-plus class="h-5 w-5"/>
                            <span class="mx-3">Expenses</span>
                        </a>
                    </div>

                    <div class="relative group">
                        <a href="{{route('accounts.index')}}"
                        class="flex items-center px-6 py-2 mt-4 group-hover:bg-gray-700 group-hover:bg-opacity-25 group-hover:text-gray-900 cursor-pointer {{ request()->routeIs('accounts.*') ? 'active-menu' : '' }}"
                        :class="{ 'text-gray-900 bg-gray-700 bg-opacity-25': isActive('accounts.index'), 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-900': !isActive('accounts.index') }"
                        @click="toggleDropdown('dashboardDropdown')">
                        <x-lucide-building-2 class="h-5 w-5"/>
                            <span class="mx-3">Accounts</span>
                        </a>
                    </div>
                </nav>
            </div>
            <div class="flex flex-col flex-1 overflow-hidden">
                <header class="flex items-center justify-between px-6 py-4 bg-white border-b-2 border-indigo-600 rounded-lg shadow-lg">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                            <x-lucide-menu class="h-5 w-5"/>
                        </button>
                        <form action="{{ route('search') }}" method="GET" class="relative mx-4 lg:mx-0">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <x-lucide-search class="h-5 w-5 text-gray-500"/>
                            </span>
                            <input class="w-full h-full pl-10 pr-4 py-4 rounded-md form-input sm:w-full" type="text"
                                placeholder="Search" name="query">
                        </form>
                    </div>

                    <div class="flex items-center">
                        <div x-data="{ notificationOpen: false }" class="relative">
                            <button @click="notificationOpen = ! notificationOpen"
                                class="flex mx-4 text-gray-600 focus:outline-none">
                                <x-lucide-bell class="h-6 w-6"/>
                            </button>

                            <div x-show="notificationOpen" @click="notificationOpen = false"
                                class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>

                            <div x-show="notificationOpen"
                                class="absolute right-0 z-10 mt-2 overflow-hidden bg-white rounded-lg shadow-xl w-80"
                                style="width: 20rem; display: none;">
                                {{-- <a href="#"
                                    class="flex items-center px-4 py-3 -mx-2 text-gray-600 hover:text-white hover:bg-indigo-600">
                                    <img class="object-cover w-8 h-8 mx-1 rounded-full"
                                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=334&amp;q=80"
                                        alt="avatar">
                                    <p class="mx-2 text-sm">
                                        <span class="font-bold" href="#">Sara Salah</span> replied on the <span
                                            class="font-bold text-indigo-400" href="#">Upload Image</span> artical . 2m
                                    </p>
                                </a>
                                <a href="#"
                                    class="flex items-center px-4 py-3 -mx-2 text-gray-600 hover:text-white hover:bg-indigo-600">
                                    <img class="object-cover w-8 h-8 mx-1 rounded-full"
                                        src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=634&amp;q=80"
                                        alt="avatar">
                                    <p class="mx-2 text-sm">
                                        <span class="font-bold" href="#">Slick Net</span> start following you . 45m
                                    </p>
                                </a>


                                <a href="#"
                                    class="flex items-center px-4 py-3 -mx-2 text-gray-600 hover:text-white hover:bg-indigo-600">
                                    <img class="object-cover w-8 h-8 mx-1 rounded-full"
                                        src="https://images.unsplash.com/photo-1450297350677-623de575f31c?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=334&amp;q=80"
                                        alt="avatar">
                                    <p class="mx-2 text-sm">
                                        <span class="font-bold" href="#">Jane Doe</span> Like Your reply on <span
                                            class="font-bold text-indigo-400" href="#">Test with TDD</span> artical . 1h
                                    </p>
                                </a>
                                <a href="#"
                                    class="flex items-center px-4 py-3 -mx-2 text-gray-600 hover:text-white hover:bg-indigo-600">
                                    <img class="object-cover w-8 h-8 mx-1 rounded-full"
                                        src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=398&amp;q=80"
                                        alt="avatar">
                                    <p class="mx-2 text-sm">
                                        <span class="font-bold" href="#">Abigail Bennett</span> start following you . 3h
                                    </p>
                                </a> --}}
                            </div>
                        </div>

                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = ! dropdownOpen"
                                class="relative block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>

                            <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full"
                                style="display: none;"></div>

                            <div x-show="dropdownOpen"
                                class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl"
                                style="display: none;">
                                <a href="{{route('profile.edit')}}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Profile</a>
                                    <form action="{{route('logout')}}" method="POST">
                                        @csrf
                                        <button  class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white text-left w-full">Logout</button>
                                    </form>
                            </div>
                        </div>
                    </div>
                </header>
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                    <div class="container py-8 mx-auto ">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
<script>
    function isActive(route) {
        return window.location.pathname.includes(route);
    }
    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        dropdown.classList.toggle('hidden');
    }
</script>
<script src="{{asset('js/scripts.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
