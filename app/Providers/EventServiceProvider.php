<?php

namespace App\Providers;

use App\Events\Activity\ActivityEvent;
use App\Events\Settings\SettingsChangeTimeOfWorkoutEvent;
use App\Events\Settings\UserSettingsDefaultInsert;
use App\Listeners\Activity\ActivityListener;
use App\Listeners\Settings\SettingsChangeTimeOfWorkoutListener;
use App\Listeners\Settings\UserSettingsDefaultListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\Membership\RegistrationMembershipEvent;
use App\Listeners\Membership\RegistrationMembershipListener;
use App\Events\Stats\UserStatsUpdateAfter;
use App\Listeners\Stats\UserStatsUpdateAfterListener;
use App\Events\Authorization\AuthorizationEmailRegisterEventAfter;
use App\Events\Authorization\AuthorizationSocialRegisterEventAfter;
use App\Listeners\Registration\AfterRegistrationListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
