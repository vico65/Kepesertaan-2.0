<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Badan Usaha - Kepesertaan 2.0</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Inline style tambahan khusus halaman ini --}}
    <style>
        /* ========================================
           COLOR PALETTE (Hijau & Biru)
           ========================================
           Hijau utama  : #10b981 (emerald-500)
           Hijau gelap  : #065f46 (emerald-800)
           Biru utama   : #3b82f6 (blue-500)
           Biru gelap   : #1e3a5f
           Background   : #0f172a (slate-900)
           Card BG      : #1e293b (slate-800)
        */

        body {
            background: linear-gradient(135deg, #0f172a 0%, #0c1a2e 50%, #0f172a 100%);
            min-height: 100vh;
        }

        /* Gradient header bar */
        .header-gradient {
            background: linear-gradient(135deg, #065f46 0%, #1e3a5f 100%);
        }

        /* Table header gradient */
        .thead-gradient {
            background: linear-gradient(90deg, #10b981 0%, #3b82f6 100%);
        }

        /* Row hover effect */
        .table-row-hover:hover {
            background-color: rgba(16, 185, 129, 0.08);
            transition: background-color 0.2s ease;
        }

        /* Badge styles */
        .badge-ro {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .badge-jenis {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        /* Scrollbar styling */
        .custom-scrollbar::-webkit-scrollbar {
            height: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1e293b;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #374151;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #4b5563;
        }
    </style>
</head>
<body class="text-slate-100 antialiased">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- ===== HEADER ===== --}}
        <div class="header-gradient rounded-2xl p-6 mb-8 shadow-lg border border-emerald-500/20">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Kepesertaan 2.0
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight flex items-center gap-3">
                        <span>📋</span> Data Badan Usaha
                    </h1>
                    <p class="text-emerald-200/80 text-sm mt-1">
                        Daftar seluruh badan usaha beserta Relationship Officer (RO) yang memegang.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="bg-slate-900/60 backdrop-blur px-4 py-2 rounded-xl border border-slate-700/80 text-sm text-slate-300 shadow-inner">
                        Total BU: <strong class="text-emerald-400 font-semibold">{{ $badanUsahaList->count() }}</strong>
                    </span>
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-medium rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-600/60 transition">
                        <span>←</span> Beranda
                    </a>
                </div>
            </div>
        </div>

        {{-- ===== TABEL DATA ===== --}}
        <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl shadow-2xl overflow-hidden backdrop-blur">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-sm text-left">
                    {{-- Table Head --}}
                    <thead class="thead-gradient text-white text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3.5 font-semibold text-center w-12">No</th>
                            <th class="px-4 py-3.5 font-semibold">Kode Entitas</th>
                            <th class="px-4 py-3.5 font-semibold">Kode BU</th>
                            <th class="px-4 py-3.5 font-semibold min-w-[220px]">Nama Badan Usaha</th>
                            <th class="px-4 py-3.5 font-semibold">Jenis Usaha</th>
                            <th class="px-4 py-3.5 font-semibold">Kota/Kabupaten</th>
                            <th class="px-4 py-3.5 font-semibold min-w-[160px]">RO (Staff)</th>
                            <th class="px-4 py-3.5 font-semibold">Jenis BU</th>
                            <th class="px-4 py-3.5 font-semibold text-center">Tenaga Kerja</th>
                            <th class="px-4 py-3.5 font-semibold">TMT BU</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-slate-700/50">
                        @forelse ($badanUsahaList as $index => $bu)
                            @php
                                // Ambil riwayat bulanan terbaru (item pertama dari collection yang sudah di-sort)
                                $riwayatTerbaru = $bu->riwayatBulanan->first();
                                $namaRo = $riwayatTerbaru?->staff?->name ?? '-';
                                $jenisBu = $riwayatTerbaru?->jenis_bu ?? '-';
                                $jumlahTk = $riwayatTerbaru?->jumlah_tenaga_kerja ?? 0;
                            @endphp
                            <tr class="table-row-hover transition-colors">
                                <td class="px-4 py-3.5 text-slate-400 font-mono text-center">{{ $index + 1 }}</td>
                                <td class="px-4 py-3.5 font-mono text-emerald-400 font-semibold">{{ $bu->kode_entitas }}</td>
                                <td class="px-4 py-3.5 font-mono text-blue-400">{{ $bu->kode_bu }}</td>
                                <td class="px-4 py-3.5 font-medium text-white">
                                    <div class="font-semibold">{{ $bu->nama_bu }}</div>
                                    @if($bu->alamat_bu)
                                        <div class="text-xs text-slate-400 truncate max-w-xs">{{ $bu->alamat_bu }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-slate-300">
                                    <span>{{ $bu->jenis_usaha ?? '-' }}</span>
                                    @if($bu->detail_jenis_usaha)
                                        <div class="text-xs text-slate-400">{{ $bu->detail_jenis_usaha }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-slate-300">{{ $bu->nama_dati_2 ?? '-' }}</td>
                                <td class="px-4 py-3.5">
                                    @if($namaRo !== '-')
                                        <span class="badge-ro inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium">
                                            <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            {{ $namaRo }}
                                        </span>
                                    @else
                                        <span class="text-slate-500 text-xs italic">Belum ada RO</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5">
                                    @if($jenisBu !== '-')
                                        <span class="badge-jenis inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium">
                                            {{ $jenisBu }}
                                        </span>
                                    @else
                                        <span class="text-slate-500 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-slate-200 font-mono text-center">
                                    {{ number_format($jumlahTk) }}
                                </td>
                                <td class="px-4 py-3.5 text-slate-400 text-xs font-mono">
                                    {{ \Carbon\Carbon::parse($bu->tmt_bu)->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-4 py-12 text-center text-slate-400">
                                    <div class="text-3xl mb-2">🏢</div>
                                    <p class="font-medium text-slate-300">Belum ada data badan usaha.</p>
                                    <p class="text-xs text-slate-500 mt-1">Silakan jalankan seeder untuk mengisi data dummy.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ===== FOOTER ===== --}}
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-2 border-t border-slate-800 pt-4">
            <div>Kepesertaan 2.0 &mdash; Sistem Pengelolaan Data Kepesertaan</div>
            <div>Laravel {{ app()->version() }} &bull; PHP {{ PHP_VERSION }}</div>
        </div>

    </div>
</body>
</html>
