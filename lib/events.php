<?php
/*
	Variable Names:
	1. ctypes (array)
	2. region (string)
	3. disable_spritz (array)
	4. spritz_start (string)
	5. spritz_end (string)
	6. powered_by (string)
*/

/* Update */

if (isset($_POST["update_settings"])) :

	//MojoLoader::check_arr($_POST);
	
	if(!in_array("ctypes", $_POST)){
		update_option("ctypes", "");
	}

	if(!in_array("disable_spritz", $_POST)){
		update_option("disable_spritz", "");
	}

	if(!in_array("powered_by", $_POST)){
		update_option("powered_by", "");
	}	

	foreach($_POST as $postname=>$val){	
		if(is_array($val)){
			$serialized_arr = serialize($val);
			update_option($postname, sanitize_text_field($serialized_arr));
		}else{
			if($postname == "region"){
				$val = str_replace(' ', '', $val);
			}

			update_option($postname, sanitize_text_field($val));
		}
	}

	add_action( 'admin_notices', 'wpspritz_admin_notice' );

endif;

function wpspritz_admin_notice() {
    ?>
    <div class="updated">
        <p><?php _e( 'Settings has successfully been updated.', 'yoko-spritz-notification' ); ?></p>
    </div>
    <?php
}

/* END - Update */