<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Contracts\Broadcasting\Factory
     */
    private $factory;
    public function __construct(\Illuminate\Contracts\Broadcasting\Factory $factory)
    {
        $this->factory = $factory;
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->factory->routes();

        require base_path('routes/channels.php');
    }
}
