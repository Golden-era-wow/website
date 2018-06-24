<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous" async> --}}
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-87DrmpqHRiY8hPLIr7ByqhPIywuSsjuQAfMXAE0sMUpY3BM7nXjf+mLIUSvhDArs" crossorigin="anonymous">

    <!-- Laravel scripts -->
    <script>
      window.Laravel = <?php echo json_encode([
        'apiToken' => Auth::user()->api_token ?? null,
        'algolia_app_id' => config('services.algolia.app_id'),
        'algolia_key' => config('services.algolia.search_key')
      ]); ?>
    </script>

    <!-- Import JS assets through Laravel -->
   @features
</head>
<body class="bg-grey-lightest h-screen bg-cover">
    <div id="app">
        <nav class="bg-brand-lightest h-12 shadow mb-8 px-6 md:px-0">
            <div class="container mx-auto h-full">
                <div class="flex items-center justify-center h-12">
                    <div class="mr-6">
                        <a href="{{ url('/') }}" class="no-underline">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>
                    <div class="flex-1 text-left">
                        @feature('armory')
                            <a class="no-underline hover:underline text-brand-darker pr-3 text-sm" href="{{ url('/armory') }}">
                                Armory
                            </a>
                        @endfeature

                        @auth
                            @feature('shop')
                                <a class="no-underline hover:underline text-brand-darker pr-3 text-sm" href="{{ url('/shop') }}">
                                    Shop
                                </a>
                            @endfeature
                        @endauth
                    </div>
                    <div class="flex-1 text-right">
                        @guest
                            <a class="no-underline hover:underline text-brand-darker pr-3 text-sm" href="{{ url('/login') }}">Login</a>
                            <a class="no-underline hover:underline text-brand-darker text-sm" href="{{ url('/register') }}">Register</a>
                        @else
                            <dropdown-menu class="float-right">
                                <span slot="link" class="text-brand-darker text-sm pr-4 cursor-pointer">{{ Auth::user()->name }}</span>

                                <ul class="list-reset flex flex-col" slot="content">
                                    <li class="p-4">
                                        <a class="no-underline hover:underline text-brand-darker text-sm" href="{{ url('settings') }}">
                                            {{ __('Settings') }}
                                        </a>
                                    </li>

                                    <li class="p-4">
                                        <a href="{{ route('logout') }}"
                                            class="no-underline hover:underline text-brand-darker text-sm"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();"
                                        >{{ __('Logout') }}</a>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        {{ csrf_field() }}
                                    </form>
                                </ul>
                            </dropdown-menu>
                        @endguest
                    </div>

                    <div class="text-right">
                        @auth
                            @feature('shop')
                                <a class="fa-layers fa-fw cursor-pointer no-underline text-black" href="{{ url('shopping-cart') }}">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span
                                        class="fa-layers-text text-brand-darkest"
                                        data-fa-transform="shrink-8 down-3"
                                        style="font-weight:900"
                                    >
                                        @{{ $store.getters.products.length }}
                                    </span>
                                </a>
                            @endfeature
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        @yield('content')

        <portal-target name="modals"></portal-target>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
