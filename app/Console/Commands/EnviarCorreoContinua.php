<?php

namespace App\Console\Commands;

use App\Jobs\SendContinuaJob;
use Illuminate\Console\Command;

class EnviarCorreoContinua extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:enviar-correo-continua';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía la encuesta de educación continua a egresados elegibles';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $idempotenceDate = now()->subDay();

        dispatch(new SendContinuaJob(null, $idempotenceDate));

        $this->info('Job de envío de encuesta continua despachado correctamente.');

        return self::SUCCESS;
    }
}
