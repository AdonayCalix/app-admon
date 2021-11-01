<?php

namespace app\modules\project\components;

use Carbon\Carbon;

class FormatDate
{

    private $date;
    private $originFormat;
    private $newFormat;

    const DEFAULT_FORMAT = 'Y-m-d';

    public function __construct(string $date, string $originFormat, string $newFormat)
    {
        $this->date = $date;
        $this->originFormat = $originFormat;
        $this->newFormat = $newFormat;
    }

    public function change(): FormatDate
    {
        $dateObject = null;

        if ($this->originFormat !== self::DEFAULT_FORMAT) {
            $dateObject = \DateTime::createFromFormat($this->originFormat, $this->date);
        } else {
            $dateObject = Carbon::parse($this->date);
        }

        $this->date = $dateObject->format($this->newFormat);

        return $this;
    }

    public function asString(): string
    {
        return $this->date;
    }
}