<h1><i class="fa fa-calendar fa-fw"></i>Events List</h1>
<?  if (!empty($this->session->flashdata('message'))): ?>
<div id="message" class="<?=$this->session->flashdata('class') ?>"><?=$this->session->flashdata('message') ?></div>
<?  endif; ?>
<div id="tab-container" class="tab-container">
    <ul class="etabs">
        <li class="tab"><a href="#upcoming"><i class="fa fa-forward fa-fw"></i>Upcoming</a></li>
        <li class="tab"><a href="#past"><i class="fa fa-backward fa-fw"></i>Past</a></li>
        <li class="tab"><a href="#tentative"><i class="fa fa-question fa-fw"></i>Tentative</a></li>
        <li class="tab"><a href="#cancelled"><i class="fa fa-calendar-times-o fa-fw"></i>Cancelled</a></li>
    </ul>
    <div id="upcoming" class="panel-container">
        <table id="upcoming-list" class="tablesorter<?=(!empty($events['upcoming']) ? ' results' : '') ?>">
            <thead>
            <tr>
                <th class="arrows alpha"><i class="fa fa-fw"></i>Name</th>
                <th class="column-date arrows numeric"><i class="fa fa-fw"></i>Start</th>
                <th class="column-location arrows alpha"><i class="fa fa-fw"></i>Location</th>
                <th class="column-type arrows alpha"><i class="fa fa-fw"></i>Type</th>
                <th class="column-actions">Actions</th>
            </tr>
            </thead>
            <tbody>
<?  if (in_array_or_god(MEMBER_PERMISSION_ADD_EVENTS, $session['permission_ids'])): ?>
                <tr class="add_row">
                    <td><a href="/members/events/add" class="fullcell"><i class="fa fa-plus fa-fw"></i>Add new event...</a></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
<?  endif; ?>
<?  if (!empty($events['upcoming'])) : ?>
<?      foreach ($events['upcoming'] as $event): ?>
                <tr>
                    <td><a href="/members/events/info/<?=$event['id'] ?>" class="fullcell"><i class="fa fa-calendar fa-fw"></i><?=$event['name'] ?></a></td>
                    <td><?=$event['date_start']['datetime_us'] ?></td>
                    <td><?=(!empty($event['location']) ? $event['location'] : 'TBD') ?></td>
                    <td class="iconify <?=$event['css_class'] ?>"><i class="<?=$event['icon_family'] ?> <?=$event['icon'] ?> fa-fw"></i><?=$event['type_name'] ?></td>
                    <td>
<?          if (in_array_or_god(MEMBER_PERMISSION_EDIT_EVENTS, $session['permission_ids'])): ?>
                        <a class="admin-icon edit" href="/members/events/edit/<?=$event['id'] ?>" title="Edit Event"><i class="fa fa-fw fa-pencil"></i></a><!--
<?          else: ?>
                        <i class="fa fa-fw fa-pencil admin-icon disabled" title="Can't Edit Event"></i><!--
<?          endif; ?>
<?          if (in_array_or_god(MEMBER_PERMISSION_CANCEL_EVENTS, $session['permission_ids'])): ?>
                     --><a class="admin-icon cancel" href="javascript:void(0)" data-id="<?=$event['id'] ?>" data-name="<?=$event['name'] ?>" title="Cancel Event"><i class="fa fa-fw fa-remove"></i></a><form action="/members/events/cancel" method="post" class="hidden cancel-action" name="cancel_<?=$event['id'] ?>" id="cancel_<?=$event['id'] ?>" data-id="<?=$event['id'] ?>"></form><!--
<?          else: ?>
                     --><i class="fa fa-fw fa-remove admin-icon disabled" title="Can't Cancel Event"></i><!--
<?          endif; ?>
<?          if (in_array_or_god(MEMBER_PERMISSION_DELETE_EVENTS, $session['permission_ids'])): ?>
                     --><a class="admin-icon delete" href="javascript:void(0)" data-id="<?=$event['id'] ?>" data-name="<?=$event['name'] ?>" title="Delete Event (Can't Be Undone)"><i class="fa fa-fw fa-trash"></i></a><form action="/members/events/delete" method="post" class="hidden delete-action" name="delete_<?=$event['id'] ?>" id="delete_<?=$event['id'] ?>" data-id="<?=$event['id'] ?>"></form>
<?          else: ?>
                     --><i class="fa fa-fw fa-trash admin-icon disabled" title="Can't Delete Event"></i>
<?          endif; ?>
                    </td>
                </tr>
<?      endforeach; ?>
<?  endif; ?>
            </tbody>
        </table>
    </div>
    <div id="past" class="panel-container">
        <table id="past-list" class="tablesorter<?=(!empty($events['past']) ? ' results' : '') ?>">
            <thead>
            <tr>
                <th class="arrows alpha"><i class="fa fa-fw"></i>Name</th>
                <th class="column-date arrows numeric"><i class="fa fa-fw"></i>Start</th>
                <th class="column-location arrows alpha"><i class="fa fa-fw"></i>Location</th>
                <th class="column-type arrows alpha"><i class="fa fa-fw"></i>Type</th>
                <th class="column-actions">Actions</th>
            </tr>
            </thead>
            <tbody>
<?  if (!empty($events['past'])) : ?>
<?      foreach ($events['past'] as $event): ?>
                <tr>
                    <td><a href="/members/events/info/<?=$event['id'] ?>" class="fullcell"><i class="fa fa-calendar fa-fw"></i><?=$event['name'] ?></a></td>
                    <td><?=$event['date_start']['datetime_us'] ?></td>
                    <td><?=(!empty($event['location']) ? $event['location'] : 'TBD') ?></td>
                    <td class="iconify <?=$event['css_class'] ?>"><i class="<?=$event['icon_family'] ?> <?=$event['icon'] ?> fa-fw"></i><?=$event['type_name'] ?></td>
                    <td>
<?          if (is_god($session['permission_ids'])): ?>
                        <a class="admin-icon edit" href="/members/events/edit/<?=$event['id'] ?>" title="Edit Event"><i class="fa fa-fw fa-pencil"></i></a><!--
                     --><a class="admin-icon cancel" href="javascript:void(0)" data-id="<?=$event['id'] ?>" data-name="<?=$event['name'] ?>" title="Cancel Event"><i class="fa fa-fw fa-remove"></i></a><form action="/members/events/cancel" method="post" class="hidden cancel-action" name="cancel_<?=$event['id'] ?>" id="cancel_<?=$event['id'] ?>" data-id="<?=$event['id'] ?>"></form><!--
                     --><a class="admin-icon delete" href="javascript:void(0)" data-id="<?=$event['id'] ?>" data-name="<?=$event['name'] ?>" title="Delete Event (Can't Be Undone)"><i class="fa fa-fw fa-trash"></i></a><form action="/members/events/delete" method="post" class="hidden delete-action" name="delete_<?=$event['id'] ?>" id="delete_<?=$event['id'] ?>" data-id="<?=$event['id'] ?>"></form>
<?          else: ?>
                        <i class="fa fa-fw fa-pencil admin-icon disabled" title="Can't Edit Event"></i><!--
                     --><i class="fa fa-fw fa-remove admin-icon disabled" title="Can't Cancel Event"></i><!--
                     --><i class="fa fa-fw fa-trash admin-icon disabled" title="Can't Delete Event"></i>
<?          endif; ?>
                    </td>
                </tr>
<?      endforeach; ?>
<?  else: ?>
    <tr>
        <td colspan="6" class="no-results">No past events</td>
    </tr>
<?  endif; ?>
            </tbody>
        </table>
    </div>
    <div id="tentative" class="panel-container">
        <p>Tenative events will appear on the events calendar, but will be marked as "tentative."</p>
        <table id="tentative-list" class="tablesorter<?=(!empty($events['tentative']) ? ' results' : '') ?>">
            <thead>
            <tr>
                <th class="arrows alpha"><i class="fa fa-fw"></i>Name</th>
                <th class="column-date arrows numeric"><i class="fa fa-fw"></i>Start</th>
                <th class="column-location arrows alpha"><i class="fa fa-fw"></i>Location</th>
                <th class="column-type arrows alpha"><i class="fa fa-fw"></i>Type</th>
                <th class="column-actions">Actions</th>
            </tr>
            </thead>
            <tbody>
<?  if (!empty($events['tentative'])) : ?>
<?      foreach ($events['tentative'] as $event): ?>
                <tr>
                    <td><a href="/members/events/info/<?=$event['id'] ?>" class="fullcell"><i class="fa fa-calendar fa-fw"></i><?=$event['name'] ?></a></td>
                    <td><?=$event['date_start']['datetime_us'] ?></td>
                    <td><?=(!empty($event['location']) ? $event['location'] : 'TBD') ?></td>
                    <td class="iconify <?=$event['css_class'] ?>"><i class="<?=$event['icon_family'] ?> <?=$event['icon'] ?> fa-fw"></i><?=$event['type_name'] ?></td>
                    <td>
<?          if (in_array_or_god(MEMBER_PERMISSION_EDIT_EVENTS, $session['permission_ids'])): ?>
                        <a class="admin-icon edit" href="/members/events/edit/<?=$event['id'] ?>" title="Edit Event"><i class="fa fa-fw fa-pencil"></i></a><!--
<?          else: ?>
                        <i class="fa fa-fw fa-pencil admin-icon disabled" title="Can't Edit Event"></i><!--
<?          endif; ?>
<?          if (in_array_or_god(MEMBER_PERMISSION_CANCEL_EVENTS, $session['permission_ids'])): ?>
                     --><a class="admin-icon cancel" href="javascript:void(0)" data-id="<?=$event['id'] ?>" data-name="<?=$event['name'] ?>" title="Cancel Event"><i class="fa fa-fw fa-remove"></i></a><form action="/members/events/cancel" method="post" class="hidden cancel-action" name="cancel_<?=$event['id'] ?>" id="cancel_<?=$event['id'] ?>" data-id="<?=$event['id'] ?>"></form><!--
<?          else: ?>
                     --><i class="fa fa-fw fa-remove admin-icon disabled" title="Can't Cancel Event"></i><!--
<?          endif; ?>
<?          if (in_array_or_god(MEMBER_PERMISSION_DELETE_EVENTS, $session['permission_ids'])): ?>
                     --><a class="admin-icon delete" href="javascript:void(0)" data-id="<?=$event['id'] ?>" data-name="<?=$event['name'] ?>" title="Delete Event (Can't Be Undone)"><i class="fa fa-fw fa-trash"></i></a><form action="/members/events/delete" method="post" class="hidden delete-action" name="delete_<?=$event['id'] ?>" id="delete_<?=$event['id'] ?>" data-id="<?=$event['id'] ?>"></form>
<?          else: ?>
                     --><i class="fa fa-fw fa-trash admin-icon disabled" title="Can't Delete Event"></i>
<?          endif; ?>
                    </td>
                </tr>
<?      endforeach; ?>
<?  else: ?>
                <tr>
                    <td colspan="6" class="no-results">No tentative events</td>
                </tr>
<?  endif; ?>
            </tbody>
        </table>
    </div>
    <div id="cancelled" class="panel-container">
        <p>Cancelled events will not appear on the events calendar.</p>
        <table id="cancelled-list" class="tablesorter<?=(!empty($events['cancelled']) ? ' results' : '') ?>">
            <thead>
            <tr>
                <th class="arrows alpha"><i class="fa fa-fw"></i>Name</th>
                <th class="column-date arrows numeric"><i class="fa fa-fw"></i>Start</th>
                <th class="column-location arrows alpha"><i class="fa fa-fw"></i>Location</th>
                <th class="column-type arrows alpha"><i class="fa fa-fw"></i>Type</th>
                <th class="column-actions">Actions</th>
            </tr>
            </thead>
            <tbody>
<?  if (!empty($events['cancelled'])) : ?>
<?      foreach ($events['cancelled'] as $event): ?>
                <tr>
                    <td><a href="/members/events/info/<?=$event['id'] ?>" class="fullcell"><i class="fa fa-calendar fa-fw"></i><?=$event['name'] ?></a></td>
                    <td><?=$event['date_start']['datetime_us'] ?></td>
                    <td><?=(!empty($event['location']) ? $event['location'] : 'TBD') ?></td>
                    <td class="iconify <?=$event['css_class'] ?>"><i class="<?=$event['icon_family'] ?> <?=$event['icon'] ?> fa-fw"></i><?=$event['type_name'] ?></td>
                    <td>
<?          if (in_array_or_god(MEMBER_PERMISSION_EDIT_EVENTS, $session['permission_ids'])): ?>
                        <a class="admin-icon edit" href="/members/events/edit/<?=$event['id'] ?>" title="Edit Event"><i class="fa fa-fw fa-pencil"></i></a><!--
<?          else: ?>
                        <i class="fa fa-fw fa-pencil admin-icon disabled" title="Can't Edit Event"></i><!--
<?          endif; ?>
<?          if (in_array_or_god(MEMBER_PERMISSION_CANCEL_EVENTS, $session['permission_ids'])): ?>
                     --><a class="admin-icon refresh uncancel" href="javascript:void(0)" data-id="<?=$event['id'] ?>" data-name="<?=$event['name'] ?>" title="Uncancel Event"><i class="fa fa-fw fa-undo"></i></a><form action="/members/events/uncancel" method="post" class="hidden uncancel-action" name="uncancel_<?=$event['id'] ?>" id="uncancel_<?=$event['id'] ?>" data-id="<?=$event['id'] ?>"></form><!--
<?          else: ?>
                     --><i class="fa fa-fw fa-undo admin-icon disabled" title="Can't Uncancel Event"></i><!--
<?          endif; ?>
<?          if (in_array_or_god(MEMBER_PERMISSION_DELETE_EVENTS, $session['permission_ids'])): ?>
                     --><a class="admin-icon delete" href="javascript:void(0)" data-id="<?=$event['id'] ?>" data-name="<?=$event['name'] ?>" title="Delete Event (Can't Be Undone)"><i class="fa fa-fw fa-trash"></i></a><form action="/members/events/delete" method="post" class="hidden delete-action" name="delete_<?=$event['id'] ?>" id="delete_<?=$event['id'] ?>" data-id="<?=$event['id'] ?>"></form>
<?          else: ?>
                     --><i class="fa fa-fw fa-trash admin-icon disabled" title="Can't Delete Event"></i>
<?          endif; ?>
                    </td>
                </tr>
<?      endforeach; ?>
<?  else: ?>
                <tr>
                    <td colspan="6" class="no-results">No cancelled events</td>
                </tr>
<?  endif; ?>
            </tbody>
        </table>
    </div>
</div>
