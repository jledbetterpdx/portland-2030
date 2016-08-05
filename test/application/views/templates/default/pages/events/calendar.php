<h1>Events Calendar</h1>
    <table id="cal">
    <caption class="calheader">
<?  if (time() <= mktime(0, 0, 0, $cal['month'] + 1, 1, $cal['year'])): ?>
        <aside id="cal-add-button-container">
            <span id="cal-add-button">
                <a href="/ics/<?=$cal['year'] ?>/<?=$cal['month'] ?>" rel="nofollow">
                    <i class="fa fa-calendar"></i> Add <?=date('F Y', mktime(0, 0, 0, $cal['month'], 1, $cal['year'])) ?> to Calendar<sup>beta</sup>
                </a>
            </span>
            <span id="cal-add-howto">
                <a href="javascript:void(0);" title="Import iCalendar File Help">
                    <i class="fa fa-question-circle"></i>
                </a>
            </span>
        </aside>
<?  endif; ?>
<?  if (!is_null($cal['prev'])): ?>
            <a class="calnav prev" href="/calendar/<?=$cal['prev']['year'] ?>/<?=$cal['prev']['month'] ?>" rel="nofollow">&lt;&lt;</a>
<?  else: ?>
            <span class="calnav prev">&lt;&lt;</span>
<?  endif; ?>
<?=date('F Y', mktime(0, 0, 0, $cal['month'], 1, $cal['year'])) ?>
<?  if ($cal['next']['year'] >= 2013): ?>
            <a class="calnav next" href="/calendar/<?=$cal['next']['year'] ?>/<?=$cal['next']['month'] ?>" rel="nofollow">&gt;&gt;</a>
<?  else: ?>
            <span class="calnav next">&gt;&gt;</span>
<?  endif; ?>
    </caption>
    <tr class="caldows">
<?  foreach($cal['dows'] as $dow): ?>
        <th class="caldow"><?=$dow ?></th>
<?  endforeach; ?>
<?

// Set temporary day, month, and year values
$_d = date('j', $cal['start']);
$_m = date('n', $cal['start']);
$_y = date('Y', $cal['start']);

// Get today values
$td = date('j');
$tm = date('n');
$ty = date('Y');

do
{
    // Get actual day, month, and year values
    $actual = mktime(0, 0, 0, $_m, $_d, $_y);
    $ad     = date('j', $actual);
    $am     = date('n', $actual);
    $ay     = date('Y', $actual);
    $adow   = date('w', $actual);
    $akey   = date('Y-m-d', $actual);

    // Set some flags
    $is_other = ($am != $cal['month'] || $ay != $cal['year']);
    $is_today = ($am == $tm && $ad == $td && $ay == $ty);

    if ($adow == 0):
?>
    </tr>
    <tr class="calweek">
<?  endif; ?>
        <td class="calday<?=($is_other ? ' other' : ($is_today ? ' today' : '')) ?>">
            <div class="caldaynum"><?=$ad ?></div>
<?
    if (is_array($events) && array_key_exists($akey, $events) && !empty($events[$akey])):
        foreach ($events[$akey] as $event):
            if (is_null($event['status']) || $event['status'] != 0):
?>
            <div class="calevent<?=(!empty($event['css_class']) ? ' ' . $event['css_class'] : '') ?>">
                <a class="callink" href="/event/<?=$event['_data']['full_slug'] ?>" title="<?=$event['name'] ?>"></a>
                <div class="caleventname"><?=$event['name'] ?></div>
<?              if (!$is_other): ?>
                <div class="caleventtype"><i class="<?=$event['icon_family'] . ' ' . $event['icon'] ?>"></i><?=$event['type_name'] ?></div>
                <div class="caleventtime"><i class="fa fa-clock-o"></i><?=$event['date_start']['time_text'] ?></div>
<?                  if (is_null($event['status'])): ?>
                    <div class="caleventstatus"><i class="fa fa-question"></i>Tentative</div>
<?
                    endif;
                    if (!empty($event['location'])):
?>
                <div class="caleventloc"><i class="fa fa-map-marker"></i><?=$event['location'] ?></div>
<?                  endif; ?>
<?              endif; ?>
            </div>
<?
            endif;
        endforeach;
    endif;
?>
        </td>
<?
    $_d++;  // Increment counter day value
} while (mktime(0, 0, 0, $_m, $_d, $_y) <= $cal['end']);
?>
    </tr>
</table>