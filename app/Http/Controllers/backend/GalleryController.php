<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransportInterface;
use Symfony\Component\Mime\Email;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Message;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.gallery.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function test(Request $request)
    {
        try {

            // Temporarily override the mail settings
            Config::set('mail.mailers.smtp.host', 'smtp.hostinger.com');
            Config::set('mail.mailers.smtp.port', 465);
            Config::set('mail.mailers.smtp.username', 'hello@marcoroma.ae');
            Config::set('mail.mailers.smtp.password', '@#Hello@123');
            Config::set('mail.mailers.smtp.encryption', 'SSL');  // default to tls if not provided
            Config::set('mail.from.address', 'hello@marcoroma.ae');
            Config::set('mail.from.name', 'Test SMTP');  // Optionally, set a name

            // Send the test email
            Mail::raw('Email testing', function (Message $message) {
                $message->to('fbfurqanbashir@gmail.com')->from('hello@marcoroma.ae');
            });

            // Run the config:clear Artisan command to reset configurations
            Artisan::call('config:clear');

            return response()->json(['success' => 'SMTP test email sent successfully.']);
        } catch (\Exception $e) {
            // Reset to default config in case of error
            Artisan::call('config:clear');
            return response()->json(['error' => 'There was an issue sending the test email: ' . $e->getMessage()], 500);
        }
    }
}
