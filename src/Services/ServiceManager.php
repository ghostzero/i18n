<?php

namespace GhostZero\I18n\Services;

use Closure;
use GhostZero\I18n\Contracts\Service;

class ServiceManager
{
    private $services;

    public function extend(string $name, Closure $closure)
    {
        return $this->services[$name] = $closure();
    }

    public function driver(string $name = null): ?Service
    {
        return $this->services[$name ?? config('i18n.default')] ?? null;
    }
}