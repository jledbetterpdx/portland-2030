<section class="background carpet">
    <form id="login_window" class="shadowed" action="/members/login/verify" method="post" name="login">
<?  if (!empty($this->session->flashdata('message'))): ?>
        <div id="message" class="<?=$this->session->flashdata('class') ?>"><?=$this->session->flashdata('message') ?></div>
<?  endif; ?>
        <div id="forgot_password"><a href="/members/login/forgot_password">Forgot Password?</a></div>
        <span class="icon" id="username_box"><input id="username" class="textbox" name="username" placeholder="USERNAME" type="text" value="" /></span><br />
        <span class="icon" id="password_box"><input id="password" class="textbox" name="password" placeholder="PASSWORD" type="password" value="" /></span><br />
        <span class="icon icon-success" id="submit_box"><input id="submit" class="button" type="submit" value="Log In" /></span><span class="icon icon-alert" id="cancel_box"><input id="cancel" class="button" type="button" value="Cancel" /></span>
    </form>
    <span id="title" class="fa-rotate-45"><span class="accent2">PDX</span><span class="accent1">20</span>30 Members Area v1.0</span>
</section>
