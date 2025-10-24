<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use App\Services\EmailTemplateService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DynamicTemplateMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public EmailTemplate $template,
        public array $data = [],
        public ?string $companyName = null,
        public ?string $companyDomain = null
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $service = app(EmailTemplateService::class);
        $processed = $service->replacePlaceholders($this->template, $this->data);

        $envelope = new Envelope(
            subject: $processed['subject'],
        );

        // Set custom sender if company info is provided
        if ($this->companyName && $this->companyDomain) {
            $envelope->from("no-reply@{$this->companyDomain}", $this->companyName);
        }

        return $envelope;
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $service = app(EmailTemplateService::class);
        $processed = $service->replacePlaceholders($this->template, $this->data);

        // Load CSS from file
        $cssPath = public_path('css/email-styles.css');
        $cssStyles = file_exists($cssPath) ? file_get_contents($cssPath) : '';

        // Wrap the body with CSS styles and email-content class
        $wrappedBody = "<div class=\"email-content\">{$processed['body']}</div>";
        $styledBody = $cssStyles ? "<style>{$cssStyles}</style>{$wrappedBody}" : $wrappedBody;

        return new Content(
            htmlString: $styledBody,
        );
    }

    /**
     * Render the email content as HTML string.
     */
    public function render(): string
    {
        $service = app(EmailTemplateService::class);
        $processed = $service->replacePlaceholders($this->template, $this->data);

        // Load CSS from file
        $cssPath = public_path('css/email-styles.css');
        $cssStyles = file_exists($cssPath) ? file_get_contents($cssPath) : '';

        // Wrap the body with CSS styles and email-content class
        $wrappedBody = "<div class=\"email-content\">{$processed['body']}</div>";
        $styledBody = $cssStyles ? "<style>{$cssStyles}</style>{$wrappedBody}" : $wrappedBody;

        return $styledBody;
    }
}
