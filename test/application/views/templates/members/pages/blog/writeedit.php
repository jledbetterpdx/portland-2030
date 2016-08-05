<h1><i class="fa fa-pencil-square"></i><i class="fa fa-<?=$page['icon'] ?> fa-fw"></i><?=$page['title'] ?></h1>
<?  if (isset($success) && $success == true): ?>
    <div class="success"><i class="fa fa-check-circle"></i>You have successfully <?=($action == 'write' ? 'written' : 'edited') ?> the blog post.</div>
<?  else: ?>
    <?=validation_errors(); ?>
<?  endif; ?>
<form action="/members/blog/<?=$action . (!empty($post) ? '/' . $post['id'] : '') ?>" method="POST" name="writeedit_post" id="writeedit_post">
    <!-- Title section -->
    <section id="post_section_title">
        <input type="text" name="title" id="title"<?=($success === false || !empty($post) ? '' : ' data-set-permalink="true"') ?> placeholder="Title" value="<?=($success === false ? set_value('title') : (!empty($post) ? $post['title'] : '')) ?>" />
    </section>
    <!-- Permalink section -->
    <section id="post_section_permalink"<?=($success === false || !empty($post) ? '' : ' class="hidden"') ?>>
        <span id="post_permalink_legend"><i class="fa fa-link fa-fw"></i>Permalink:</span>
        <span id="post_permalink_blogurl"><?=WWW . SEP ?>blog/post/</span><!--
         --><span id="post_permalink_slug" title="Double-click to edit"><?=($success === false ? set_value('slug') : (!empty($post) ? $post['slug'] : '')) ?></span><!--
         --><span id="post_permalink_slug_input" class="hidden">
                <input type="text" name="slug" id="slug" value="<?=($success === false ? set_value('slug') : (!empty($post) ? $post['slug'] : '')) ?>" />
                <button type="button" id="slug_update">Update</button>
                <span id="slug_cancel">Cancel</span>
            </span>
    </section>
    <!-- Information section -->
    <section id="post_section_info">
        <fieldset id="post_info">
            <!-- Cover image information -- Cover image + image upload-->
            <div id="post_info_image">
                <div id="post_image_label_upload">
                    <p id="image_container">
                        <i class="fa fa-image fa-fw"></i><span class="info_label">Cover Image</span>
                        <input type="hidden" name="image_id" id="image_id" value="<?=($success === false ? set_value('image_id') : (!empty($post) ? $post['image']['id'] : '')) ?>" />
                    </p>
                    <p>
                        <button type="button" id="image_upload_button">Upload</button> or Select&rarr;
                        <input type="file" class="hidden" name="image_upload[]" id="image_upload" />
                    </p>
                </div>
                <div id="post_image_icons"></div>
            </div>
            <!-- Category information -- Category + add category -->
            <div id="post_info_category">
                <p id="category_container">
                    <i class="fa fa-sitemap fa-fw fa-rotate-270"></i><label class="info_label" for="category_id">Category</label>
                    <select name="category_id" id="category_id">
                        <option value="0"<?=($success === false ? set_select('category_id', 0) : (!empty($post) && $post['category_id'] == 0 ? ' selected="selected"' : '')) ?>>(Uncategorized)</option>
                        <option value="1">Sample Option 1</option>
                        <option value="2">Sample Option 2</option>
                        <option value="3">Sample Option 3</option>
                        <option value="4">Sample Option 4</option>
                        <option value="5">Sample Option 5</option>
<?  foreach ($categories as $category): ?>
                        <option value="<?=$category['id'] ?>"<?=($success === false ? set_select('category_id', $category['id']) : (!empty($post) && $post['category_id'] == $category['id'] ? ' selected="selected"' : '')) ?>><?=$category['name'] ?></option>
<?  endforeach; ?>
                    </select>
                </p>
                <p>

                </p>
            </div>
            <div id="post_info_revisions">
                <p id="revisions_container">
                    <i class="fa fa-history fa-fw"></i><span class="info_label">Revisions</span> <span id="revision_count">X</span> (<a href="#">Review</a>)
                </p>
                <p id="revision_autosave"><i class="fa fa-save fa-fw"></i> Autosaved <span id="revision_autosave_datetime">Dec 12 '16 12:34pm</span></p>
        </fieldset>
    </section>
    <section id="post_section_metadata">
<?  if (!empty($post)): ?>
        <aside id="metadata_datetime">
            <i class="fa fa-calendar fa-fw" title="Date"></i><span id="metadata_date"><?=date("M j 'y", strtotime($post['date_posted'])) ?></span>
            <i class="fa fa-clock-o fa-fw" title="Time"></i><span id="metadata_time"><?=date("g:ia", strtotime($post['date_posted'])) ?></span>
            <span id="metadata_datetime_edit" class="metadata edit">(edit)</span>
        </aside>
        <aside id="metadata_author">
            <i class="fa fa-user fa-fw" title="Author"></i><span id="posted_by"><?=$post['poster_name'] ?></span>
        </aside>
<?  endif; ?>
        <aside id="metadata_status" title="Status">
            <i class="fa fa-flag-checkered fa-fw"></i><!--
         --><select name="status" id="status">
<?  foreach ($statuses as $status): ?>
                <option value="<?=$status['id'] ?>"<?=($success === false ? set_select('status', $status['id']) : (!empty($post) && $post['status'] == $status['id'] ? ' selected="selected"' : '')) ?>><?=$status['name'] ?></option>
<?  endforeach; ?>
            </select>
        </aside>
        <aside id="metadata_visibility" title="Visibility">
            <i class="fa fa-eye fa-fw"></i><!--
         --><select name="visibility" id="visibility">
<?  foreach ($visibilities as $visibility): ?>
                <option value="<?=$visibility['id'] ?>"<?=($success === false ? set_select('visibility', $visibility['id']) : (!empty($post) && $post['visibility'] == $visibility['id'] ? ' selected="selected"' : '')) ?>><?=$visibility['name'] ?></option>
<?  endforeach; ?>
            </select>
        </aside>
        <aside id="metadata_category" title="Category">
            <i class="fa fa-sitemap fa-fw fa-rotate-270"></i>
            <div id="metadata_category_select">
                <select name="category_id" id="category_id">
                    <option value="0"<?=($success === false ? set_select('category_id', 0) : (!empty($post) && $post['category_id'] == 0 ? ' selected="selected"' : '')) ?>>(Uncategorized)</option>
                    <option value="1">Sample Option 1</option>
                    <option value="2">Sample Option 2</option>
                    <option value="3">Sample Option 3</option>
                    <option value="4">Sample Option 4</option>
                    <option value="5">Sample Option 5</option>
<?  foreach ($categories as $category): ?>
                    <option value="<?=$category['id'] ?>"<?=($success === false ? set_select('category_id', $category['id']) : (!empty($post) && $post['category_id'] == $category['id'] ? ' selected="selected"' : '')) ?>><?=$category['name'] ?></option>
<?  endforeach; ?>
                </select>
                <span id="metadata_category_add" class="metadata edit">(add)</span>
            </div>
            <div id="metadata_category_add" class="hidden">
            </div>
        </aside>
    </section>
    <section id="post_section_text">
        <textarea id="post" name="post"><?=($success === false ? set_value('post') : (!empty($post) ? $post['post'] : '')) ?></textarea>
    </section>
    <section id="post_section_buttons">
        <button type="submit">Post</button>
        <button type="submit">Save Draft</button>
        <button type="button">Cancel</button>
    </section>
</form>
