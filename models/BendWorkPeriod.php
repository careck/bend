<?php

class BendWorkPeriod extends DbObject
{
    public $d_start;
    public $d_end;
    public $is_closed;
    public $monthly_person_hours;
    public $sapphs_per_hour = 20; // default


    public function getSelectOptionTitle()
    {
        return formatDate($this->d_start) . " - " . formatDate($this->d_end);
    }

    public function getWorkhours()
    {
        return BendService::getInstance($this->w)->getWorkentriesForPeriod($this);
    }

    public function getNumberOfMonths()
    {
        return BendService::diffInMonths(new DateTime(formatDate($this->d_start, "Y-m-d")), new DateTime(formatDate($this->d_end, "Y-m-d")));
    }

    public function getSinglePersonBudget()
    {
        return $this->getNumberOfMonths() * $this->monthly_person_hours;
    }

    /**
     * return a list of occupants which have been active during this work period
     * @return NULL
     */
    public function getOccupants()
    {
        $occupants = $this->getObjects("BendHouseholdOccupant", ["is_deleted" => 0, "does_workhours" => 1]);
        return empty($occupants) ? null :
            array_filter($occupants, function ($oc) {
                return $oc->d_start < $this->d_end && (empty($oc->d_end) || $oc->d_end > $this->d_start);
            });
    }

    public function getAllPersonsBudget()
    {
        // the budget is the sum of all eligible persons 
        // times the monthly person budget for
        // each month of this period
        $budget = 0;
        $occupants = $this->getOccupants();
        if (!empty($occupants)) {
            return sizeof($occupants) * $this->getSinglePersonBudget();
        }
        return $budget;
    }

    public function getTotalHoursLogged()
    {
        $hours = 0;
        $workhours = $this->getWorkhours();
        if (!empty($workhours)) {
            foreach ($workhours as $wh) {
                $hours += $wh->hours;
            }
        }
        return $hours;
    }

    public function getSapphsForHours($hours)
    {
        return $this->sapphs_per_hour * $hours;
    }
}