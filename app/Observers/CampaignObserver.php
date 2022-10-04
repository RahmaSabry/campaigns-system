<?php

namespace App\Observers;
use App\Models\Campaign;
use Illuminate\Support\Facades\Cache;

class CampaignObserver
{
   
    public function created()
    {
        $campaigns = Campaign::with(['images'])->get();
        // Cache::forever('campaigns', $campaigns);
    }

    /**
     * Handle the Campaign "updated" event.
     *
     * @param  \App\Campaign  $Campaign
     * @return void
     */
    public function updated()
    {
        $campaigns = Campaign::with(['images'])->get();
        // Cache::forever('campaigns', $campaigns);
    }
}
