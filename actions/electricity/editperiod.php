<?php
function editperiod_GET(Web $w)
{
    list($periodid) = $w->pathMatch("electricityperiodid");
    $period = empty($periodid) ? new BendElectricityPeriod($w) : BendService::getInstance($w)->getElectricityPeriodForId($periodid);

    $form ["Date"] = [
        [
            ["Invoice Date", "date", "d_provider_invoice", formatDate($period->d_provider_invoice)],
            ["Period Start", "date", "d_provider_period_start", formatDate($period->d_provider_period_start)],
            ["Period End", "date", "d_provider_period_end", formatDate($period->d_provider_period_end)],
        ]
    ];

    $form ["Provider"] = [
        [
            ["Invoice Total inc. GST", "text", "provider_invoice_total_inc_gst", $period->provider_invoice_total_inc_gst],
            ["Provider Total Consumption", "text", "provider_total_consumption_kwh", $period->provider_total_consumption_kwh],
            ["Provider Total Production", "text", "provider_total_production_kwh", $period->provider_total_production_kwh],
        ]
    ];

    $form ["Bend"] = [
        [
            ["Bend Total Consumption", "text", "bend_total_consumption_kwh", $period->bend_total_consumption_kwh],
            ["Bend Total Production", "text", "bend_total_production_kwh", $period->bend_total_production_kwh],
            ["Bend Total Invoiced", "text", "bend_total_invoiced", $period->bend_total_invoiced],
        ]
    ];

    $w->out(Html::multiColForm($form, "/bend-electricity/editperiod/{$periodid}", "POST", "Save")); 

};

function editperiod_POST(Web $w)
{
    list($periodid) = $w->pathMatch("electricityperiodid");
    $period = empty($periodid) ? new BendElectricityPeriod($w) : BendService::getInstance($w)->getElectricityPeriodForId($periodid);

    $period->fill($_POST);
    $period->insertOrUpdate();

    $w->msg("Period Updated", "/bend-electricity/admin/#periods");
};
