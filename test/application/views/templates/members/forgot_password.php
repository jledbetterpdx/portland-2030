<section class="background hood">
    <form id="forgot_password_window" class="shadowed" action="/members/login/send_password_link" method="post">
<?  if (!empty($this->session->flashdata('message'))): ?>
        <div id="message" class="<?=$this->session->flashdata('class') ?>"><?=$this->session->flashdata('message') ?></div>
<?  endif; ?>
        <p>Enter your username below, and we will send a password reset link to your email.</p>
        <p><span class="icon" id="username_box"><input type="text" placeholder="USERNAME" id="username" name="username" class="textbox" /></span></p>
        <p><span class="icon icon-success" id="send_box"><input id="submit" class="button" type="submit" value="Send" /></span><span class="icon icon-alert" id="back_box"><input id="back" class="button" type="button" value="Back" /></span></p>
    </form>
</section>