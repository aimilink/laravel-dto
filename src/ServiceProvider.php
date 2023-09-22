<?php

/*
 * This file is part of the cblink/laravel-dto.
 *
 * (c) sunny5156 <sunny5156@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Aimilink\DTO;

use Aimilink\DTO\Commands\DTOMakeCommand;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DTOMakeCommand::class,
            ]);
        }
    }
}
