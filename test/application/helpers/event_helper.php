<?php

function process_event_data(&$event)
{
    // Assign temporary variables here
    $_abstract = explode(PHP_EOL, wordwrap(strip_tags($event['description']), 200));

    // Convert tinyint values to boolean
    $event['all_day_event']  = (bool)$event['all_day_event'];
    $event['multiday_event'] = (bool)$event['multiday_event'];
    $event['national_event'] = (bool)$event['national_event'];
    $event['hide_address']   = (bool)$event['hide_address'];
    $event['rsvp_only']      = (bool)$event['rsvp_only'];
    $event['status']         = (is_null($event['status']) ? null : (bool)$event['status']);

    // Date logic!
    $event['date_start']        = explode_date($event['date_start'], $event['all_day_event']);
    $event['date_end']          = explode_date($event['date_end'], $event['all_day_event']);
    $event['date_added']        = explode_date($event['date_added']);
    $event['date_last_updated'] = explode_date($event['date_last_updated']);

    // Create new array key
    $event['_data'] = array();

    // Add values
    $event['_data']['time_range']        = ($event['all_day_event'] ? 'All Day' : $event['date_start']['time_text']) . (!empty($event['date_end']['datetime']) ? ' &ndash; ' . $event['date_end']['time_text'] : '');
    $event['_data']['valid_latlng']      = (!empty($event['latitude']) && !empty($event['longitude']));
    $event['_data']['full_address']      = trim((is_null($event['location']) ? 'TBD' : (!empty($event['location']) ? $event['location'] : '')) . (!empty($event['address']) && !$event['hide_address'] ? PHP_EOL . $event['address'] : ''));
    $event['_data']['full_address_line'] = str_ireplace(array("\r\n", "\n", "\r"), ', ', $event['_data']['full_address']);
    $event['_data']['full_address_br']   = nl2br($event['_data']['full_address']);
    $event['_data']['abstract']          = (!empty($_abstract) ? $_abstract[0] : '');
    $event['_data']['status_text']       = (is_null($event['status']) ? 'Tentative' : ($event['status'] === true ? 'Confirmed' : 'Cancelled'));
    $event['_data']['full_slug']         = $event['date_start']['year'] . '/' . $event['date_start']['month'] . '/' . $event['slug'];

    // Create calendars array
    $event['_calendars'] = array();

    // Add values
    $event['_calendars']['google']       = 'http://www.google.com/calendar/event?action=TEMPLATE&text=' . rawurlencode($event['name']) . '&dates=' . $event['date_start']['gcal'] . '/' . $event['date_end']['gcal'] . '&details=' . rawurlencode(strip_tags($event['description'])) . '&location=' . rawurlencode($event['_data']['full_address_line']) . '&trp=false&sprop=&sprop=name:';
    $event['_calendars']['google_local'] = 'http://www.google.com/calendar/event?action=TEMPLATE&text=' . rawurlencode($event['name']) . '&dates=' . $event['date_start']['gcal_local'] . '/' . $event['date_end']['gcal_local'] . '&ctz=America/Los_Angeles&details=' . rawurlencode(strip_tags($event['description'])) . '&location=' . rawurlencode($event['_data']['full_address_line']) . '&trp=false&sprop=&sprop=name:';
    $event['_calendars']['ical']         = '/ics/' . $event['_data']['full_slug'];
}

function explode_date($date, $is_all_day_event = null)
{
    $_dows     = array('Su', 'M', 'T', 'W', 'Th', 'F', 'Sa');
    $timestamp = @strtotime($date);
    $return    = array
    (
        'datetime'            => $date,
        'unix'                => $timestamp,
        'date'                => @date('Y-m-d', $timestamp),
        'date_us'             => @date('n/j/Y', $timestamp),
        'date_text'           => @date('F j, Y', $timestamp),
        'time'                => @date('H:i:s', $timestamp),
        'time_us'             => @date('g:i a', $timestamp),
        'time_text'           => @date('g:i a', $timestamp),
        'datetime_us'         => @date('n/j/Y g:i a', $timestamp),
        'day'                 => @date('j', $timestamp),
        'month'               => @date('n', $timestamp),
        'month_text'          => @date('F', $timestamp),
        'month_abbrev'        => @date('M', $timestamp),
        'year'                => @date('Y', $timestamp),
        'dow'                 => @date('w', $timestamp),
        'dow_text'            => @date('l', $timestamp),
        'dow_abbrev'          => @$_dows[date('w', $timestamp)],
        'gcal'                => @gmdate('Ymd', $timestamp) . (!empty($is_all_day_event) ? '' : 'T' . @gmdate('His', $timestamp) . 'Z'),
        'gcal_local'          => @date('Ymd', $timestamp) . (!empty($is_all_day_event) ? '' : 'T' . @date('His', $timestamp)),
        'gcal_local_tz'       => 'America/Los_Angeles',
        'ical'                => @gmdate('Ymd', $timestamp) . 'T' . (!empty($is_all_day_event) ? '000000' : @gmdate('His', $timestamp)) . 'Z',
        'ical_alt'            => @gmdate('Ymd', $timestamp) . (!empty($is_all_day_event) ? '' : 'T' . @gmdate('His', $timestamp) . 'Z'),
        'ical_alt_type'       => (!empty($is_all_day_event) ? ';VALUE=DATE' : ''),
    );

    return $return;
}