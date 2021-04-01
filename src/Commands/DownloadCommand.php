<?php

namespace GhostZero\I18n\Commands;

use GhostZero\I18n\Services\ServiceManager;
use GhostZero\I18n\Utils\LanguageFile;
use Illuminate\Console\Command;

class DownloadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'i18n:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloads all translations';

    /**
     * Execute the console command.
     *
     * @param ServiceManager $manager
     * @return int
     */
    public function handle(ServiceManager $manager): int
    {
        $service = $manager->driver();

        $localizations = $service->download();

        LanguageFile::export($localizations);

        return 0;
    }
}