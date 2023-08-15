<?php
class BendMeterReading extends DbObject
{
    public $bend_meter_id;
    public $bend_electricity_period_id;
    public $d_date;
    public $value;
    public $notes;
    public $previous_value; // DEPRECATED do not use

    public function getMeter()
    {
        return BendService::getInstance($this->w)->getMeterForId($this->bend_meter_id);
    }

    public function getElectricityPeriod()
    {
        return BendService::getInstance($this->w)->getElectricityPeriodForId($this->bend_electricity_period_id);
    }

    public function getPreviousValue()
    {
        $readings = $this->getObjects("BendMeterReading", [["bend_meter_id",$this->bend_meter_id], ["d_date < ",$this->d_date]], false, true, ["d_date DESC"]);
        $previous_reading =  !empty($readings) ? $readings[0] : null;
        return !empty($previous_reading) ? $previous_reading->value : $this->getMeter()->start_value;
    }
}
