<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Baseline extends Command
{
    protected $signature = 'dusk:baseline';
    protected $description = 'Copy the current screenshots to the baseline directory';

    public function handle(): int
    {
        $screenshotPaths = collect(Storage::disk('browser')->allFiles('screenshots'))
            ->filter(fn ($file) => str_ends_with($file, '.png'));

        foreach ($screenshotPaths as $screenshotPaths) {
            Storage::disk('browser')->copy(
                $screenshotPaths,
                str_replace('screenshots', 'baseline', $screenshotPaths)
            );
        }

        return self::SUCCESS;
    }
}
