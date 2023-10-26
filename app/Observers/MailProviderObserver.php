<?php

namespace App\Observers;

use App\Models\MailProvider;

class MailProviderObserver
{
    /**
     * Handle the MailProvider "created" event.
     */
    public function created(MailProvider $mailProvider): void
    {
        //
    }

    /**
     * Handle the MailProvider "updated" event.
     */
    public function updated(MailProvider $mailProvider): void
    {
        //
    }

    /**
     * Handle the MailProvider "deleted" event.
     */
    public function deleted(MailProvider $mailProvider): void
    {
        try {
            if ($mailProvider->active) {
                $firstMailProvider = MailProvider::first();
                if ($firstMailProvider) {
                    $firstMailProvider->update(['active' => true]);
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    /**
     * Handle the MailProvider "restored" event.
     */
    public function restored(MailProvider $mailProvider): void
    {
        //
    }

    /**
     * Handle the MailProvider "force deleted" event.
     */
    public function forceDeleted(MailProvider $mailProvider): void
    {
        //
    }

    /**
     * Handle the MailProvider "saved" event.
     */
    public function saved(MailProvider $mailProvider): void
    {
        try {
            if ($mailProvider->active) {
                MailProvider::where('id', '!=', $mailProvider->id)->update(['active' => false]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
