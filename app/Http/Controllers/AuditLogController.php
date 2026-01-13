<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = AuditLog::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.audit_logs.index', compact('logs'));
    }
}
