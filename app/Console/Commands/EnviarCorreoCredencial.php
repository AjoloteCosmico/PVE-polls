<?php

namespace App\Console\Commands;

use App\Jobs\SendCredencialJob;
use Illuminate\Console\Command;

class EnviarCorreoCredencial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:enviar-correo-credencial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía la encuesta de satisfacción de la credencial de egresado';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $idempotenceDate = now()->subDay();

        dispatch(new SendCredencialJob(null, $idempotenceDate));

        $this->info('Job de envío de credenciales despachado correctamente.');

        return self::SUCCESS;
    }
}
