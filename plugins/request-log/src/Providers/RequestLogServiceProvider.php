<?php

namespace Botble\RequestLog\Providers;

use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Support\Services\Cache\Cache;
use Botble\RequestLog\Repositories\Caches\RequestLogCacheDecorator;
use Botble\RequestLog\Repositories\Eloquent\RequestLogRepository;
use Botble\RequestLog\Repositories\Interfaces\RequestLogInterface;
use Illuminate\Support\ServiceProvider;
use Botble\RequestLog\Models\RequestLog as RequestLogModel;

/**
 * Class RequestLogServiceProvider
 * @package Botble\RequestLog
 * @author Sang Nguyen
 * @since 02/07/2016 09:50 AM
 */
class RequestLogServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @author Sang Nguyen
     */
    public function register()
    {
        if (setting('enable_cache', false)) {
            $this->app->singleton(RequestLogInterface::class, function () {
                return new RequestLogCacheDecorator(new RequestLogRepository(new RequestLogModel()), new Cache($this->app['cache'], RequestLogRepository::class));
            });
        } else {
            $this->app->singleton(RequestLogInterface::class, function () {
                return new RequestLogRepository(new RequestLogModel());
            });
        }
    }

    /**
     * Boot the service provider.
     * @author Sang Nguyen
     */
    public function boot()
    {
        $this->app->register(EventServiceProvider::class);

        $this->setIsInConsole($this->app->runningInConsole())
            ->setNamespace('plugins/request-log')
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations();

        $this->app->register(HookServiceProvider::class);
    }
}
