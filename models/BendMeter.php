<?php
class BendMeter extends DbObject
{

    public $is_inverter;
    public $_is_inverter_ui_select_lookup_code = "yesno";
    public $bend_household_id;
    public $bend_lot_id;
    public $meter_number;
    public $start_value;
    public $last_reading_value; //deprecated do not use!!!
    public $d_start;
    public $d_end;
    public $is_active;
    public $_is_active_ui_select_lookup_code = "yesno";

    public function getReadings()
    {
        return $this->getObjects("BendMeterReading", ["bend_meter_id" => $this->id]);
    }

    public function getLastReading()
    {
        $readings = $this->getObjects("BendMeterReading", ["bend_meter_id" => $this->id], false, true, ["d_date DESC"]);
        return !empty($readings) ? $readings[0] : null;
    }

    public function getLastReadingValue() 
    {
        return !empty($this->getLastReading()) ? $this->getLastReading()->value : $this->start_value;
    }

    public function getHousehold()
    {
        return $this->getObject("BendHousehold", $this->bend_household_id);
    }

    public function getSelectOptionTitle() 
    {
        return $this->meter_number . " (" . ($this->is_inverter ? "INVERTER" : "METER") . ")";
    }

    public function getDifferenceForPeriodId($periodid)
    {
        $readings = $this->getObjects("BendMeterReading", ["bend_meter_id" => $this->id], false, true, ["d_date DESC"]);
        foreach ($readings as $index => $reading) {
            if ($reading->bend_electricity_period_id == $periodid) {
                $current = $reading->value;
                $previous = $index == sizeof($readings) - 1 ? $this->start_value : $readings[$index + 1]->value;
                return $current - $previous;
            }
        }
    }    
}
