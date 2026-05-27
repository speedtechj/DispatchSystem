<?php

namespace App\Mail;

use App\Models\Invoiceissue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IssueMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $mailSubject,    // ✅ renamed — avoid conflict
        public Invoiceissue $record,
        public array $rawFiles = [],
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->mailSubject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.issues',
            with: [
                'record' => $this->record,
                'files' => collect($this->rawFiles)->map(fn($path) => [
                    'name' => basename($path),
                    'path' => $path,
                ])->toArray(),
            ],
        );
    }

    public function attachments(): array
    {

      //  dd($this->files);
      // return
     return collect($this->rawFiles)
        ->map(function ($file) {

           // $path = storage_path('app/public/' . $file);

            if (! file_exists($file)) {
                return null;
            }

            return Attachment::fromPath($file)
                ->as(basename($file));
        })
        ->filter()
        ->values()
        ->toArray();

}

}
