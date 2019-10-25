<?php
declare(strict_types=1);

namespace FH\MailerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

final class FHMailerBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
