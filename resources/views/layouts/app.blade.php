<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'KANG Sistema de Inventarios')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    @auth
        <div class="min-h-screen lg:flex">
            <aside class="bg-slate-950 text-white lg:fixed lg:inset-y-0 lg:flex lg:w-72 lg:flex-col">
                <div class="flex items-center justify-between border-b border-white/10 px-6 py-5 lg:block">
                    <a href="{{ route(auth()->user()->can('manage products') ? 'dashboard' : 'movements.index') }}" class="flex items-center gap-3">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-blue-500 text-lg font-black text-white shadow-lg shadow-blue-950/40">K</span>
                        <span>
                            <span class="block text-lg font-bold tracking-tight">KANG Sistema de Inventarios</span>
                            <span class="block text-xs font-medium text-slate-400">Control de inventario</span>
                        </span>
                    </a>
                </div>

                <nav class="flex gap-2 overflow-x-auto px-4 py-3 lg:flex-1 lg:block lg:space-y-2 lg:px-4 lg:py-8">
                    @if (auth()->user()->can('manage products'))
                        <a href="{{ route('dashboard') }}" class="flex shrink-0 items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-300 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-950/30' : '' }}">
                            <svg aria-hidden="true" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4h6v6H4V4Zm10 0h6v6h-6V4ZM4 14h6v6H4v-6Zm10 0h6v6h-6v-6Z" /></svg>
                            Dashboard
                        </a>
                    @endif
                    @if (auth()->user()->can('manage products'))
                        <a href="{{ route('products.index') }}" class="flex shrink-0 items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-300 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('products.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-950/30' : '' }}">
                            <svg aria-hidden="true" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m4 7 8-4 8 4-8 4-8-4Zm0 0v10l8 4 8-4V7M12 11v10" /></svg>
                            Productos
                        </a>
                    @endif
                    @if (auth()->user()->can('register movements'))
                        <a href="{{ route('movements.index') }}" class="flex shrink-0 items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-300 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('movements.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-950/30' : '' }}">
                            <svg aria-hidden="true" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 5v14m0 0-3-3m3 3 3-3M16 19V5m0 0 3 3m-3-3-3 3" /></svg>
                            Movimientos
                        </a>
                    @endif
                    @if (auth()->user()->can('manage operators'))
                        <a href="{{ route('operators.index') }}" class="flex shrink-0 items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-300 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('operators.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-950/30' : '' }}">
                            <svg aria-hidden="true" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-7.5 15a7.5 7.5 0 0 1 15 0" /></svg>
                            Operarios
                        </a>
                    @endif
                </nav>

                <div class="hidden border-t border-white/10 p-4 lg:block">
                    <div class="flex items-center gap-3 rounded-xl bg-white/5 p-3">
                        <span class="flex size-10 items-center justify-center rounded-full bg-blue-500/20 text-sm font-bold text-blue-300">{{ str($user = auth()->user()->name)->substr(0, 1)->upper() }}</span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs capitalize text-slate-400">{{ auth()->user()->getRoleNames()->first() }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full rounded-xl px-4 py-2.5 text-left text-sm font-semibold text-slate-400 transition hover:bg-red-500/10 hover:text-red-300">Cerrar sesión</button>
                    </form>
                </div>
            </aside>

            <div class="min-w-0 flex-1 lg:ml-72">
                <header class="flex items-center justify-between border-b border-slate-200 bg-white px-5 py-4 shadow-sm lg:px-10">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-600">Panel operativo</p>
                        <p class="mt-1 text-sm text-slate-500">{{ now()->translatedFormat('l, d \d\e F') }}</p>
                    </div>
                    <div class="flex items-center gap-3 lg:hidden">
                        <span class="text-right">
                            <span class="block text-sm font-bold text-slate-800">{{ auth()->user()->name }}</span>
                            <span class="block text-xs capitalize text-slate-500">{{ auth()->user()->getRoleNames()->first() }}</span>
                        </span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-bold text-slate-600">Salir</button>
                        </form>
                    </div>
                </header>

                <main class="mx-auto max-w-7xl px-5 py-8 lg:px-10">
                    @if (session('status'))
                        <div class="mb-6 flex items-center gap-3 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-800" role="status">
                            <span class="flex size-6 items-center justify-center rounded-full bg-blue-600 text-xs text-white">✓</span>
                            {{ session('status') }}
                        </div>
                    @endif
                    @yield('content')
                </main>
            </div>
        </div>
    @else
        <main class="flex min-h-screen items-center justify-center bg-slate-100 px-5 py-10">
            <div class="w-full max-w-md">
                <a href="{{ route('login') }}" class="mb-8 flex items-center justify-center gap-3">
                    <span class="flex size-11 items-center justify-center rounded-xl bg-blue-700 text-xl font-black text-white shadow-lg shadow-blue-200">K</span>
                    <span class="text-xl font-black tracking-tight text-slate-950">KANG Sistema de Inventarios</span>
                </a>
                @yield('content')
            </div>
        </main>
    @endauth
</body>
</html>