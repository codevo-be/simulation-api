<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Tenant;
use App\Models\UserTenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {email} {password} {tenant_slug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer un utilisateur et l\'associer à un tenant';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $tenant_slug = $this->argument('tenant_slug');
        $password = $this->argument('password') ?? Str::random(12);
        $role = "admin";

        $tenant = Tenant::find($tenant_slug);

        if (!$tenant) {
            $this->error("❌ Le tenant '$tenant_slug' n'existe pas.");
            return 1;
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $this->info("✅ Utilisateur '$email' créé avec succès.");
            $this->info("🔑 Mot de passe : $password");
        } else {
            $this->info("ℹ️ L'utilisateur '$email' existe déjà.");
        }

        if (UserTenant::where('user_id', $user->id)->where('tenant_id', $tenant->id)->exists()) {
            $this->error("❌ L'utilisateur est déjà assigné à ce tenant.");
            return 1;
        }

        UserTenant::create([
            'user_id' => $user->id,
            'tenant_id' => $tenant->id,
            'role' => $role,
        ]);

        $this->info("✅ Utilisateur '$email' assigné au tenant '$tenant_slug' avec le rôle '$role'.");

        return 0;

    }
}

