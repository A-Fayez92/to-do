<?php

namespace App\Providers;

use App\Models\MailProvider;
use Illuminate\Support\ServiceProvider;

class CustomMailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try {
            $activeProvider = MailProvider::where('active', true)->first();
            if ($activeProvider) {
                config([
                    'mail.mailers.smtp.transport' => 'smtp',
                    'mail.mailers.smtp.host' => $activeProvider->host,
                    'mail.mailers.smtp.port' => $activeProvider->port,
                    'mail.mailers.smtp.username' => $activeProvider->username,
                    'mail.mailers.smtp.password' => $activeProvider->password,
                    'mail.mailers.smtp.encryption' => $activeProvider->encryption,
                    'mail.mailers.smtp.timeout' => $activeProvider->timeout,
                    'mail.local_domain' => $activeProvider->local_domain,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
