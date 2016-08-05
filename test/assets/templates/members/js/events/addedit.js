var map, geocoder;
var markers = [];
var image = '/assets/img/map-marker.png';

function initMap()
{
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: {lat: 45.52, lng: -122.681944}
    });
    geocoder = new google.maps.Geocoder();

    // Move marker when map is clicked
    map.addListener('click', function(event)
    {
        addMarker(event.latLng);
    });
}

function geocodeAddress()
{
    var address = document.getElementById('address').value;
    geocoder.geocode({'address': address}, function(results, status)
    {
        if (status === google.maps.GeocoderStatus.OK)
        {
            // Center map on location
            map.setCenter(results[0].geometry.location);

            // Adjust zoom
            map.setZoom(14);

            // Add marker to map/array
            addMarker(results[0].geometry.location);
        }
        else if (status === google.maps.GeocoderStatus.ZERO_RESULTS)
        {
            alert('Geocode was not successful for the following reason: Nothing found');
        }
        else
        {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

function addMarker(location)
{
    // Clear all markers
    clearOverlays();

    // Add marker
    var marker = new google.maps.Marker({
        position: location,
        map: map,
        icon: image
    });
    markers.push(marker);

    // Set latitude/longitude
    $('#latitude').val(location.lat());
    $('#longitude').val(location.lng());
}

function clearOverlays()
{
    // Remove markers from map
    for (var i = 0; i < markers.length; i++)
    {
        markers[i].setMap(null);
    }

    // Delete markers from array
    markers.length = 0;

    // Reset hidden latitude/longitude
    $('#latitude').val();
    $('#longitude').val();
}

$(document).ready(function()
{
    var $field = $('.field');

    $field.on('focus', function()
    {
        $this       = $(this);
        id          = $this.attr('id');
        $example    = $('#examples_' + id);

        if (console)
        {
            console.log('$this    = ' + $this.attr('id'));
            console.log('id       = ' + id);
            console.log('$example = ' + $example.attr('id'));
        }

        $example.show(0);
    });

    $field.on('blur', function()
    {
        $this       = $(this);
        id          = $this.attr('id');
        $example    = $('#examples_' + id);

        if (console)
        {
            console.log('$this    = ' + $this.attr('id'));
            console.log('id       = ' + id);
            console.log('$example = ' + $example.attr('id'));
        }

        $example.hide(0);
    });

    var $all_day_event  = $('#all_day_event');
    var $multiday_event = $('#multiday_event');
    var $no_end_date    = $('#no_end_date');

    $all_day_event.on('change', function()
    {
        checked = $all_day_event.prop('checked');
        visible = (checked ? 'hidden' : 'visible');
        $('#start_time').prop('disabled', checked).css('visibility', visible);
        $('#end_time').prop('disabled', (checked || $no_end_date.prop('checked'))).css('visibility', visible);
    });

    $no_end_date.on('change', function()
    {
        checked = $no_end_date.prop('checked');
        $('#end_date').prop('disabled', checked).val('');
        $('#end_time').prop('disabled', (checked || $all_day_event.prop('checked'))).val('');
        $multiday_event.prop('disabled', checked);
        if ($multiday_event.prop('checked'))
        {
            $multiday_event.prop('checked', false).change();
        }
    });

    $multiday_event.on('change', function()
    {
        checked = $multiday_event.prop('checked');
        $all_day_event.prop('checked', checked).prop('disabled', checked).change();
    });

    $('#button_return').on('click', function()
    {
        window.location = '/members/events';
    });

    /* Google Maps code */
    $('#address').on('change', function()
    {
        geocodeAddress();
    });

    /* Redactor WYSIWYG editor code */
    var buttons = ['bold', 'italic', 'underline', 'deleted', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'fontcolor', 'backcolor', '|', 'unorderedlist', 'orderedlist', 'indent', 'outdent', '|', 'image', 'video', 'file', 'table', 'link', '|', 'horizontalrule'];

    $('#description').redactor({
        buttons: buttons,
        minHeight: 225
    });

    $('#comments').redactor({
        buttons: buttons,
        minHeight: 225
    });

});