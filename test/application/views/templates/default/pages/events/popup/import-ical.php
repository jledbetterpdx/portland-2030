<script type="text/javascript">

    $(document).ready(function()
    {
        var $software = $('#software');
        var $all_inst = $('.software-instructions');

        $software.on('change', function()
        {
            $all_inst.removeClass('show');
            if ($software.val() != '')
            {
                $('#software-' + $software.val()).addClass('show');
            }
            else
            {
                $('#software-default').addClass('show');
            }
        });
    });

</script>
<p>Clicking the &quot;Add to Calendar&quot; button allows you to add our events to your personal calendar, by importing an iCalendar file in your calendar software. Select a software or website in the list for instructions on how to add our events.</p>
<select id="software">
    <option value="">(Select Software or Site)</option>
    <option value="google-calendar-site">Google Calendar website</option>
    <option value="google-calendar-android">Google Calendar for Android</option>
    <option value="microsoft-outlook">Microsoft Outlook</option>
    <option value="apple-calendar">Apple Calendar</option>
</select>
<div id="software-default" class="software-instructions show">
    (No software selected)
</div>
<div id="software-google-calendar-site" class="software-instructions">
    <h2>Google Calendar Website Instructions</h2>
    <ol>
        <li>Download the .ics file from our website.</li>
        <li>After logging into Google Calendar, click the <i class="fa fa-caret-square-o-down"></i> next to <q class="menu">Other Calendars</q> to bring up a popup menu.</li>
        <li>Click on <q class="menu">Import Calendar</q>.</li>
        <li>Select the .ics file you just downloaded, optionally select a calendar you wish to add the events to, and click <q class="button">Import</q>.</li>
        <li>A popup dialog will inform you how many events were successfully added to your calendar.</li>
    </ol>
    <p><i class="fa fa-info-circle"></i> <b>Hint:</b> We may update our calendar to add, change or remove events, so we encourage you to follow these steps regularly. Don't worry about duplication &mdash; Google Calendar won't duplicate existing events in your calendar, and will remove any events we cancel without you needing to do anything.</p>
</div>
<div id="software-google-calendar-android" class="software-instructions">
    <h2>Google Calendar for Android Instructions</h2>
    <p>Google does not currently offer a native way to import .ics files using Google Calendar for Andriod. You will need to <a href="market://search?q=ics+importer&c=apps">search for apps in the Play Store</a> that can import these files for you.</p>
</div>
<div id="software-microsoft-outlook" class="software-instructions">
    <h2>Microsoft Outlook Instructions</h2>
    <ol>
        <li>Download the .ics file from our website.</li>
        <li>Once downloaded, open the .ics file. If Outlook is properly set up, a popup window will appear.</li>
        <li>Click <q class="button">Import</q>.</li>
    </ol>
    <p><i class="fa fa-info-circle"></i> <b>Hint:</b> We may update our calendar to add, change or remove events, so we encourage you to follow these steps regularly. Don't worry about duplication &mdash; Microsoft Outlook won't duplicate existing events in your calendar, and will remove any events we cancel without you needing to do anything.</p>
</div>
<div id="software-apple-calendar" class="software-instructions">
    <h2>Apple Calendar Instructions</h2>
    <h3>Using <q class="menu">Import</q> menu</h3>
    <ol>
        <li>Download the .ics file from our website.</li>
        <li>In your Calendar menu, go to <q class="menu">File &rarr; Import &rarr; Import</q>.</li>
        <li>Select the .ics file you just downloaded and click <q class="button">Import</q>.</li>
        <li>Select a calendar you wish to add the events to.</li>
    </ol>
    <h3>Using Drag-and-Drop</h3>
    <ol>
        <li>Download the .ics file from our website.</li>
        <li>In Calendar, select the calendar where you want to import the events into from the Calendar list.</li>
        <li>Drag the .ics file you just downloaded into the Calendar window.</li>
    </ol>
</div>