<?php

namespace App\Contracts\Response;

use \Symfony\Component\HttpFoundation\Response;

interface ResponseStrategy
{
    public function render($data): Response;
}

