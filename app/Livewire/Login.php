<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';

    public string $password = '';

    protected $rules = [
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ];

    public function login(): void
    {
        $credentials = $this->validate();

        if (! Auth::attempt($credentials)) {
            $this->addError('email', 'Las credenciales proporcionadas no son válidas.');

            return;
        }

        session()->regenerate();

        $this->redirect(route(static::redirectRouteName()));
    }

    public static function redirectRouteName(): string
    {
        return Auth::user()?->can('manage products') ? 'dashboard' : 'movements.index';
    }

    public function render(): View
    {
        return view('livewire.login');
    }
}
