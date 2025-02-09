<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Imagick;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Difference extends Command
{
    protected $signature = 'dusk:difference
        {threshold : The maximum percentage difference allowed}';
    protected $description = 'Validate screenshots against the baseline';

    public function handle(): int
    {
        $threshold = (float) $this->argument('threshold');

        $screenshotPaths = collect(Storage::disk('browser')->allFiles('screenshots'))
            ->filter(fn ($file) => str_ends_with($file, '.png'));

        $isSuccessful = self::SUCCESS;

        foreach ($screenshotPaths as $screenshotPath) {
            $baselineFilePath = str_replace('screenshots', 'baseline', $screenshotPath);

            if (!Storage::disk('browser')->exists($baselineFilePath)) {
                $this->error("Baseline file does not exist: $baselineFilePath");
                $isSuccessful = self::FAILURE;
                continue;
            }

            $this->line(sprintf('Checking: %s', $screenshotPath));

            $baselineImage = new Imagick(Storage::disk('browser')->path($baselineFilePath));
            $screenshotImage = new Imagick(Storage::disk('browser')->path($screenshotPath));

            [$differencesImage, $difference] = $baselineImage->compareImages(
                $screenshotImage,
                Imagick::METRIC_MEANABSOLUTEERROR
            );

            $difference *= 100;

            if ($difference > $threshold) {
                $differenceImagePath = base_path(
                    sprintf(
                        'tests/Browser/differences/%s',
                        Str::of($screenshotPath)->afterLast('/')->value()
                    )
                );
                $differencesImage->setImageFormat('png');
                $differencesImage->writeImage($differenceImagePath);
                $this->error(
                    sprintf(
                        'Threshold exceeded, percentage difference: %s%%.',
                        round($difference, 2)
                    )
                );
                $this->line(
                    sprintf(
                        'Image of the difference can be found at: %s',
                        $differenceImagePath
                    )
                );
                $isSuccessful = self::FAILURE;
            } else {
                $this->line(
                    sprintf(
                        'Percentage difference: %s%%',
                        round($difference, 2)
                    )
                );
            }
        }

        return $isSuccessful;
    }
}
