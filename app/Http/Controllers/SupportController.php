<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Activity;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * Dashboard Support Team
     */
    public function dashboard()
    {
        $kpis = [
            'total_tickets' => Activity::where('type', 'ticket')->count(),
            'urgent_tickets' => Activity::where('type', 'ticket')->where('priorite', 'haute')->count(),
        ];

        $tickets = Activity::where('type', 'ticket')
            ->with(['user', 'parent'])
            ->latest()
            ->get();

        $recent_contacts = Contact::latest()->limit(5)->get();

        return view('support.dashboard', compact('kpis', 'tickets', 'recent_contacts'));
    }
}
