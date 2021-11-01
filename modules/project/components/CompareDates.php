<?php

namespace app\modules\project\components;

class CompareDates
{
    private $start, $end, $format;
    const DEFAULT_FORMAT = 'yyyy-dd-mm';

    public function __construct(string $start, string $end, string $format = self::DEFAULT_FORMAT)
    {
        $this->start = $start;
        $this->end = $end;
        $this->format = $format;
    }

    public function changeFormat(): CompareDates
    {

        if ($this->format !== self::DEFAULT_FORMAT) {
            $this->start = str_replace('/', '-', $this->start);
            $this->end = str_replace('/', '-', $this->end);
        }

        return $this;
    }

    public function parseToDate(): CompareDates
    {
        $this->start = date('Y-m-d', strtotime($this->start));
        $this->end = date('Y-m-d', strtotime($this->end));
        return $this;
    }

    public function isStartGreaterThanEnd(): bool
    {
        return $this->start > $this->end;
    }

    public function areDateEquals(): bool
    {
        return $this->start == $this->end;
    }

    public function isStartGreaterOrEqualsThanEnd(): bool
    {
        return $this->start >= $this->end;
    }

}