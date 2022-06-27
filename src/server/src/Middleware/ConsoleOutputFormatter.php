<?php

namespace App\Middleware;

use DateTime;
use Symfony\Component\Console\Formatter\OutputFormatter;

class ConsoleOutputFormatter extends OutputFormatter
{
    public function format(?string $message)
    {
        $date = (new DateTime())->format('Y-m-d H:i:s');

        return parent::format("[$date] $message");
    }
}
