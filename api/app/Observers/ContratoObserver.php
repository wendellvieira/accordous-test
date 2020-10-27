<?php

namespace App\Observers;

use App\Models\Contrato;
use App\Jobs\CreatePDF;
use Illuminate\Support\Facades\Storage;

class ContratoObserver
{
    /**
     * Handle the contrato "created" event.
     *
     * @param  \App\Models\Contrato  $contrato
     * @return void
     */
    public function created(Contrato $contrato)
    {
        CreatePDF::dispatch($contrato);
    }

    /**
     * Handle the contrato "updated" event.
     *
     * @param  \App\Models\Contrato  $contrato
     * @return void
     */
    public function updated(Contrato $contrato)
    {
		Storage::disk("pdfs")->delete( $contrato->pdf );
        CreatePDF::dispatch($contrato);
    }

    /**
     * Handle the contrato "deleted" event.
     *
     * @param  \App\Models\Contrato  $contrato
     * @return void
     */
    public function deleted(Contrato $contrato)
    {
        Storage::disk("pdfs")->delete( $contrato->pdf );
    }


}
