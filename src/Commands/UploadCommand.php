<?php

namespace GhostZero\I18n\Commands;

use GhostZero\I18n\Services\ServiceManager;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

class UploadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'i18n:upload {locale=en}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uploads all translations';

    /**
     * Execute the console command.
     *
     * @param ServiceManager $manager
     * @return int
     */
    public function handle(ServiceManager $manager): int
    {
        $service = $manager->driver();

        $service->upload(...$this->getFiles());

        return 0;
    }

    /**
     * @return array
     */
    private function getFiles(): array
    {
        $files = [];

        $locale = $this->argument('locale');

        foreach (config('i18n.files') as $file) {
            $files[$file] = Lang::get($file, [], $locale, false);
        }

        return [$files, $locale];
    }
}