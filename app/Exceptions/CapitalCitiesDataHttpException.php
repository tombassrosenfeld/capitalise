<?php

namespace App\Exceptions;

class CapitalCitiesDataHttpException extends \Exception
{
    public function __construct($message, $code = 0)
    {
        parent::__construct("The capital cities endpoint returned the following error: {$message}", $code);
    }
}
