<?php

namespace App\Mail;

use App\Models\StudyRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudyRequestedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $studyRequest;

    /**
     * Create a new message instance.
     *
     * @param StudyRequest $studyRequest
     */
    public function __construct(StudyRequest $studyRequest)
    {
        $this->studyRequest = $studyRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.study_requested')
                    ->subject('Confirmación de Solicitud de Análisis de Agua - Folio: ' . $this->studyRequest->referencia_bancaria);
    }
}
