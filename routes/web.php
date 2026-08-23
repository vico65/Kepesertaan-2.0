<?php

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $dbDriver = config('database.default');
    $dbName = config('database.connections.' . $dbDriver . '.database');
    $dbStatus = 'Connected';
    $projects = collect();

    try {
        DB::connection()->getPdo();
        if (\Illuminate\Support\Facades\Schema::hasTable('projects')) {
            $projects = Project::latest()->get();
        }
    } catch (\Throwable $e) {
        $dbStatus = 'Disconnected: ' . $e->getMessage();
    }

    return view('welcome', compact('dbStatus', 'dbDriver', 'dbName', 'projects'));
});


