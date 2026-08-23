<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kepesertaan 2.0 - Laravel Setup</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-6 antialiased">
    <div class="max-w-2xl w-full bg-slate-800/90 border border-slate-700/80 rounded-2xl p-8 shadow-2xl backdrop-blur">
        <!-- Header -->
        <div class="flex items-center justify-between pb-6 border-b border-slate-700">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 mb-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Issue #2 Resolved
                </span>
                <h1 class="text-2xl font-bold tracking-tight text-white">Project Setup: Laravel + Tailwind + MySQL</h1>
                <p class="text-sm text-slate-400 mt-1">Sistem Kepesertaan 2.0 telah berhasil diinisialisasi.</p>
            </div>
            <div class="hidden sm:flex h-12 w-12 items-center justify-center rounded-xl bg-red-500/10 text-red-400 font-bold border border-red-500/20">
                L
            </div>
        </div>

        <!-- Tech Stack Status Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 my-6">
            <!-- Laravel -->
            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-700/60">
                <div class="text-xs text-slate-400 font-medium">Framework</div>
                <div class="text-base font-semibold text-white mt-1">Laravel {{ app()->version() }}</div>
                <div class="text-xs text-emerald-400 mt-1 flex items-center gap-1">
                    <span>✓</span> Terinstal
                </div>
            </div>

            <!-- Tailwind CSS -->
            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-700/60">
                <div class="text-xs text-slate-400 font-medium">Styling Engine</div>
                <div class="text-base font-semibold text-white mt-1">Tailwind CSS v4</div>
                <div class="text-xs text-emerald-400 mt-1 flex items-center gap-1">
                    <span>✓</span> Terintegrasi Vite
                </div>
            </div>

            <!-- MySQL & Eloquent -->
            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-700/60">
                <div class="text-xs text-slate-400 font-medium">Database & ORM</div>
                <div class="text-base font-semibold text-white mt-1">MySQL (Eloquent)</div>
                <div class="text-xs text-emerald-400 mt-1 flex items-center gap-1">
                    <span>✓</span> {{ $dbStatus }} ({{ $dbName }})
                </div>
            </div>
        </div>

        <!-- Eloquent Records Test Display -->
        <div class="rounded-xl bg-slate-900/40 border border-slate-700/60 p-4">
            <h2 class="text-sm font-semibold text-slate-300 mb-3 flex items-center justify-between">
                <span>Data Model (Eloquent ORM Test)</span>
                <span class="text-xs bg-slate-800 text-slate-400 px-2 py-0.5 rounded border border-slate-700">Total: {{ $projects->count() }}</span>
            </h2>
            <div class="space-y-2">
                @forelse($projects as $item)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-slate-800/80 border border-slate-700/50">
                        <div>
                            <span class="font-medium text-white text-sm">{{ $item->name }}</span>
                            <div class="text-xs text-slate-400">Created: {{ $item->created_at->format('d M Y H:i') }}</div>
                        </div>
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20 uppercase tracking-wide">
                            {{ $item->status }}
                        </span>
                    </div>
                @empty
                    <div class="text-sm text-slate-400 text-center py-4">Belum ada data project.</div>
                @endforelse
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-6 pt-4 border-t border-slate-700/60 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-2">
            <span>Repositori: <a href="https://github.com/vico65/Kepesertaan-2.0" target="_blank" class="text-blue-400 hover:underline">vico65/Kepesertaan-2.0</a></span>
            <span>PHP {{ PHP_VERSION }}</span>
        </div>
    </div>
</body>
</html>
