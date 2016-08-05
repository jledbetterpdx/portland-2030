<script type="text/javascript">

    $(document).ready(function()
    {
        var $button = $('#cal-add-howto a');

        $button.on('click', function()
        {
            // Set "contants"
            var POP_HEIGHT = 500;
            var POP_WIDTH  = 600;

            // Get current screen dimensions
            var h = screen.height;
            var w = screen.width;

            // Get position for centering
            var t = (h - POP_HEIGHT) / 2;
            var l = (w - POP_WIDTH) / 2;

            window.open('/events/popup/import-ical', 'howto', 'height=' + POP_HEIGHT + ',top=' + t + ',left=' + l + ',width=' + POP_WIDTH + ',location=no,menubar=no,status=no,toolbar=no');
        });
    });

</script>