<section class="background cherry-blossom">
    <form id="reset_password_window" class="shadowed" action="/members/login/verify_password_reset" method="post">
        <?  if (!empty($this->session->flashdata('message'))): ?>
            <div id="message" class="<?=$this->session->flashdata('class') ?>"><?=$this->session->flashdata('message') ?></div>
        <?  endif; ?>
        <p>Verify your username and enter your new password below.</p>
        <p class="condensed"><span class="icon" id="username_box"><input type="text" placeholder="USERNAME" id="username" name="username" class="textbox" /></span></p>
        <p class="condensed overlap-below"><span class="icon" id="password_box"><input type="password" placeholder="NEW PASSWORD" id="password" name="password" class="textbox" /></span></p>
        <p class="condensed overlapped-above"><span class="icon" id="password_confirm_box"><input type="password" placeholder="CONFIRM PASSWORD" id="password_confirm" name="password_confirm" class="textbox" /></span></p>
        <p><span class="icon icon-success" id="resetpass_box"><input id="resetpass" class="button" type="submit" value="Reset" /></span><span class="icon icon-alert" id="back_box"><input id="back" class="button" type="button" value="Back" /></span></p>
        <input type="hidden" name="reset_code" value="<?=$code ?>" />
    </form>
</section>
