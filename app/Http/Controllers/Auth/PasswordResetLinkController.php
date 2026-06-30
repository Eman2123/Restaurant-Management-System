<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Throttle the request - max 1 request per minute per email
        if ($this->isThrottled($request)) {
            return back()->withErrors([
                'email' => 'Please wait a few minutes before retrying.'
            ])->onlyInput('email');
        }

        // Send the password reset link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', 'We have emailed your password reset link!');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'We could not find a user with that email address.']);
    }

    /**
     * Check if request is throttled
     */
    private function isThrottled(Request $request): bool
    {
        $key = 'password-reset-' . $request->input('email');
        $limit = 3; // 3 attempts
        $decay = 60; // per 60 seconds

        if (cache()->has($key)) {
            $attempts = cache()->get($key);
            if ($attempts >= $limit) {
                return true;
            }
            cache()->increment($key);
        } else {
            cache()->put($key, 1, now()->addSeconds($decay));
        }

        return false;
    }
}