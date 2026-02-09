<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('products.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <rect width="9" height="9" x="1.5" y="1.5" fill="#fff" rx="1">
                                <animate id="SVGvBHXGeBR" attributeName="x" begin="0;SVGBBjjneux.end+0.15s"
                                    dur="0.6s" keyTimes="0;.2;1" values="1.5;.5;1.5" />
                                <animate attributeName="y" begin="0;SVGBBjjneux.end+0.15s" dur="0.6s"
                                    keyTimes="0;.2;1" values="1.5;.5;1.5" />
                                <animate attributeName="width" begin="0;SVGBBjjneux.end+0.15s" dur="0.6s"
                                    keyTimes="0;.2;1" values="9;11;9" />
                                <animate attributeName="height" begin="0;SVGBBjjneux.end+0.15s" dur="0.6s"
                                    keyTimes="0;.2;1" values="9;11;9" />
                            </rect>
                            <rect width="9" height="9" x="13.5" y="1.5" fill="#fff" rx="1">
                                <animate attributeName="x" begin="SVGvBHXGeBR.begin+0.15s" dur="0.6s"
                                    keyTimes="0;.2;1" values="13.5;12.5;13.5" />
                                <animate attributeName="y" begin="SVGvBHXGeBR.begin+0.15s" dur="0.6s"
                                    keyTimes="0;.2;1" values="1.5;.5;1.5" />
                                <animate attributeName="width" begin="SVGvBHXGeBR.begin+0.15s" dur="0.6s"
                                    keyTimes="0;.2;1" values="9;11;9" />
                                <animate attributeName="height" begin="SVGvBHXGeBR.begin+0.15s" dur="0.6s"
                                    keyTimes="0;.2;1" values="9;11;9" />
                            </rect>
                            <rect width="9" height="9" x="13.5" y="13.5" fill="#fff" rx="1">
                                <animate attributeName="x" begin="SVGvBHXGeBR.begin+0.3s" dur="0.6s"
                                    keyTimes="0;.2;1" values="13.5;12.5;13.5" />
                                <animate attributeName="y" begin="SVGvBHXGeBR.begin+0.3s" dur="0.6s"
                                    keyTimes="0;.2;1" values="13.5;12.5;13.5" />
                                <animate attributeName="width" begin="SVGvBHXGeBR.begin+0.3s" dur="0.6s"
                                    keyTimes="0;.2;1" values="9;11;9" />
                                <animate attributeName="height" begin="SVGvBHXGeBR.begin+0.3s" dur="0.6s"
                                    keyTimes="0;.2;1" values="9;11;9" />
                            </rect>
                            <rect width="9" height="9" x="1.5" y="13.5" fill="#fff" rx="1">
                                <animate id="SVGBBjjneux" attributeName="x" begin="SVGvBHXGeBR.begin+0.45s"
                                    dur="0.6s" keyTimes="0;.2;1" values="1.5;.5;1.5" />
                                <animate attributeName="y" begin="SVGvBHXGeBR.begin+0.45s" dur="0.6s"
                                    keyTimes="0;.2;1" values="13.5;12.5;13.5" />
                                <animate attributeName="width" begin="SVGvBHXGeBR.begin+0.45s" dur="0.6s"
                                    keyTimes="0;.2;1" values="9;11;9" />
                                <animate attributeName="height" begin="SVGvBHXGeBR.begin+0.45s" dur="0.6s"
                                    keyTimes="0;.2;1" values="9;11;9" />
                            </rect>
                        </svg>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if (auth()->user()->isAdmin())
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Admin Dashboard') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        @endif
                    @endauth

                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                        {{ __('Products') }}
                    </x-nav-link>

                    @auth
                        @if (auth()->user()->isAdmin())
                            <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                                {{ __('Categories') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.fournisseurs.index')" :active="request()->routeIs('admin.fournisseurs.*')">
                                {{ __('Fournisseurs') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                                {{ __('Orders') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.stock.dashboard')" :active="request()->routeIs('admin.stock.*')">
                                {{ __('Stock') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @if (!auth()->check() || !auth()->user()?->isAdmin())
                    <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="1.5"
                                d="M10.5 10h4m-2-2v4m4 9a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3m-8 0a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3M3.71 5.4h15.214c1.378 0 2.373 1.27 1.995 2.548l-1.654 5.6C19.01 14.408 18.196 15 17.27 15H8.112c-.927 0-1.742-.593-1.996-1.452zm0 0L3 3" />
                        </svg>
                        @php
                            $cart = \App\Models\Cart::getOrCreate();
                            $count = $cart->getItemsCount();
                        @endphp
                        @if ($count > 0)
                            <span class="ml-1 bg-red-600 text-white text-xs px-2 py-1 rounded-full">
                                {{ $count }}
                            </span>
                        @endif
                    </x-nav-link>
                @endif

                @auth
                    @if (auth()->user()->role_id == 3)
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5">
                                    <path
                                        d="M17.616 19.75a3.64 3.64 0 0 0 3.634-3.645a3.64 3.64 0 0 0-3.634-3.645a3.64 3.64 0 0 0-3.634 3.645a3.64 3.64 0 0 0 3.634 3.645m-11.232 0a3.64 3.64 0 0 0 3.634-3.645a3.64 3.64 0 0 0-3.634-3.645a3.64 3.64 0 0 0-3.634 3.645a3.64 3.64 0 0 0 3.634 3.645" />
                                    <path
                                        d="M10.018 16.105V6.16c0-3.004-3.364-2.042-4.17 0c0 0-2.004 6.294-2.933 8.849m7.103-3.519s.681.674 1.982.674s1.982-.674 1.982-.674m-3.964 3.645s.681.674 1.982.674s1.982-.674 1.982-.674m0 .971V6.16c0-3.004 3.364-2.042-4.17 0c0 0 2.004 6.294 2.933 8.849" />
                                </g>
                            </svg>
                        </x-nav-link>
                    @endif

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}"
                            class="text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Log
                            in</a>
                        <a href="{{ route('register') }}"
                            class="text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Register</a>
                    </div>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if (auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Admin Dashboard') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                @endif
            @endauth

            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                {{ __('Products') }}
            </x-responsive-nav-link>

            @auth
                @if (auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                        {{ __('Categories') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.fournisseurs.index')" :active="request()->routeIs('admin.fournisseurs.*')">
                        {{ __('Fournisseurs') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                        {{ __('Orders') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.stock.dashboard')" :active="request()->routeIs('admin.stock.*')">
                        {{ __('Stock') }}
                    </x-responsive-nav-link>
                @endif
            @endauth

            @if (!auth()->check() || !auth()->user()?->isAdmin())
                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                    {{ __('Cart') }}
                    @php
                        $cart = \App\Models\Cart::getOrCreate();
                        $count = $cart->getItemsCount();
                    @endphp
                    @if ($count > 0)
                        <span class="ml-1 bg-red-600 text-white text-xs px-2 py-1 rounded-full">
                            {{ $count }}
                        </span>
                    @endif
                </x-responsive-nav-link>
            @endif

            @auth
                @if (auth()->user()->role_id == 3)
                    <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                        {{ __('Orders') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        @endauth
    </div>
</nav>