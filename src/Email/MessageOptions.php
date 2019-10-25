<?php
declare(strict_types=1);

namespace FH\MailerBundle\Email;

final class MessageOptions
{
    private $subject;
    private $htmlTemplate;
    private $textTemplate;
    private $participants;

    public static function fromArray(array $messageOptions): self
    {
        return new self(
            $messageOptions['subject'],
            $messageOptions['html_template'],
            $messageOptions['text_template'],
            Participants::fromArray($messageOptions['participants'])
        );
    }

    private function __construct(?string $subject, ?string $htmlTemplate, ?string $textTemplate, Participants $participants)
    {
        $this->subject = $subject;
        $this->htmlTemplate = $htmlTemplate;
        $this->textTemplate = $textTemplate;
        $this->participants = $participants;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function hasSubject(): bool
    {
        return is_string($this->subject);
    }

    public function getHtmlTemplate(): ?string
    {
        return $this->htmlTemplate;
    }

    public function hasHtmlTemplate(): bool
    {
        return is_string($this->htmlTemplate);
    }

    public function getTextTemplate(): ?string
    {
        return $this->textTemplate;
    }

    public function hasTextTemplate(): bool
    {
        return is_string($this->textTemplate);
    }

    public function getParticipants(): Participants
    {
        return $this->participants;
    }
}
