<section class="debug">
    <h3>Debug Mode</h3>
    <div><b>SID:</b> <?=$session['session_id'] ?></div>
    <div><b>IP:</b> <?=$session['ip_address'] ?></div>
    <div><b>Act:</b> <?=date('F jS, Y g:i.s', $session['last_activity']) ?></div>
    <div><b>MID:</b> <?=$session['member_id'] ?></div>
    <div><b>FN:</b> <?=$session['first_name'] ?></div>
    <div><b>Stat:</b> <?=$session['status_id'] ?></div>
    <div><b>CIDs:</b> <?=json_encode($session['committee_ids']) ?></div>
    <div><b>OIDs:</b> <?=json_encode($session['officer_ids']) ?></div>
    <div><b>PIDs:</b> <?=json_encode($session['permission_ids']) ?></div>
</section>
