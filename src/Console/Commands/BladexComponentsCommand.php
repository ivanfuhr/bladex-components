<?php

declare(strict_types=1);

namespace Ivanfuhr\BladexComponents\Console\Commands;

use Illuminate\Console\Command;

class BladexComponentsCommand extends Command
{
    /**
     * The command signature.
     */
    protected $signature = 'bladex-components:placeholder';

    /**
     * The command description.
     */
    protected $description = 'Placeholder Artisan command shipped by the package bladex-components.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->line('BladexComponents placeholder command executed.');

        return self::SUCCESS;
    }
}
