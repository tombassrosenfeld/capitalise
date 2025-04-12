<?php

namespace App\Exceptions;

class CapitalCitiesDataHttpException extends \Exception
{
    public function __construct()
    {
        parent::__construct("The third party capital cities API is returning an error.");
    }
}
