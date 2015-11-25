<?php


class OnlineCalculator
{
    private $dayFirstDate;
    private $currentDate;
    private $sessionFirstDate;
    private $dayDuration;
    private $result = array();

    private function closeSession()
    {
        $this->dayDuration += $this->GetCurrentSessionDuration();
        $this->sessionFirstDate = 0;
    }

    private function closeDay()
    {
        $date = $this->dayFirstDate->getTimestamp() * 1000;
        $entry = array("date" => $date, "duration" => $this->dayDuration);
        $this->result[] = $entry;
    }

    private function addToDay($date)
    {
        $this->closeSession();

        if (sameDay($this->dayFirstDate, $date)) {
            $this->startNewSession($date);
            return true;
        }

        return false;
    }

    private function addToSession($date)
    {
        if (sameDay($this->currentDate, $date) && datesAreClose($this->currentDate, $date, 120)) {
            $this->currentDate = $date;
            return true;
        }

        return false;
    }

    private function startNewSession($date)
    {
        $this->currentDate = $date;
        $this->sessionFirstDate = $date;
    }

    private function startNewDay($date)
    {
        $this->dayDuration = 0;
        $this->dayFirstDate = $date;
        $this->startNewSession($date);
    }

    function __construct() {
        $dayFirstDate = null;
        $currentDate = null;
        $sessionFirstDate = null;
        $dayDuration = null;

    }

    public function getResult()
    {
        return $this->result;
    }


    public function add($date)
    {
        if ($this->currentDate === null) {
            $this->startNewDay($date);
            return;
        }

        if ($this->addToSession($date)) {
            return;
        }

        if ($this->addToDay($date)) {
            return;
        }

        $this->closeDay();
        $this->startNewDay($date);
    }

    private function GetCurrentSessionDuration()
    {
        $duration = dateIntervalInSeconds($this->sessionFirstDate, $this->currentDate) + 60;
        $fixedDuration = $duration - 60 * 14;
        if ($fixedDuration > 0)
            return $fixedDuration;

        return $duration;
    }
}