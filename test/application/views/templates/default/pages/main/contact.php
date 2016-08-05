<h1>Contact Us</h1>
<p>Interested in learning more about the Active 20-30 Club of Portland? Do you have a suggestion for a volunteer project? Please let us know!</p>
<!-- @todo change contact_field divs to fieldsets and legends, give the field value has a negative top margin. it's brilliant -->
<form action="/contact" method="post" id="contact_form" class="contacts">
    <h2>Send Us a Message</h2>
<?  if (isset($success) && $success == true): ?>
    <div class="success"><i class="fa fa-check-circle"></i>Your message was successfully delivered! We will contact you shortly.</div>
<?  endif; ?>
    <p><span class="required">*</span> indicates a required field</p>
    <div class="contact_field">
        <label for="contact_field_first_name" id="contact_label_name">Name<span class="required">*</span></label>
        <?=form_error('first_name'); ?>
        <?=form_error('last_name'); ?>
        <div class="contact_field_value">
            <input name="first_name" id="contact_field_first_name" placeholder="First" type="text" class="medium" value="<?=(!isset($success) ? set_value('first_name') : '') ?>" />
            <input name="last_name" id="contact_field_last_name" placeholder="Last" type="text" class="medium" value="<?=(!isset($success) ? set_value('last_name') : '') ?>" />
        </div>
    </div>
    <div class="contact_field">
        <label for="contact_field_address1" id="contact_label_address">Address<span class="required">*</span></label>
        <?=form_error('address1'); ?>
        <?=form_error('city'); ?>
        <?=form_error('state'); ?>
        <?=form_error('zip'); ?>
        <div class="contact_field_value">
            <input name="address1" id="contact_field_address1" placeholder="Street Address" type="text" class="long" value="<?=(!isset($success) ? set_value('address1') : '') ?>" /><br />
            <input name="address2" id="contact_field_address2" placeholder="Apartment/Suite" type="text" class="long" value="<?=(!isset($success) ? set_value('address2') : '') ?>" /><br />
            <input name="city" id="contact_field_city" placeholder="City" type="text" class="medium" value="<?=(!isset($success) ? set_value('city') : '') ?>" />
            <select name="state" id="contact_field_state">
                <option<?=(!isset($success) ? set_select('state', 'OR') : '') ?> value="OR">OR</option>
                <option<?=(!isset($success) ? set_select('state', 'WA') : '') ?> value="WA">WA</option>
                <option value="">&ndash;&ndash;</option>
                <option<?=(!isset($success) ? set_select('state', 'AL') : '') ?> value="AL">AL</option>
                <option<?=(!isset($success) ? set_select('state', 'AK') : '') ?> value="AK">AK</option>
                <option<?=(!isset($success) ? set_select('state', 'AZ') : '') ?> value="AZ">AZ</option>
                <option<?=(!isset($success) ? set_select('state', 'AR') : '') ?> value="AR">AR</option>
                <option<?=(!isset($success) ? set_select('state', 'CA') : '') ?> value="CA">CA</option>
                <option<?=(!isset($success) ? set_select('state', 'CO') : '') ?> value="CO">CO</option>
                <option<?=(!isset($success) ? set_select('state', 'CT') : '') ?> value="CT">CT</option>
                <option<?=(!isset($success) ? set_select('state', 'DE') : '') ?> value="DE">DE</option>
                <option<?=(!isset($success) ? set_select('state', 'DC') : '') ?> value="DC">DC</option>
                <option<?=(!isset($success) ? set_select('state', 'FL') : '') ?> value="FL">FL</option>
                <option<?=(!isset($success) ? set_select('state', 'GA') : '') ?> value="GA">GA</option>
                <option<?=(!isset($success) ? set_select('state', 'HI') : '') ?> value="HI">HI</option>
                <option<?=(!isset($success) ? set_select('state', 'ID') : '') ?> value="ID">ID</option>
                <option<?=(!isset($success) ? set_select('state', 'IL') : '') ?> value="IL">IL</option>
                <option<?=(!isset($success) ? set_select('state', 'IN') : '') ?> value="IN">IN</option>
                <option<?=(!isset($success) ? set_select('state', 'IA') : '') ?> value="IA">IA</option>
                <option<?=(!isset($success) ? set_select('state', 'KS') : '') ?> value="KS">KS</option>
                <option<?=(!isset($success) ? set_select('state', 'KY') : '') ?> value="KY">KY</option>
                <option<?=(!isset($success) ? set_select('state', 'LA') : '') ?> value="LA">LA</option>
                <option<?=(!isset($success) ? set_select('state', 'ME') : '') ?> value="ME">ME</option>
                <option<?=(!isset($success) ? set_select('state', 'MD') : '') ?> value="MD">MD</option>
                <option<?=(!isset($success) ? set_select('state', 'MA') : '') ?> value="MA">MA</option>
                <option<?=(!isset($success) ? set_select('state', 'MI') : '') ?> value="MI">MI</option>
                <option<?=(!isset($success) ? set_select('state', 'MN') : '') ?> value="MN">MN</option>
                <option<?=(!isset($success) ? set_select('state', 'MS') : '') ?> value="MS">MS</option>
                <option<?=(!isset($success) ? set_select('state', 'MO') : '') ?> value="MO">MO</option>
                <option<?=(!isset($success) ? set_select('state', 'MT') : '') ?> value="MT">MT</option>
                <option<?=(!isset($success) ? set_select('state', 'NE') : '') ?> value="NE">NE</option>
                <option<?=(!isset($success) ? set_select('state', 'NV') : '') ?> value="NV">NV</option>
                <option<?=(!isset($success) ? set_select('state', 'NH') : '') ?> value="NH">NH</option>
                <option<?=(!isset($success) ? set_select('state', 'NJ') : '') ?> value="NJ">NJ</option>
                <option<?=(!isset($success) ? set_select('state', 'NM') : '') ?> value="NM">NM</option>
                <option<?=(!isset($success) ? set_select('state', 'NY') : '') ?> value="NY">NY</option>
                <option<?=(!isset($success) ? set_select('state', 'NC') : '') ?> value="NC">NC</option>
                <option<?=(!isset($success) ? set_select('state', 'ND') : '') ?> value="ND">ND</option>
                <option<?=(!isset($success) ? set_select('state', 'OH') : '') ?> value="OH">OH</option>
                <option<?=(!isset($success) ? set_select('state', 'OK') : '') ?> value="OK">OK</option>
                <option<?=(!isset($success) ? set_select('state', 'PA') : '') ?> value="PA">PA</option>
                <option<?=(!isset($success) ? set_select('state', 'PR') : '') ?> value="PR">PR</option>
                <option<?=(!isset($success) ? set_select('state', 'RI') : '') ?> value="RI">RI</option>
                <option<?=(!isset($success) ? set_select('state', 'SC') : '') ?> value="SC">SC</option>
                <option<?=(!isset($success) ? set_select('state', 'SD') : '') ?> value="SD">SD</option>
                <option<?=(!isset($success) ? set_select('state', 'TN') : '') ?> value="TN">TN</option>
                <option<?=(!isset($success) ? set_select('state', 'TX') : '') ?> value="TX">TX</option>
                <option<?=(!isset($success) ? set_select('state', 'UT') : '') ?> value="UT">UT</option>
                <option<?=(!isset($success) ? set_select('state', 'VT') : '') ?> value="VT">VT</option>
                <option<?=(!isset($success) ? set_select('state', 'VA') : '') ?> value="VA">VA</option>
                <option<?=(!isset($success) ? set_select('state', 'WV') : '') ?> value="WV">WV</option>
                <option<?=(!isset($success) ? set_select('state', 'WI') : '') ?> value="WI">WI</option>
                <option<?=(!isset($success) ? set_select('state', 'WY') : '') ?> value="WY">WY</option>
            </select>
            <input name="zip" id="contact_field_zip" maxlength="5" placeholder="Zip" type="text" class="short" value="<?=(!isset($success) ? set_value('zip') : '') ?>" />
        </div>
    </div>
    <div class="contact_field">
        <label for="contact_field_phone" id="contact_label_phone">Phone</label>
        <div class="contact_field_value">
            <input name="cell_phone" id="contact_field_phone" type="tel" placeholder="Primary Phone #" class="medium" value="<?=(!isset($success) ? set_value('cell_phone') : '') ?>" />
            <input name="alt_phone" id="contact_field_altphone" type="tel" placeholder="Other Phone #" class="medium" value="<?=(!isset($success) ? set_value('alt_phone') : '') ?>" />
        </div>
    </div>
    <div class="contact_field">
        <label for="contact_field_liame" id="contact_label_liame">Email<span class="required">*</span></label>
        <?=form_error('liame'); ?>
        <div class="contact_field_value"><input name="liame" id="contact_field_liame" type="text" class="medium" value="<?=(!isset($success) ? set_value('liame') : '') ?>" /></div>
    </div>
    <div class="contact_field hidden" contenteditable="false">
        <label for="contact_field_email" id="contact_label_email">Email</label>
        <div class="contact_field_value"><input name="email" tabindex="-1" id="contact_field_email" type="email" class="medium" value="<?=(!isset($success) ? set_value('email') : '') ?>" /></div>
    </div>
    <div class="contact_field">
        <label for="contact_field_howhear" id="contact_label_howhear">How Did You Hear About Us?<span class="required">*</span></label>
        <?=form_error('how_hear'); ?>
        <div class="contact_field_value"><input name="how_hear" id="contact_field_howhear" placeholder="e.g. Facebook, Instagram, a Friend" type="text" class="long" value="<?=(!isset($success) ? set_value('how_hear') : '') ?>" /></div>
    </div>
    <div class="contact_field">
        <label for="contact_field_comments" id="contact_label_comments">Additional Comments</label>
        <div class="contact_field_value"><textarea name="comments" id="contact_field_comments" class="big"><?=(!isset($success) ? set_value('comments') : '') ?></textarea></div>
    </div>
    <div class="contact_field">
        <div class="contact_field_value">
            <input id="contact_field_submit" type="submit" value="Submit" />
            <input id="contact_field_reset" type="reset" value="Reset" />
        </div>
    </div>
</form>
<div class="contacts" id="contact_names">
    <h2>Contact Our Leadership</h2>
    <address>
        <b>President John Fox</b><br />
        president@portland2030.org<br />
        <a href="tel:+15035309934">503-530-9934</a>
    </address>
</div>
<div class="clearfix"></div>