<?php

namespace Database\Seeders;

use App\Models\MailProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MailProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MailProvider::insert([
            [
                'name' => 'SMTP Mailtrap',
                'host' => 'sandbox.smtp.mailtrap.io',
                'port' => '2525',
                'username' => '2e6ad522692c30',
                'password' => '3bd44d4f240cd1',
                'encryption' => null,
                'timeout' => null,
                'local_domain' => 'hello@example.com',
                'active' => true,
            ],
            [
                'name' => 'Mailgun',
                'host' => 'sandbox.smtp.mailtrap.io',
                'port' => '2525',
                'username' => 'a11a4b498d6647',
                'password' => '3f4735f14fe9d4',
                'encryption' => null,
                'timeout' => null,
                'local_domain' => 'hello@example.com',
                'active' => false,
            ]
        ]);
    }
}
