<?php
class BendElectricityPeriod extends DbObject
{

    public $d_provider_invoice;
    public $d_provider_period_start;
    public $d_provider_period_end;

    public $provider_invoice_total_inc_gst;
    public $provider_total_consumption_kwh;
    public $provider_total_production_kwh;

    public $bend_total_consumption_kwh;
    public $bend_total_production_kwh;
    public $bend_total_invoiced;

    /**
     * Used by the Html::select() function to display this object in
     * a select list. Should also be used by other similar functions.
     *
     * @return string
     */
    public function getSelectOptionTitle()
    {
        return formatDate($this->d_provider_period_start) . " - " . formatDate($this->d_provider_period_end);
    }

    
    public function getBendTotalConsumption()
    {
        $meters = BendService::getInstance($this->w)->getAllMeters();
        $total = 0;
        foreach ($meters as $meter) {
            if ($meter->is_inverter == 0) {
                $readings = $meter->getReadings();
                foreach ($readings as $reading) {
                    if ($reading->bend_electricity_period_id == $this->id) {
                        $total += $reading->value;
                    }
                }
            }
        }
        return $total;
    
    }
    
    public function getBendTotalProduction()
    {
        $meters = BendService::getInstance($this->w)->getAllMeters();
        $total = 0;
        foreach ($meters as $meter) {
            if ($meter->is_inverter == 1) {
                $readings = $meter->getReadings();
                foreach ($readings as $reading) {
                    if ($reading->bend_electricity_period_id == $this->id) {
                        $total += $reading->value;
                    }
                }
            }
        }
        return $total;
    
    }
    
}
