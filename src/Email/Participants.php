<?php
declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Email;

use Symfony\Component\Mime\Address;

final class Participants
{
    private $sender;
    private $from;
    private $replyTo;
    private $to;
    private $cc;
    private $bcc;

    public static function fromArray(array $participants): self
    {
        $createAddress = static function (array $address) {
            return self::createAddress($address);
        };

        return new self(
            isset($participants['sender']) && is_array($participants['sender']) ? self::createAddress($participants['sender']) : null,
            array_map($createAddress, $participants['from'] ?? []),
            array_map($createAddress, $participants['reply_to'] ?? []),
            array_map($createAddress, $participants['to'] ?? []),
            array_map($createAddress, $participants['cc'] ?? []),
            array_map($createAddress, $participants['bcc'] ?? [])
        );
    }

    public function __construct(
        Address $sender = null,
        array $from = [],
        array $replyTo = [],
        array $to = [],
        array $cc = [],
        array $bcc = []
    ) {
        $this->sender = $sender;
        $this->from = $from;
        $this->replyTo = $replyTo;
        $this->to = $to;
        $this->cc = $cc;
        $this->bcc = $bcc;
    }

    public function getSender(): Address
    {
        return $this->sender;
    }

    public function hasSender(): bool
    {
        return $this->sender instanceof Address;
    }

    /**
     * @return Address[]
     */
    public function getFrom(): array
    {
        return $this->from;
    }

    public function hasFrom(): bool
    {
        return !empty($this->from);
    }

    /**
     * @return Address[]
     */
    public function getReplyTo(): array
    {
        return $this->replyTo;
    }

    public function hasReplyTo(): bool
    {
        return !empty($this->replyTo);
    }

    /**
     * @return Address[]
     */
    public function getTo(): array
    {
        return $this->to;
    }

    public function hasTo(): bool
    {
        return !empty($this->to);
    }

    /**
     * @return Address[]
     */
    public function getCc(): array
    {
        return $this->cc;
    }

    public function hasCc(): bool
    {
        return !empty($this->cc);
    }

    /**
     * @return Address[]
     */
    public function getBcc(): array
    {
        return $this->bcc;
    }

    public function hasBcc(): bool
    {
        return !empty($this->bcc);
    }

    private static function createAddress(array $address): Address
    {
        return new Address($address['address'], $address['name'] ?? '');
    }
}
