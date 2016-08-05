<?  if ($event['_data']['valid_latlng']): ?>
<script type="text/javascript">

    $(document).ready(function()
    {
        var mapOptions = {
            center: { lat: <?=$event['latitude'] ?>, lng: <?=$event['longitude'] ?>},
            zoom: 15
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        var image = '/assets/img/map-marker.png'
        var marker = new google.maps.Marker({
            position: mapOptions.center,
            map: map,
            title:'<?=addslashes($event['name']) ?>',
            icon:image
        });
    });

</script>
<?  endif; ?>
<h1><i id="event-type" class="<?=$event['icon_family'] ?> <?=$event['icon'] ?>"></i><?=$event['name'] ?></h1>
<aside id="map-canvas">
<?  if ($event['_data']['valid_latlng']): ?>
    <p>Loading map...</p>
<?  else: ?>
    <p>No map to display</p>
<?  endif; ?>
</aside>
<aside class="cal-icon-container">
    <div class="cal-icon">
        <div class="cal-icon-banner">
            <div class="cal-icon-month"><?=$event['date_start']['month_abbrev'] ?></div>
            <div class="cal-icon-dow"><?=$event['date_start']['dow_abbrev'] ?></div>
        </div>
        <div class="cal-icon-body">
            <div class="cal-icon-day"><?=$event['date_start']['day'] ?></div>
        </div>
    </div>
</aside>
<ul id="event_info" class="fa-ul">
    <li title="Time: <?=$event['_data']['time_range'] ?>"><i class="fa-li fa fa-clock-o"></i> <?=$event['_data']['time_range'] ?></li>
    <li title="Location: <?=$event['_data']['full_address_line'] ?>"><i class="fa-li fa fa-map-marker"></i> <?=$event['_data']['full_address_br'] ?></li>
<?  if ($event['rsvp_only']): ?>
    <li title="RSVP Only" class="rsvp"><i class="fa-li fa fa-check-square-o"></i> RSVP Only</li>
<?  endif; ?>
<?  if (time() < $event['date_start']['unix']): ?>
    <li>
        <span id="cal-add-button">
            <a href="<?=$event['_calendars']['ical'] ?>" rel="nofollow" title="Add to Calendar">
                <i class="fa fa-calendar"></i> Add to Calendar<sup>beta</sup>
            </a>
        </span>
        <span id="cal-add-howto">
            <a href="javascript:void(0);" title="Import iCalendar File Help">
                <i class="fa fa-question-circle"></i>
            </a>
        </span>
    </li>
<?  endif; ?>
</ul>
<div class="clearfix-left"></div>
<div id="event_desc">
<?=$event['description'] ?>
</div>
<div class="clearfix"></div>
<div id="cal-back-button"><a href="/calendar/<?=$event['date_start']['year'] ?>/<?=$event['date_start']['month'] ?>"><i class="fa fa-arrow-left"></i> Back to Calendar</a></div>