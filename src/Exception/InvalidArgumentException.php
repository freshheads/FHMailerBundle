<?php

declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Exception;

use InvalidArgumentException as InvalidArgumentExceptionAlias;

class InvalidArgumentException extends InvalidArgumentExceptionAlias implements ExceptionInterface
{
}
