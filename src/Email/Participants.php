<?php
declare(strict_types=1);

namespace FH\MailerBundle\Email;

use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\NamedAddress;

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
        return new self(
            $participants['sender'] ? self::createAddress($participants['sender']) : null,
            array_map(static function (array $address) {
                return self::createAddress($address);
            }, $participants['from']),
            array_map(static function (array $address) {
                return self::createAddress($address);
            }, $participants['reply_to']),
            array_map(static function (array $address) {
                return self::createAddress($address);
            }, $participants['to']),
            array_map(static function (array $address) {
                return self::createAddress($address);
            }, $participants['cc']),
            array_map(static function (array $address) {
                return self::createAddress($address);
            }, $participants['bcc'])
        );
    }

    private function __construct(
        Address $sender,
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

    public function getFrom(): array
    {
        return $this->from;
    }

    public function hasFrom(): bool
    {
        return !empty($this->from);
    }

    public function getReplyTo(): array
    {
        return $this->replyTo;
    }

    public function hasReplyTo(): bool
    {
        return !empty($this->replyTo);
    }

    public function getTo(): array
    {
        return $this->to;
    }

    public function hasTo(): bool
    {
        return !empty($this->to);
    }

    public function getCc(): array
    {
        return $this->cc;
    }

    public function hasCc(): bool
    {
        return !empty($this->cc);
    }

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
        $name = $address['name'] ?? null;

        if (is_string($name)) {
            return new NamedAddress($address['address'], $address['name']);
        }

        return new Address($address['address']);
    }
}
