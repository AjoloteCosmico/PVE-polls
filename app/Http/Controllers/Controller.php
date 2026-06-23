<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, DispatchesJobs;

    /**
     * Metodo que se va a heredar para hacer uso de el al momento de enviar el aviso de privacidad a los egresados.
     */
    protected function enviarAviso($emailId, $recipientEmail, $nombreEgresado, $scriptName = 'aviso.py'){
        $tracking_id = (string) Str::uuid();
        $ahora = now();

        DB::table('email_tracking')->insert([
            'email_id' => $emailId,
            'recipient_email' => $recipientEmail,
            'tracking_uuid' => $tracking_id,
            'type' => 'aviso',
            'created_at' => $ahora,
            'sended_at' => $ahora,
            'updated_at' => $ahora,
        ]);
        $caminoalpoder=public_path();
        $process =new Process([
            env('PY_COMAND'),
            $caminoalpoder . '/' . $scriptName,
            $nombreEgresado,
            $recipientEmail,
            $tracking_id
        ]);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $data = $process->getOutput();
        return redirect()->route('aviso');
    }
}
