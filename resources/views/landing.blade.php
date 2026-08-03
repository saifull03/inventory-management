<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="mx-auto flex min-h-screen max-w-6xl flex-col justify-center px-6 py-16">
        <div class="rounded-3xl border border-slate-800 bg-slate-900/80 p-8 shadow-2xl shadow-black/30 backdrop-blur sm:p-10">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-cyan-400">Inventory Management System</p>
                    <h1 class="mt-4 text-4xl font-semibold sm:text-5xl">Manage warehouses, products, and reports from one place.</h1>
                    <p class="mt-5 max-w-xl text-lg text-slate-300">
                        This Laravel app includes CRUD for warehouses, categories, item types, products, a dashboard, and CSV reporting.
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="rounded-lg bg-cyan-500 px-5 py-3 text-center font-semibold text-slate-950 transition hover:bg-cyan-400">
                            Sign in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-lg border border-slate-700 px-5 py-3 text-center font-semibold text-slate-100 transition hover:bg-slate-800">
                                Create account
                            </a>
                        @endif
                    @endif
                </div>
            </div>

            <div class="mt-10 grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl border border-slate-800 bg-slate-800/70 p-5">
                    <h2 class="font-semibold text-white">Demo account</h2>
                    <p class="mt-2 text-sm text-slate-400">Email: test@example.com</p>
                    <p class="text-sm text-slate-400">Password: password</p>
                </div>
                <div class="rounded-2xl border border-slate-800 bg-slate-800/70 p-5">
                    <h2 class="font-semibold text-white">Inventory tools</h2>
                    <p class="mt-2 text-sm text-slate-400">Create products, assign warehouses, and keep categories organized.</p>
                </div>
                <div class="rounded-2xl border border-slate-800 bg-slate-800/70 p-5">
                    <h2 class="font-semibold text-white">Reports</h2>
                    <p class="mt-2 text-sm text-slate-400">Review inventory summaries and export the full catalog as CSV.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
