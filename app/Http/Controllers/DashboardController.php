<?php

namespace App\Http\Controllers;

use App\Models\EmailLog;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function destroy($id)
    {
        EmailLog::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function index()
    {
        $logs = EmailLog::latest()->get()->map(function ($log) {
            return [
                'id'              => $log->id,
                'sender_name'     => $log->sender_name,
                'recipient_email' => $log->recipient_email,
                'message'         => $log->message,
                'attachment'      => $log->attachment,
                'amount'          => $log->amount,
                'status'          => $log->status,
                'created_at'      => $log->created_at->format('M d, Y · h:i A'),
            ];
        });

        return Inertia::render('Dashboard', [
            'logs'  => $logs,
            'total' => EmailLog::count(),
            'spent' => EmailLog::sum('amount'),
        ]);
    }
}