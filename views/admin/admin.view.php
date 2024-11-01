<div class="wrap">
<h2>WP With Spritz by Yoko Co. Options</h2>
<form name="yoko_spritz_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<table class="form-table">
<tbody>
<tr>
<th scope="row">
	<label for="region">Spritz Client ID</label>
</th>
<td>
	<input name="spritz_client_id" type="text" id="spritz_client_id" value="<?=$spritz_client_id?>" class="regular-text" placeholder="ex. aaa111bbb222ccc33"><br>
	<i>You can get the Spritz Client ID from <a href="http://www.spritzinc.com/developers/" target="_blank">here</a> or email licensing@spritzinc.com.</i>
</td>
</tr>
<tr>
<th scope="row">Activate Spritz Reader on the following content types</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Content Types</span></legend>
	<?php if(empty($ctypes)): ?>
		<?php echo $ctypes; ?>
		<label title="post"><input type="checkbox" name="ctypes[]" value="post"> <span>post</span></label><br>
		<label title="page"><input type="checkbox" name="ctypes[]" value="page"> <span>page</span></label><br>
		<?php foreach ( $post_types as $post_type ) { ?>
			<label title="<?=$post_type?>"><input type="checkbox" name="ctypes[]" value="<?=$post_type?>"> <span><?=$post_type?></span></label><br>
		<?php } ?>
	
	<?php else: ?>
		<label title="post"><input type="checkbox" name="ctypes[]" value="post" <?php if(in_array("post", $ctypes)){ ?>checked="checked" <?php } ?>> <span>post</span></label><br>
		<label title="page"><input type="checkbox" name="ctypes[]" value="page" <?php if(in_array("page", $ctypes)){ ?>checked="checked" <?php } ?>> <span>page</span></label><br>
		<?php foreach ( $post_types as $post_type ) { ?>
			<label title="<?=$post_type?>"><input type="checkbox" name="ctypes[]" value="<?=$post_type?>" <?php if(in_array($post_type, $ctypes)){ ?>checked="checked" <?php } ?>> <span><?=$post_type?></span></label><br>
		<?php } ?>
	<?php endif; ?>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row">
	<label for="region">Content Region Include</label>
</th>
<td>
	<textarea id="yoko-spritz-region" name="region" class="large-text code" cols="50" rows="10"><?=$region?></textarea><br>
	<input type="submit" id="region-restore-default" class="button" value="Restore Default" onclick="return restore_default('region')">
</td>
</tr>
<tr>
<th scope="row">Disable Spritz On</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Disable Spritz On</span></legend>
	<?php if(empty($disable_spritz)){ ?>
		<label title="home"><input type="checkbox" name="disable_spritz[]" value="home" > <span>Home Page</span></label><br>
	<?php }else{ ?>
		<label title="home"><input type="checkbox" name="disable_spritz[]" value="home" <?php if(in_array("home", $disable_spritz)){ ?>checked="checked" <?php } ?>> <span>Home Page</span></label><br>
	<?php } ?>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row"><label for="spritz_start">Spritz Start Text</label></th>
<td><input name="spritz_start" type="text" id="spritz_start" value="<?=$spritz_start?>" class="regular-text"></td>
</tr>
<tr>
<th scope="row"><label for="spritz_end">Spritz End Text</label></th>
<td><input name="spritz_end" type="text" id="spritz_end" value="<?=$spritz_end?>" class="regular-text"></td>
</tr>
<tr>
<th scope="row"><label for="powered_by">I don't like you! Disable "Powered By"</label></th>
<td>
<input type="checkbox" name="powered_by" value="disable" <?php if($powered_by == "disable" && !empty($powered_by)){ ?> checked="checked" <?php } ?>> <span>Hide it!</span>
</td>
</tr>
</tbody></table>
<p class="submit">
	<input type="hidden" name="update_settings" value="1" />
	<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
</p>
</form>
</div>
<script type="text/javascript">
function restore_default(field){
	var region = '.entry,#entry,.content,#content,.post,#post,.page-content,#page-content,.entry-content,#entry-content';
	
	if(field == "region"){
		jQuery("#yoko-spritz-region").val(region);
	}
	return false;
}
</script>