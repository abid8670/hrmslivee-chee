<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateFilamentUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filament:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Filament user.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Name?');
        $email = $this->ask('Email?');
        $password = $this->secret('Password?');

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->is_active = true;
        $user->save();

        $this->info('User created successfully.');
    }
}
