<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('anspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('change-user-role {email} {role}', function ($email, $role) {
    $user = User::where('email', $email)->first();
    if ($user) {
        $user->role = $role;
        $user->save();
        $this->info('User role changed successfully');
    } else {
        $this->error('User not found');
    }
})->purpose('Change user role');

Artisan::command('list-users', function () {
    $users = User::all();
    $this->table(['ID', 'Name', 'Email', 'Role'], $users);
})->purpose('List all users');
