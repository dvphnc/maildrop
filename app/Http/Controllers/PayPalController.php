<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailMail;
use App\Models\EmailLog;

class PayPalController extends Controller
{
    public function createPayment(Request $request)
    {
        $request->validate([
            'amount'  => 'required|numeric|min:1',
            'name'    => 'required|string',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        // Save form data to session
        session([
            'mail_name'      => $request->name,
            'mail_email'     => $request->email,
            'mail_message'   => $request->message,
            'mail_file'      => null,
            'mail_file_name' => null,
        ]);

        // Save file to disk temporarily if uploaded
        if ($request->hasFile('file')) {
            $file         = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $newFileName  = time() . '_' . $originalName;
            $file->move(storage_path('app/attachments'), $newFileName);

            session([
                'mail_file'      => storage_path('app/attachments/' . $newFileName),
                'mail_file_name' => $originalName,
            ]);
        }

        $amount = number_format((float) $request->amount, 2, '.', '');
        session(['paypal_amount' => $amount]);

        // Save session explicitly before redirect
        session()->save();

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value"         => $amount,
                    ]
                ]
            ],
            "application_context" => [
                "return_url" => config('app.url') . '/paypal/success',
                "cancel_url" => config('app.url') . '/paypal/cancel',
            ]
        ]);

        foreach ($response['links'] as $link) {
            if ($link['rel'] == 'approve') {
                return redirect()->away($link['href']);
            }
        }

        return back()->with('error', 'Something went wrong with PayPal. Please try again.');
    }

    public function success(Request $request)
    {
        // PayPal sends token as query param
        $token = $request->query('token');

        if (!$token) {
            return redirect('/send-email')->with('error', '❌ Invalid payment token.');
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {

            $data = [
                'name'    => session('mail_name'),
                'email'   => session('mail_email'),
                'message' => session('mail_message'),
            ];

            $filePath     = session('mail_file');
            $originalName = session('mail_file_name');

            // Send the email
            Mail::to($data['email'])->send(new SendEmailMail($data, $filePath, $originalName));

            // Save to database
            EmailLog::create([
                'sender_name'     => $data['name'],
                'recipient_email' => $data['email'],
                'message'         => $data['message'],
                'attachment'      => $originalName,
                'amount'          => session('paypal_amount', 10),
                'status'          => 'sent',
            ]);

            // Delete temp file
            if ($filePath && file_exists($filePath)) {
                unlink($filePath);
            }

            // Clear session
            session()->forget(['mail_name', 'mail_email', 'mail_message', 'mail_file', 'mail_file_name', 'paypal_amount']);

            return redirect('/success');
        }

        return redirect('/send-email')->with('error', '❌ Payment could not be completed. Please try again.');
    }

    public function cancel()
    {
        return redirect('/send-email')->with('error', '❌ Payment was cancelled.');
    }
}