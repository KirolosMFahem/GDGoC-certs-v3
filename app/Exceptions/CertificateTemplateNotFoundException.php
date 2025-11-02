<?php

namespace App\Exceptions;

use RuntimeException;

class CertificateTemplateNotFoundException extends RuntimeException
{
    /**
     * Create a new exception instance.
     */
    public function __construct(string $message = 'Certificate template not found')
    {
        parent::__construct($message);
    }
}
