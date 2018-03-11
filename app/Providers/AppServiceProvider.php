<?php

namespace App\Providers;

use API;
use App\Models\Link;
use App\Models\Reply;
use App\Models\Topic;
use App\Observers\LinkObserver;
use App\Observers\TopicObserver;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Observers\UserObserver;
use App\Observers\ReplyObserver;
use Summerblue\Generator\GeneratorsServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
	{
		User::observe(UserObserver::class);
        Reply::observe(ReplyObserver::class);
		Topic::observe(TopicObserver::class);
        Link::observe(LinkObserver::class);

        Carbon::setLocale('zh');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->environment() == 'local' || app()->environment() == 'testing') {

            $this->app->register(GeneratorsServiceProvider::class);
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);

        }
        API::error(function (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            abort(404);
        });

        API::error(function (\Illuminate\Auth\Access\AuthorizationException $exception) {
            abort(403, $exception->getMessage());
        });
    }

}
