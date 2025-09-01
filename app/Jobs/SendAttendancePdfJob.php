<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendAttendancePdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $relativePath;
    public $filename;
    public $subject;
    public $body;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $email, string $relativePath, string $filename, string $subject, string $body = '')
    {
        $this->email = $email;
        $this->relativePath = $relativePath;
        $this->filename = $filename;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $fullPath = Storage::path($this->relativePath);

            // If file exists and size > 0 use path attachment, otherwise try reading bytes
            $usePath = false;
            if (Storage::exists($this->relativePath)) {
                try {
                    $size = Storage::size($this->relativePath);
                    if ($size && $size > 0) {
                        $usePath = true;
                    }
                } catch (\Throwable $e) {
                    $usePath = false;
                }
            }

            if ($usePath) {
                info('SendAttendancePdfJob: attaching by path', ['email' => $this->email, 'path' => $fullPath, 'size' => $size]);
                Mail::to($this->email)->send(new \App\Mail\SendAttendancePdf($this->body, $this->subject, $fullPath, $this->filename));
            } else {
                info('SendAttendancePdfJob: path not usable, attempting to read bytes', ['email' => $this->email, 'path' => $this->relativePath]);
                // fallback: read bytes from storage (job runs on worker so binary is safe here)
                $bytes = null;
                if (Storage::exists($this->relativePath)) {
                    $bytes = Storage::get($this->relativePath);
                }

                if (empty($bytes)) {
                    warning('SendAttendancePdfJob: no bytes read from storage for attachment', ['email' => $this->email, 'path' => $this->relativePath]);
                    // nothing to attach, send without attachment but log
                    Mail::to($this->email)->send(new \App\Mail\SendAttendancePdf($this->body, $this->subject, null, $this->filename));
                } else {
                    info('SendAttendancePdfJob: attaching raw bytes', ['email' => $this->email, 'bytes' => strlen($bytes)]);
                    Mail::to($this->email)->send(new \App\Mail\SendAttendancePdf($this->body, $this->subject, $bytes, $this->filename));
                }
            }

            // Remove the temporary file if it exists
            if (Storage::exists($this->relativePath)) {
                Storage::delete($this->relativePath);
                info('SendAttendancePdfJob: deleted temporary file', ['path' => $this->relativePath]);
            }
        } catch (\Throwable $e) {
            // Log and rethrow so the job can be retried by the queue worker
            report($e);
            throw $e;
        }
    }
}
