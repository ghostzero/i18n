<?php

namespace GhostZero\I18n\Contracts;

interface Service
{
    public function upload(array $files, string $locale = 'en'): void;

    public function download(string $locale = null): array;
}