<h1><i class="fa fa-calendar"></i><i class="fa fa-<?=$page['icon'] ?> fa-fw"></i><?=$page['title'] ?></h1>
<?  if (isset($success) && $success == true): ?>
    <div class="success"><i class="fa fa-check-circle"></i>You have successfully <?=$action ?>ed the rotator image.</div>
<?  else: ?>
    <?=validation_errors(); ?>
<?  endif; ?>
<form action="/members/rotator/upload" method="POST" enctype="multipart/form-data" name="upload_image" id="upload_image">
    <fieldset class="form">
        <legend><label for="image_upload">Upload Image</label></legend>
        <input type="file" id="image_upload" name="image_upload" />
        <button type="aubmit" id="image_upload_button">Upload</button>
    </fieldset>
    <fieldset>
        <legend>Or Select a Previously Uploaded Image</legend>
        <div id="image_previous">
<?  if (empty($prev_images)): ?>
            <div id="image_previous_none">(dust)</div>
<?  else: ?>
<?      foreach ($prev_images as $image_data): ?>
            <div id="image_previous_icon_<?=$image_data['id'] ?>" class="image_previous_icon" data-image-id="<?=$image_data['id'] ?>"></div>
<?      endforeach; ?>
            <div class="clearfix"></div>
<?  endif; ?>
        </div>
    </fieldset>
</form>
<form action="/members/rotator/<?=$action ?>" method="POST" name="<?=$action ?>_image" id="<?=$action ?>_image">
    <input type="hidden" name="image_id" id="image_id" value="" />
</form>