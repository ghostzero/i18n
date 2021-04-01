<?php

namespace GhostZero\I18n\Utils;

use Illuminate\Support\Arr;

class LanguageFile
{
    public static function export(array $localizations): void
    {
        foreach ($localizations as $locale => $dotted) {
            if (!is_dir('lang/' . $locale)) {
                // dir doesn't exist, make it
                mkdir('lang/' . $locale, 0777, true);
            }

            $translations = self::undot($dotted);
            $files = array_keys($translations);

            foreach ($files as $file) {
                self::saveFile($translations[$file], sprintf('resources/lang/%s/%s.php', $locale, $file));
            }
        }
    }

    private static function undot(array $dottedArray, array $initialArray = []): array
    {
        foreach ($dottedArray as $key => $value) {
            Arr::set($initialArray, $key, $value);
        }

        return $initialArray;
    }

    private static function saveFile(array $array, string $filename)
    {
        file_put_contents($filename, sprintf("<?php\n\nreturn %s;\n", self::getPhpArray($array)));
    }

    private static function getPhpArray(array $expression): string
    {
        $export = var_export($expression, TRUE);
        $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
        $array = preg_split("/\r\n|\n|\r/", $export);
        $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [NULL, ']$1', ' => ['], $array);
        $export = join(PHP_EOL, array_filter(["["] + $array));
        return $export;
    }
}