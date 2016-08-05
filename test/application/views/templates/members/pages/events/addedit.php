<h1><i class="fa fa-calendar"></i><i class="fa fa-<?=$page['icon'] ?> fa-fw"></i><?=$page['title'] ?></h1>
<?  if (isset($success) && $success == true): ?>
<div class="success"><i class="fa fa-check-circle"></i>You have successfully <?=$action ?>ed the event.</div>
<?  else: ?>
<?=validation_errors(); ?>
<?  endif; ?>
<form action="/members/events/<?=$action . (!empty($event) ? '/' . $event['id'] : '') ?>" method="POST" name="addevent" id="addevent">
    <table>
        <tbody>
        <tr>
            <th>Name<span class="required">*</span></th>
            <td>
                <input type="text" id="name" name="name" class="field long" value="<?=($success === false ? set_value('name') : (!empty($event) ? $event['name'] : '')) ?>" />
                <div class="examples" id="examples_name">
                    e.g. <?=date('F Y') ?> Board Meeting, Easter Egg Hunt at Bridge Meadows!
                </div>
            </td>
        </tr>
        <tr>
            <th>Type<span class="required">*</span></th>
            <td>
                <select name="type_id" id="type">
                    <option value="1">(Select event type)</option>
<?  foreach ($event_types as $event_type): ?>
                    <option value="<?=$event_type['id'] ?>"<?=($success === false ? set_select('type_id', $event_type['id']) : (!empty($event) && $event['type_id'] == $event_type['id'] ? ' selected="selected"' : '')) ?>><?=$event_type['name'] ?></option>
<?  endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th>Status<span class="required">*</span></th>
            <td>
                <select name="status" id="status">
                    <option value="1" <?=($success === false ? set_select('status', 1) : (!empty($event['status']) ? ' selected="selected"' : '')) ?>>Confirmed</option>
                    <option value="-" <?=($success === false ? set_select('status', '-') : (!empty($event) && is_null($event['status']) ? ' selected="selected"' : '')) ?>>Tentative</option>
                </select>
            </td>
        </tr>
        <tr>
            <th>Start Date/Time<span class="required">*</span></th>
            <td>
                <input id="start_date" name="start_date" type="text" class="field short" value="<?=($success === false ? set_value('start_date') : (!empty($event) ? $event['date_start']['date_us'] : '')) ?>" />
                <input id="start_time" name="start_time" type="text" class="field short" value="<?=($success === false ? set_value('start_time') : (!empty($event) ? $event['date_start']['time_us'] : '')) ?>" />
                <label for="all_day_event"><input type="checkbox" id="all_day_event" name="all_day_event" value="1" <?=($success === false ? set_checkbox('all_day_event', 1) : (!empty($event['all_day_event']) ? ' checked="checked"' : '')) ?> /> All-day event</label>
                <label for="multiday_event"><input type="checkbox" id="multiday_event" name="multiday_event" value="1" <?=($success === false ? set_checkbox('multiday_event', 1) : (!empty($event['multiday_event']) ? ' checked="checked"' : '')) ?> /> Multiday event</label><br />
<?  if (set_value('all_day_event', (!empty($event) ? (int)$event['all_day_event'] : 0)) == 1): ?>
                    <script type="text/javascript">

                        $('document').ready(function()
                        {
                            $('#all_day_event').change();
                        });

                    </script>
<?  endif; ?>
<?  if (set_value('multiday_event', (!empty($event) ? (int)$event['multiday_event'] : 0)) == 1): ?>
                    <script type="text/javascript">

                        $('document').ready(function()
                        {
                            $('#multiday_event').change();
                        });

                    </script>
<?  endif; ?>
                <div class="examples" id="examples_start_date">
                    <code>m/d/yyyy</code> format, like <?=date('n/j/Y') ?>
                </div>
                <div class="examples" id="examples_start_time">
                    <code>h:mm am/pm</code> format, like <?=date('g:i a') ?>
                </div>
                <div id="date_events"></div>
            </td>
        </tr>
        <tr>
            <th>End Date/Time</th>
            <td>
                <input id="end_date" name="end_date" type="text" class="field short" value="<?=($success === false ? set_value('end_date') : (!empty($event) ? $event['date_end']['date_us'] : '')) ?>" />
                <input id="end_time" name="end_time" type="text" class="field short" value="<?=($success === false ? set_value('end_time') : (!empty($event) ? $event['date_end']['time_us'] : '')) ?>" />
                <label for="no_end_date"><input type="checkbox" id="no_end_date" name="no_end_date" value="1" <?=($success === false ? set_checkbox('no_end_date', 1) : '') ?> /> No end date/time</label><br />
<?  if (set_value('no_end_date', 0) == 1): ?>
                <script type="text/javascript">

                    $('document').ready(function()
                    {
                        $('#no_end_date').change();
                    });

                </script>
<?  endif; ?>
                <div class="examples" id="examples_end_date">
                    <code>m/d/yyyy</code> format, like <?=date('n/j/Y') ?>
                </div>
                <div class="examples" id="examples_end_time">
                    <code>h:mm am/pm</code> format, like <?=date('g:i a') ?>
                </div>
            </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <label for="rsvp_only"><input type="checkbox" id="rsvp_only" name="rsvp_only" value="1" <?=($success === false ? set_checkbox('rsvp_only', 1) : (!empty($event['rsvp_only']) ? ' checked="checked"' : '')) ?> /> RSVP-only</label>
            </td>
        </tr>
        <tr>
            <th>Location</th>
            <td>
                <input type="text" id="location" name="location" class="field long" value="<?=($success === false ? set_value('location') : (!empty($event) ? $event['location'] : '')) ?>" />
                <div class="examples" id="examples_location">
                    e.g. Children's Book Bank, Alycia's House
                </div>
            </td>
        </tr>
        <tr>
            <th>Street Address</th>
            <td>
                <textarea id="address" name="address" class="field small"><?=($success === false ? set_value('address') : (!empty($event) ? $event['address'] : '')) ?></textarea><br />
                <label for="hide_address"><input type="checkbox" id="hide_address" name="hide_address" value="1" <?=($success === false ? set_checkbox('hide_address', 1) : (!empty($event['hide_address']) ? ' checked="checked"' : '')) ?> /> Show address only to members</label>
                <div class="examples" id="examples_address">
                    e.g. 12345 Test Dr., Portland, OR 97201
                </div>
            </td>
        </tr>
        <tr>
            <th></th>
            <td>
                <div id="map"></div>
                <p>(Click on map to manually set icon)</p>
                <input type="hidden" id="latitude" name="latitude" value="<?=($success === false ? set_value('latitude') : (!empty($event) ? $event['latitude'] : '')) ?>" />
                <input type="hidden" id="longitude" name="longitude" value="<?=($success === false ? set_value('longitude') : (!empty($event) ? $event['longitude'] : '')) ?>" />
            </td>
        </tr>
        <tr>
            <th>Description</th>
            <td>
                <textarea id="description" name="description" class="big"><?=($success === false ? set_value('description') : (!empty($event) ? $event['description'] : '')) ?></textarea>
            </td>
        </tr>
        <tr>
            <th>Comments</th>
            <td>
                <textarea id="comments" name="comments" class="big"><?=($success === false ? set_value('comments') : (!empty($event) ? $event['comments'] : '')) ?></textarea><br />
                <p>Comments will not be visible on website</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" value="<?=$page['title'] ?>" />
                <input type="reset" value="Reset" />
                <input type="button" id="button_return" value="Return to Event List" />
            </td>
        </tr>
        </tbody>
    </table>
<?  if ((empty($event) && $success !== false) || !is_numeric(set_value('latitude', (!empty($event) ? $event['latitude'] : false))) || !is_numeric(set_value('longitude', (!empty($event) ? $event['longitude'] : false)))) : ?>
    <script src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
<?  else: ?>
    <script src="https://maps.googleapis.com/maps/api/js?callback=initMapReturn" async defer></script>
    <script type="text/javascript">

    function initMapReturn()
    {
        latLng = {lat: <?=set_value('latitude', (!empty($event) ? $event['latitude'] : '0')) ?>, lng: <?=set_value('longitude', (!empty($event) ? $event['longitude'] : '0')) ?>};
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 14,
            center: latLng
        });
        geocoder = new google.maps.Geocoder();

        addMarker(latLng);

        // Move marker when map is clicked
        map.addListener('click', function(event)
        {
            addMarker(event.latLng);
        });
    }

    </script>
<?  endif; ?>
</form>