<?php

namespace App\Services;
use App\Mail\IssueMail;
use App\Models\Invoiceissue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class EmailService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected AttachmentService $attachmentService
    )
    {
        //
    }
    public function send(
        string|array $to,
        string       $subject,
       Invoiceissue $record,
        array        $attachments = [],
        bool         $cleanup = false
    ): bool {
        try {
            $recipients = is_array($to) ? $to : [$to];

            Mail::to($recipients)->send(
                new IssueMail($subject, $record, $attachments)
            );

            if ($cleanup) {
                dd('test');
                $this->attachmentService->deleteMany($attachments);
            }
            return true;

        } catch (Throwable $e) {
            Log::error('EmailService failed to send', [
                'to'        => $to,
                'subject'   => $subject,
                'error'     => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Queue an email instead of sending synchronously.
     */
    public function queue(
        string|array $to,
        string       $subject,
        Invoiceissue $record,
        array        $attachments = []
    ): bool {
        try {
            $recipients = is_array($to) ? $to : [$to];

            Mail::to($recipients)->queue(
                new IssueMail($subject, $record, $attachments)
            );

            return true;

        } catch (Throwable $e) {
            Log::error('EmailService failed to queue', [
                'to'    => $to,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
