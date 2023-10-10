<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivateUserAccount;
use App\ViewModels\Auth\ValidateInvitationViewModel;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ValidateInvitationController extends Controller
{
    public function show(Request $request, string $code): View|RedirectResponse
    {
        if (! $request->hasValidSignature()) {
            abort(401);
        }

        $user = User::where('invitation_code', $code)->firstOrFail();

        if ($user->email_verified_at) {
            return redirect()->route('dashboard');
        }

        $viewModel = ValidateInvitationViewModel::data($user);

        return view('auth.validate-invitation', ['view' => $viewModel]);
    }

    public function update(Request $request, string $code): RedirectResponse
    {
        $user = (new ActivateUserAccount)->execute([
            'invitation_code' => $code,
            'password' => $request->input('password'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
        ]);

        if (! auth()->attempt([
            'email' => $user->email,
            'password' => $request->input('password'),
        ])) {
            throw new Exception('Something went wrong.');
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}
