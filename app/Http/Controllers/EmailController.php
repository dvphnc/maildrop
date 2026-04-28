<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailMail;

class EmailController extends Controller
{
    public function index()
    {
        return view('send-email');
    }

    public function send(Request $request)
{
    $request->validate([
        'name'    => 'required|string',
        'email'   => 'required|email',
        'message' => 'required|string',
        'file'    => 'nullable|file|max:5120',
    ]);

    $filePath     = null;
    $originalName = null;

    if ($request->hasFile('file')) {
        $file         = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $extension    = $file->getClientOriginalExtension();
        $newFileName  = time() . '_' . $originalName;

        // Move to storage/app/attachments with correct name
        $file->move(storage_path('app/attachments'), $newFileName);
        $filePath = storage_path('app/attachments/' . $newFileName);
    }

    $data = [
        'name'    => $request->name,
        'email'   => $request->email,
        'message' => $request->message,
    ];

    Mail::to($request->email)->send(new SendEmailMail($data, $filePath, $originalName));

    // Delete the file after sending
    if ($filePath && file_exists($filePath)) {
        unlink($filePath);
    }

    return back()->with('success', 'Email sent successfully!');
}
}