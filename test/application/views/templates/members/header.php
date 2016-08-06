<!DOCTYPE html>
<html>
    <head>
        <title>20-30 PDX Members Area<?=(isset($page) && array_key_exists('title', $page) ? ' - ' . $page['title'] : '') ?></title>
        <link rel="stylesheet" href="/assets/css/reset.css" />
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700" />
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Lato:400italic,700italic,400,700,900" />
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.css" />
        <link rel="stylesheet" href="/assets/fonts/bebas-neue.css" />
        <link rel="stylesheet" href="/assets/templates/members/css/stylesheet.css" />
<?  if (!empty($page['css']) && is_array($page['css'])): ?>
<?      foreach ($page['css'] as $src): ?>
        <link rel="stylesheet" href="<?=$src ?>" />
<?      endforeach; ?>
<?  endif; ?>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<?  if (!empty($page['js']) && is_array($page['js'])): ?>
    <?      foreach ($page['js'] as $src): ?>
        <script src="<?=$src ?>"></script>
    <?      endforeach; ?>
<?  endif; ?>
    </head>
    <body>
<?  if (empty($page['hide_menu']) || $page['hide_menu'] !== true): ?>
        <header>
            <nav>
                <ul class="fa-ul">
                    <li><a href="/members"><i class="fa-li fa fa-home"></i>Home</a></li>
                    <li><i class="fa-li fa fa-list"></i>Event List</li>
                    <ul class="fa-ul">
                        <li class="add"><a href="/members/events#upcoming"><i class="fa-li fa fa-forward"></i>Upcoming</a></li>
                        <li class="refresh"><a href="/members/events#past"><i class="fa-li fa fa-backward"></i>Past</a></li>
                        <li class="edit"><a href="/members/events#tentative"><i class="fa-li fa fa-question"></i>Tentative</a></li>
                        <li class="remove"><a href="/members/events#cancelled"><i class="fa-li fa fa-calendar-times-o"></i>Cancelled</a></li>
                    </ul>
                    <li><i class="fa-li fa fa-users"></i>Members</li>
                    <ul class="fa-ul">
                        <li><a href="/members/roster"><i class="fa-li fa fa-list"></i>Member Roster</a></li>
<?      if (in_array_or_god(MEMBER_PERMISSION_ADD_MEMBERS, $session['permission_ids'])): ?>
                        <li class="add"><a href="/members/roster/add"><i class="fa-li fa fa-plus"></i>Add Member</a></li>
<?      endif; ?>
<?      if (in_array_or_god(MEMBER_PERMISSION_EDIT_MEMBERS, $session['permission_ids'])): ?>
                        <li class="edit"><a href="/members/roster/edit"><i class="fa-li fa fa-pencil"></i>Edit Member</a></li>
<?      endif; ?>
<?      if (in_array_or_god(MEMBER_PERMISSION_REMOVE_MEMBERS, $session['permission_ids'])): ?>
                        <li class="remove"><a href="/members/roster/remove"><i class="fa-li fa fa-remove"></i>Remove Member</a></li>
<?      endif; ?>
<?      if (in_array_or_god(MEMBER_PERMISSION_RESET_PASSWORDS, $session['permission_ids'])): ?>
                        <li class="refresh"><a href="/members/password/reset"><i class="fa-li fa fa-refresh"></i>Reset Password</a></li>
<?      endif; ?>
<?      if (in_array_or_god(MEMBER_PERMISSION_CHANGE_MEMBER_ACCESS, $session['permission_ids'])): ?>
                        <li class="access"><a href="/members/access/change"><i class="fa-li fa fa-key"></i>Change Access</a></li>
<?      endif; ?>
<?      if (in_array_or_god(MEMBER_PERMISSION_CHANGE_MEMBER_ROLE, $session['permission_ids'])): ?>
                        <li><a href="/members/role/change"><i class="fa-li fa fa-user"></i>Change Role</a></li>
<?      endif; ?>
                    </ul>
<?      if (any_in_array_or_god($permissions['inquiries'], $session['permission_ids'])): ?>
                    <li><i class="fa-li fa fa-envelope"></i>Inquiries</li>
                    <ul class="fa-ul">
<?          if (in_array_or_god(MEMBER_PERMISSION_VIEW_INQUIRIES, $session['permission_ids'])): ?>
                        <li class="refresh"><a href="/members/inquiries/view"><i class="fa-li fa fa-search"></i>View Inquiries</a></li>
<?          endif; ?>
<?          if (in_array_or_god(MEMBER_PERMISSION_RESPOND_INQUIRIES, $session['permission_ids'])): ?>
                        <li class="add"><a href="/members/inquiries/respond"><i class="fa-li fa fa-paper-plane"></i>Respond Inquiries</a></li>
<?          endif; ?>
                    </ul>
<?      endif; ?>
                    <li><i class="fa-li fa fa-pencil-square"></i>FlockBlog</li>
                    <ul class="fa-ul">
                        <li><a href="/members/blog/manage"><i class="fa-li fa fa-rss"></i>View Blog</a></li>
<?      if (in_array_or_god(MEMBER_PERMISSION_WRITE_BLOG_POSTS, $session['permission_ids'])): ?>
                        <li><a href="/members/blog/manage"><i class="fa-li fa fa-list-alt"></i>Manage Blog Posts</a></li>
                        <li class="add"><a href="/members/blog/write"><i class="fa-li fa fa-plus"></i>Write New Post</a></li>
<?      endif; ?>
                    </ul>
<?      if (any_in_array_or_god(array_merge($permissions['rotator_images'], $permissions['sponsors'], $permissions['maintenance']), $session['permission_ids'])): ?>
                    <li><i class="fa-li fa fa-cog"></i>Administration</li>
                    <ul class="fa-ul">
<?          if (any_in_array_or_god($permissions['rotator_images'], $session['permission_ids'])): ?>
                        <li class="edit"><a href="/members/manage/rotator"><i class="fa-li fa fa-photo"></i>Manage Image Rotator</a></li>
<?          endif; ?>
<?          if (any_in_array_or_god($permissions['sponsors'], $session['permission_ids'])): ?>
                        <li class="add"><a href="/members/manage/sponsors"><i class="fa-li fa fa-money"></i>Manage Sponsors</a></li>
<?          endif; ?>
<?          if (in_array_or_god(MEMBER_PERMISSION_VIEW_LOG, $session['permission_ids'])): ?>
                        <li class="add"><a href="/members/log"><i class="fa-li fa fa-list-alt"></i>View Log</a></li>
<?          endif; ?>
                    </ul>
<?      endif; ?>
                    <li><a href="/members/logout"><i class="fa-li fa fa-sign-out"></i>Logout</a></li>
                </ul>
            </nav>
        </header>
<?  endif; ?>
        <main<?=(!empty($page['hide_menu']) && $page['hide_menu'] === true ? ' class="fullwide"' : '') ?>>
