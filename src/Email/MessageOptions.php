<?php

declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Email;

use FH\Bundle\MailerBundle\Exception\InvalidArgumentException;

final class MessageOptions
{
    /** @var string|null */
    private $subject;

    /** @var string|null */
    private $htmlTemplate;

    /** @var string|null */
    private $textTemplate;

    /** @var Participants */
    private $participants;

    public static function fromArray(array $messageOptions): self
    {
        return new self(
            $messageOptions['subject'],
            $messageOptions['html_template'] ?? null,
            $messageOptions['text_template'] ?? null,
            Participants::fromArray($messageOptions['participants'])
        );
    }

    public function __construct(
        ?string $subject,
        ?string $htmlTemplate,
        ?string $textTemplate,
        Participants $participants
    ) {
        $this->subject = $subject;
        $this->htmlTemplate = $htmlTemplate;
        $this->textTemplate = $textTemplate;
        $this->participants = $participants;
    }

    public function getSubject(): string
    {
        if (!\is_string($this->subject)) {
            throw new InvalidArgumentException('Invalid subject');
        }

        return $this->subject;
    }

    public function hasSubject(): bool
    {
        return \is_string($this->subject);
    }

    public function getHtmlTemplate(): ?string
    {
        return $this->htmlTemplate;
    }

    public function hasHtmlTemplate(): bool
    {
        return \is_string($this->htmlTemplate);
    }

    public function getTextTemplate(): ?string
    {
        return $this->textTemplate;
    }

    public function hasTextTemplate(): bool
    {
        return \is_string($this->textTemplate);
    }

    public function getParticipants(): Participants
    {
        return $this->participants;
    }
}
