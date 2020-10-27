<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Imovel;
use App\Models\Contrato;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;

class CreatePDF implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	private $contrato;
	private $imovel;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( Contrato $contrato )
    {
		$this->contrato = $contrato;
		$this->imovel = Imovel::findOrFail( $contrato->propriedade );
	}

	private function getTerms(){

		return [
			"locador.nome" => $this->contrato->nome,
			"locador.tipo_documento" => $this->contrato->tipo_documento,
			"locador.documento" => $this->contrato->documento,
			"locador.email" => $this->contrato->email,

			"locatario.email" => $this->imovel->email,
			"imovel.cep" => $this->imovel->cep,
			"imovel.localidade" => $this->imovel->localidade,
			"imovel.logradouro" => $this->imovel->logradouro,
			"imovel.uf" => $this->imovel->uf,
			"imovel.numero" => $this->imovel->numero,
			"imovel.complemento" => $this->imovel->complemento,

			"contrato.data" => date("d/m/Y", strtotime($this->contrato->created_at) )
		];
	}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

		$terms = $this->getTerms();

		$documenteName = "CONTRATO_IMOVEL_{$this->contrato->documento}_" . time();

		$docxFile = "/tmp/{$documenteName}.docx";

		$template = Storage::disk("templates")->path("contrato-de-locacao.docx");

		$templateProcessor = new TemplateProcessor($template);

		$templateProcessor->setValues( $terms );

		$templateProcessor->saveAs( $docxFile );

		$cmd = "libreoffice --headless --convert-to pdf --outdir /tmp {$docxFile}";
		shell_exec($cmd);

		$pdfName = "{$documenteName}.pdf";
		$pdf = Storage::disk("tmp")->get($pdfName);
		Storage::disk("pdfs")->put($pdfName, $pdf);

		$this->contrato->created_pdf_at = date("Y-m-d H:i:s");
		$this->contrato->pdf = $pdfName;
		$this->contrato->save();

    }
}
