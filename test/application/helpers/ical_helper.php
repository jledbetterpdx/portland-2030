<?php

define('ICAL_LINE_LENGTH', 75);
define('ICAL_NEWLINE', "\r\n");
define('ICAL_LINE_FOLD', ' ');

function ical_fold_line($param, $line)
{
    $_a = str_split($param . ':' . $line, ICAL_LINE_LENGTH);
    $_b = array(array_shift($_a));

    if (!empty($_a))
    {
        $_a = str_split(implode('', $_a), ICAL_LINE_LENGTH - 1);
        $_b = array_merge($_b, $_a);
    }
    return implode(ICAL_NEWLINE . ICAL_LINE_FOLD, $_b) . ICAL_NEWLINE;
}

function ical_escape_text($text)
{
    // Find/replace lists
    $find    = array('\\', "\r\n", "\r", "\n", ',', ';');
    $replace = array('\\\\', '\n', '\n', '\n', '\,', '\;');

    // Replace values in text
    return str_ireplace($find, $replace, $text);
}

function ical_build_calendar($events, $name)
{
    // Output variable
    $output = array();

    // Start building calendar
    $output[] = ical_fold_line('BEGIN', 'VCALENDAR');
    $output[] = ical_fold_line('VERSION', '2.0');
    $output[] = ical_fold_line('PRODID', '-//Active 20-30 PDX//iCal Export v1.0//EN');
    $output[] = ical_fold_line('CALSCALE', 'GREGORIAN');
    $output[] = ical_fold_line('METHOD', 'PUBLISH');
    $output[] = ical_fold_line('X-WR-CALNAME', ical_escape_text($name));
    $output[] = ical_fold_line('X-WR-TIMEZONE', 'America/Los_Angeles');

    // Loop through each event
    foreach ($events as $event)
    {
        // Build event parameters
        $output[] = ical_fold_line('BEGIN', 'VEVENT');
        $output[] = ical_fold_line('UID', 'event-' . md5($event['_data']['full_slug']) . '@portland2030.org');
        $output[] = ical_fold_line('DTSTAMP', $event['date_last_updated']['ical']);
        $output[] = ical_fold_line('DTSTART' . $event['date_start']['ical_alt_type'], $event['date_start']['ical_alt']);
        $output[] = ical_fold_line('DTEND' . $event['date_end']['ical_alt_type'], $event['date_end']['ical_alt']);
        if ($event['all_day_event'])
        {
            $output[] = ical_fold_line('X-FUNAMBOL-ALLDAY', 'TRUE');
            $output[] = ical_fold_line('X-MICROSOFT-CDO-ALLDAYEVENT', 'TRUE');
        }
        $output[] = ical_fold_line('SUMMARY', ical_escape_text($event['name']));
        $output[] = ical_fold_line('STATUS', strtoupper($event['_data']['status_text']));
        $output[] = ical_fold_line('DESCRIPTION', ical_strip_tags($event['description']));
        $output[] = ical_fold_line('X-ALT-DESC;FMTTYPE=text/html', ical_escape_newlines($event['description']));
        if (!empty($event['location']))
        {
            $output[] = ical_fold_line('LOCATION', ical_escape_text($event['_data']['full_address_line']));
        }
        if ($event['_data']['valid_latlng'])
        {
            $output[] = ical_fold_line('GEO', $event['latitude'] . ';' . $event['longitude']);
        }
        $output[] = ical_fold_line('URL;VALUE=URI', WWW .'/event/' . $event['_data']['full_slug']);
        $output[] = ical_fold_line('CREATED', $event['date_added']['ical']);
        $output[] = ical_fold_line('LAST-MODIFIED', $event['date_last_updated']['ical']);
        $output[] = ical_fold_line('CATEGORIES', $event['type_name']);
        $output[] = ical_fold_line('END', 'VEVENT');
    }

    // End calendar
    $output[] = ical_fold_line('END', 'VCALENDAR');

    // Implode lines (SHOULD retain CRLFs in between all lines and at the end of the calendar
    return implode('', $output);
}

function ical_strip_tags($text)
{
    return ical_escape_text(strip_tags($text));
}

function ical_escape_newlines($text)
{
    return str_ireplace(array("\r\n", "\r", "\n"), '\n', $text);
}