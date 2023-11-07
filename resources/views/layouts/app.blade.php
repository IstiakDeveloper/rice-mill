<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Rice Mill</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='48' height='48' viewBox='0 0 172 172' style=' fill:%2326e07f;'%3E%3Cpath d='M0,172v-172h172v172z' fill='none'/%3E%3Cpath fill='%231fb141' d='M21.5,21.5v129h64.5v-32.25v-64.5v-32.25zM86,53.75c0,17.7805 14.4695,32.25 32.25,32.25c17.7805,0 32.25,-14.4695 32.25,-32.25c0,-17.7805 -14.4695,-32.25 -32.25,-32.25c-17.7805,0 -32.25,14.4695 -32.25,32.25zM118.25,86c-17.7805,0 -32.25,14.4695 -32.25,32.25c0,17.7805 14.4695,32.25 32.25,32.25c17.7805,0 32.25,-14.4695 32.25,-32.25c0,-17.7805 -14.4695,-32.25 -32.25,-32.25z' /%3E%3C/svg%3E" type="image/svg+xml">
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
<body class="h-screen overflow-hidden flex items-center justify-center" style="background: #edf2f7;">
    <div class="w-full">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
        <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>

        <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex items-center justify-center mt-8">
                <div class="flex items-center">
                    <a href="{{route('dashboard')}}"><span class="mx-2 text-2xl font-semibold text-white">Rice Mill Admin</span></a>
                </div>
            </div>

            <nav class="mt-10">
                <div class="relative group">
                    <a href="{{route('dashboard')}}"
                       class="flex items-center px-6 py-2 mt-4 group-hover:bg-gray-700 group-hover:bg-opacity-25 group-hover:text-gray-100 cursor-pointer"
                       :class="{ 'text-gray-100 bg-gray-700 bg-opacity-25': isActive('dashboard'), 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100': !isActive('dashboard') }"
                       @click="toggleDropdown('dashboardDropdown')">
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z" />
                      </svg>
                        <span class="mx-3">Home</span>
                    </a>
                </div>

                <div class="relative group">
                    <a href="{{route('customers.index')}}"
                       class="flex items-center px-6 py-2 mt-4 group-hover:bg-gray-700 group-hover:bg-opacity-25 group-hover:text-gray-100 cursor-pointer {{ request()->routeIs('customers.*') ? 'active-menu' : '' }}"
                       :class="{ 'text-gray-100 bg-gray-700 bg-opacity-25': isActive('customers.index'), 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100': !isActive('customers.index') }"
                       @click="toggleDropdown('dashboardDropdown')">
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                      </svg>
                        <span class="mx-3">Customers</span>
                    </a>
                </div>

                <div class="relative group">
                    <a href="{{route('charges.index')}}"
                       class="flex items-center px-6 py-2 mt-4 group-hover:bg-gray-700 group-hover:bg-opacity-25 group-hover:text-gray-100 cursor-pointer {{ request()->routeIs('charges.*') ? 'active-menu' : '' }}"
                       :class="{ 'text-gray-100 bg-gray-700 bg-opacity-25': isActive('charges.index'), 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100': !isActive('charges.index') }"
                       @click="toggleDropdown('dashboardDropdown')">
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                      </svg>
                        <span class="mx-3">Auto Charges</span>
                    </a>
                </div>

                <div class="relative group">
                    <a href="{{route('expenses.index')}}"
                       class="flex items-center px-6 py-2 mt-4 group-hover:bg-gray-700 group-hover:bg-opacity-25 group-hover:text-gray-100 cursor-pointer {{ request()->routeIs('expenses.*') ? 'active-menu' : '' }}"
                       :class="{ 'text-gray-100 bg-gray-700 bg-opacity-25': isActive('expenses.index'), 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100': !isActive('expenses.index') }"
                       @click="toggleDropdown('dashboardDropdown')">
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                      </svg>
                        <span class="mx-3">Expenses</span>
                    </a>
                </div>

                <div class="relative group">
                    <a href="{{route('accounts.index')}}"
                       class="flex items-center px-6 py-2 mt-4 group-hover:bg-gray-700 group-hover:bg-opacity-25 group-hover:text-gray-100 cursor-pointer {{ request()->routeIs('accounts.*') ? 'active-menu' : '' }}"
                       :class="{ 'text-gray-100 bg-gray-700 bg-opacity-25': isActive('accounts.index'), 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100': !isActive('accounts.index') }"
                       @click="toggleDropdown('dashboardDropdown')">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3" />
                      </svg>
                        <span class="mx-3">Accounts</span>
                    </a>
                </div>
{{--
                <!-- <div class="relative group">
                    <a
                       class="flex items-center px-6 py-2 mt-4 text-gray-500 group-hover:bg-gray-700 group-hover:bg-opacity-25 group-hover:text-gray-100 cursor-pointer {{ request()->routeIs('branches.*', 'departments.*', 'designations.*', 'leave_types.*', 'payslip_types.*', 'allowance_options.*', 'deduction_options.*', 'loan_options.*', 'job_categories.*') ? 'active-menu' : '' }}"
                       @click="toggleDropdown('hrmDropdown')">
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      </svg>
                        <span class="mx-3">System Setup</span>
                    </a>


                    <div id="hrmDropdown" class="hidden mt-2 py-2 w-full bg-gray rounded-lg shadow-lg">
                        <a href="{{ route('branches.index') }}" class="block px-4 py-2 text-gray-100 hover:bg-gray-700 {{ request()->routeIs('branches.*') ? 'active-menu' : '' }}">Branches</a>
                        <a href="{{ route('departments.index') }}" class="block px-4 py-2 text-gray-100 hover:bg-gray-700 {{ request()->routeIs('departments.*') ? 'active-menu' : '' }}">Department</a>
                        <a href="{{ route('designations.index') }}" class="block px-4 py-2 text-gray-100 hover:bg-gray-700 {{ request()->routeIs('designations.*') ? 'active-menu' : '' }}">Designation</a>
                        <a href="{{ route('leave_types.index') }}" class="block px-4 py-2 text-gray-100 hover:bg-gray-700 {{ request()->routeIs('leave_types.*') ? 'active-menu' : '' }}">Leave Type</a>
                        <a href="{{ route('payslip_types.index') }}" class="block px-4 py-2 text-gray-100 hover:bg-gray-700 {{ request()->routeIs('payslip_types.*') ? 'active-menu' : '' }}">Payslip Type</a>
                        <a href="{{ route('allowance_options.index') }}" class="block px-4 py-2 text-gray-100 hover:bg-gray-700 {{ request()->routeIs('allowance_options.*') ? 'active-menu' : '' }}">Allowance Option</a>
                        <a href="{{ route('deduction_options.index') }}" class="block px-4 py-2 text-gray-100 hover:bg-gray-700 {{ request()->routeIs('deduction_options.*') ? 'active-menu' : '' }}">Deduction Option</a>
                        <a href="{{ route('loan_options.index') }}" class="block px-4 py-2 text-gray-100 hover:bg-gray-700 {{ request()->routeIs('loan_options.*') ? 'active-menu' : '' }}">Loan Option</a>
                         <a href="{{ route('job_categories.index') }}" class="block px-4 py-2 text-gray-100 hover:bg-gray-700 {{ request()->routeIs('job_categories.*') ? 'active-menu' : '' }}">Job Category</a>
                    </div>
                </div> -->
            </nav> --}}
        </div>
        <div class="flex flex-col flex-1 overflow-hidden">
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-indigo-600">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </svg>
                    </button>

                    <form action="{{ route('search') }}" method="GET" class="relative mx-4 lg:mx-0">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                            </svg>
                        </span>

                        <input class="w-full h-full pl-10 pr-4 py-4 rounded-md form-input sm:w-full" type="text"
                            placeholder="Search" name="query">
                    </form>
                </div>

                <div class="flex items-center">
                    <div x-data="{ notificationOpen: false }" class="relative">
                        <button @click="notificationOpen = ! notificationOpen"
                            class="flex mx-4 text-gray-600 focus:outline-none">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15 17H20L18.5951 15.5951C18.2141 15.2141 18 14.6973 18 14.1585V11C18 8.38757 16.3304 6.16509 14 5.34142V5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5V5.34142C7.66962 6.16509 6 8.38757 6 11V14.1585C6 14.6973 5.78595 15.2141 5.40493 15.5951L4 17H9M15 17V18C15 19.6569 13.6569 21 12 21C10.3431 21 9 19.6569 9 18V17M15 17H9"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                            </svg>
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
<script>
    function isActive(route) {
        return window.location.pathname.includes(route);
    }
    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        dropdown.classList.toggle('hidden');
    }
</script>
</body>
</html>
