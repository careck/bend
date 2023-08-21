<?php echo $form ?>
<script language="javascript">
    $(document).ready(function() {
        $("#bend_household_id").on("change", function(event) {

            // Get/check for extra form fields
            $.getJSON("/bend-electricity/ajax_getmetersforhousehold/" + $("#bend_household_id").val(),
                function(result) {
                    var html = '';
                    for (var i = 0, len = result.length; i < len; i++) {
                        var mt = result[i];
                        html += ('<option value="' + mt.id + '">' + mt.meter_number + " (" + (mt.is_inverter ? "INVERTER" : "METER") + ")" + '</option>');
                    }
                    $('#bend_meter_id').html(html);
                }
            );
        });
    });
</script>