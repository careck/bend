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

    public function getLastReadingValue() {
        return !empty($this->getLastReading()) ? $this->getLastReading()->value : $this->start_value;
    }

}
