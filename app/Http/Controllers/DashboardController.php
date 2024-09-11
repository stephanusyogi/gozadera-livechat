<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\Events;
use App\Models\Messages;
use App\Models\SongRequest;
use App\Models\Tables;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{   
    public function dashboard(){
        $url = '/';
        $admin = auth()->user();

        $totalChats = Messages::withTrashed()->count();

        $totalEvents = Events::withTrashed()->count();

        $totalTables = Tables::withTrashed()->count();

        $totalSongs = SongRequest::withTrashed()->count();

        $totalAdmins = Administrator::withTrashed()->count();

        $now = Carbon::now();

        $ongoingEvents = Events::withTrashed()
            ->where('flag_started', 1)
            ->count();

        $upcomingEvents = Events::withTrashed()
            ->whereNull('flag_started')
            ->count();

        $completedEvents = Events::withTrashed()
            ->where('flag_started', 0)
            ->count();
        
        return view('admin.dashboard', compact([
            'url', 'admin', 'totalChats', 'totalEvents', 'totalTables', 'totalSongs', 'totalAdmins', 'ongoingEvents', 'upcomingEvents', 'completedEvents'
        ]));
    }
}
