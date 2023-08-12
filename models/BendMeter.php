<?php
class BendMeter extends DbObject {
    
    public $is_inverter;
    public $_is_inverter_ui_select_lookup_code = "yesno";
    public $bend_household_id;
    public $bend_lot_id;
    public $meter_number;
    public $start_value;
    public $last_reading_value;
    public $d_start;
    public $d_end;
    public $is_active;
    public $_is_active_ui_select_lookup_code = "yesno";
}
