<?php
    /*
    Plugin Name: WP with Spritz
    Plugin URI: http://www.yokoco.com
    Description: Spritzing is reading text with Spritz Inc.’s patented technology. When you’re spritzing, you’re reading text one word at a time in our “redicle,” a special visual frame we designed for reading. Spritz for WordPress integrates the Spritz application and reads out or spritz posts and pages across WordPress.
    Author: Yoko Co. 
    Version: 1.0
    Author URI: http://www.yokoco.com
    License: GNU GPL2
	License URI: https://www.gnu.org/licenses/gpl-2.0.html
    */
    /*  
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    */
    /* DEFINES */
    define('SPRITZ__PLUGIN_URL', plugin_dir_url(__FILE__));
    define('SPRITZ__PLUGIN_DIR', plugin_dir_path(__FILE__));
    /* REQUIRED FILES */    
    require_once("lib/class.MojoLoader.php");
    require_once("lib/events.php");
    include_once('lib/class.wp.spritz.widget.php');
    /* ADD ACTIONS */
    add_action('admin_menu', 'boot_admin_spritz');
    add_action('widgets_init', 'spritz_widget');
    add_action('wp_enqueue_scripts','hook_script_spritz', 20);
    add_action('wp_enqueue_scripts','yokospritz_script', 21);
    /* ADD FILTERS */
    add_filter('the_content', 'generate_spritz');
    /* ADD SHORTCODE */
    add_shortcode( 'yoko-spritz', 'spritzcode_func' );
    /* REGISTER HOOK */
    register_activation_hook( __FILE__, 'spritz_activate' );
    function generate_spritz( $content ){
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $disable_spritz = unserialize(get_option("disable_spritz"));
        $disabled = false;
        $disable['home'] = "is_front_page";
        $disable['blog'] = "is_home";
        $disable['archives'] = "is_archive";
        $new_content = "<div class='yoko-spritz-container'>";
        if(is_array($disable_spritz)){
            foreach($disable_spritz as $dsection){
                $func_condition = call_user_func($disable[$dsection]);
                if( $func_condition ){
                    $disabled = true;
                }
                if($actual_link == home_url( '/' ) && $dsection == 'home'){
                    $disabled = true;
                }
            }
        }
        if(is_home() || is_archive() || is_category()){
            $disabled = true;
        }
        if($disabled){
            return $content;
        }else{
            $ctypes = unserialize(get_option("ctypes"));
            if(is_array($ctypes)){
                foreach($ctypes as $type){
                    if($type == get_post_type( get_the_ID() )){
                        $new_content .= SpritzStarter('','','','',true);
                    }
                }
            }
        }
        $new_content .= "</div>";
        $new_content .= do_shortcode($content);
        return $new_content;
    }
    function spritz_activate() {
        update_option("ctypes", '');
        update_option("region", ".entry,#entry,.content,#content,.post,#post,.page-content,#page-content,.entry-content,#entry-content");
        update_option("disable_spritz", 'a:3:{i:0;s:4:"home";i:1;s:4:"blog";i:2;s:8:"archives";}');
        update_option("spritz_start", "Press Play");
        update_option("spritz_end", "The End");
    }
    function boot_admin_spritz(){
        add_menu_page( 'WP With Spritz', 'WP With Spritz', 'manage_options', 'wp-with-spritz', 'spritz_init', SPRITZ__PLUGIN_URL . 'assets/img/favicon.ico');
	}
	 
	function spritz_init(){
        $ctypes = unserialize(get_option("ctypes"));
        $region = get_option("region");
        $region = str_replace(' ', '', $region);
        $disable_spritz = unserialize(get_option("disable_spritz"));
        $powered_by = get_option("powered_by");
        $spritz_start = get_option("spritz_start");
        $spritz_end = get_option("spritz_end");
        $spritz_client_id = get_option("spritz_client_id");
        /* DEFAULTS */
        if(!$region) $region = "header, #header, .header, #masthead, .site-header, .banner, img, footer, #footer, .footer, #colophon, #topnav, .menu, #menu, #nav, #navigation, .navigation, .main-navigation, #site-navigation, #site-navigation, .entry-meta, #comments, .comments, #secondary, .widget-area, .widget";
        if(!$spritz_start) $spritz_start = "Press Start";
        if(!$spritz_end) $spritz_end = "The End";
        $args = array(
           'public'   => true,
           '_builtin' => false
        );
        $post_types = get_post_types( $args );
		include("views/admin/admin.view.php");
	}
    function spritzcode_func( $atts ) {
        echo SpritzStarter('','','','',true);
    }
    function yokospritz_script( $template_path ) {
        wp_enqueue_style( 'spritz-css-light', plugin_dir_url( __FILE__ ).'assets/css/theme/spritz.light.css' );
        wp_enqueue_style( 'spritz-css', plugin_dir_url( __FILE__ ).'assets/css/spritz.wp.css' );

        wp_enqueue_script( 'spritz_cookies', SPRITZ__PLUGIN_URL .'assets/js/jquery.cookies.js', array( 'jquery' ), '1.0.0', false );

		wp_enqueue_script( 'spritz_apk', '//sdk.spritzinc.com/js/1.2/js/spritz.min.js', array( 'jquery' ), '1.0.0', false );
        wp_enqueue_script( 'spritz-header', plugin_dir_url( __FILE__ ).'assets/js/spritz.header.js', array( 'jquery' ), '1.0.0', true );
        
        wp_enqueue_script( 'spritz-front', plugin_dir_url( __FILE__ ).'assets/js/front.js', array( 'jquery' ), '1.0.0', true );
        wp_enqueue_script( 'spritz-helper', plugin_dir_url( __FILE__ ).'assets/js/WPSpritz.js', array(), '1.0.0', true );
        wp_enqueue_script( 'jquery-ui-core' );

    }
    function hook_script_spritz()
    {
        $ctypes = unserialize(get_option("ctypes"));
        $region = get_option("region");
        $region = str_replace(' ', '', $region);
        $disable_spritz = unserialize(get_option("disable_spritz"));
        $powered_by = get_option("powered_by");
        $spritz_start = get_option("spritz_start");
        $spritz_end = get_option("spritz_end");
        $spritz_client_id = get_option("spritz_client_id");

        include("lib/spritz.settings.js.php");
    }
    function spritz_widget() {
        register_widget('Spritz_Widget');
    }
    function SpritzStarter($target='',$selector='',$style='',$title='', $toggle=true){
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $disable_spritz = unserialize(get_option("disable_spritz"));
        $powered_by = get_option("powered_by");
        
        if(is_array($disable_spritz)){
            if($actual_link == home_url( '/' ) && $disable_spritz[0] == 'home'){
                return false;
            }
        }
        $spritz_client_id = get_option("spritz_client_id");
        if( empty($spritz_client_id) ){
            echo '<strong>For spritz for wordpress to work properly, please set the client ID.</strong>';
            return false;
        }
        global $count;
        global $post;
        global $spritz;
        ob_start();
        $id = rand(1000,10000);
        $classes        = 'spritztabwpopup';
        $_option        = '';
        $_style         = 'none';
        $_url           = ($target=='body' || $target=='all' || $target=='') ? 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] : $target;
        $classes    = 'spritzinlinereader';     /* Inline Reader */
        $_style     = "block";
        $_option    = ' data-selector="' . (($selector=='')?get_option('region'):$selector) . '" 
        data-url="' .SPRITZ__PLUGIN_URL.'wp.spritz.content.filter.php?url='.$_url . '&tages=.yoko-spritz-container"';
        $popupElement='<div id="spritz-container-' . $id . '" class="' . $classes . ' spritzer_popup light responsive ';
        if($toggle){
            $popupElement.="toggle-good";
        }
        $popupElement.='">
                <div class="spritzer_frame">';
                        $popupElement.='<div id="spritzer-' . $id . '" data-options=\'{"defaultSpeed":250}\' data-role="spritzer" ' . $_option . ' class="spritzer">
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="yoko-spritz-title"></div>
                <div class="clear"></div>
            </div>';
        if($toggle){
            $popupElement.='<div class="spritz-toggle"><a id="'.$id.'" class="toggle-anchor" href=""></a></div>';
        }
        
        $readerbuttonclasses = 'inlinereader bttnAlignCenter'; 
        $count++;
        echo $popupElement;
        ?>
        <script type="text/javascript">
            var j = jQuery.noConflict();
            var url;
            var selector;
            j(document).ready(function(){
                
                j.each(j(".spritzer"),function(){
                    
                    selector=(typeof(j(this).data('selector')) != 'undefined') ? j(this).data('selector'):'';
                    if(selector==''){
                        if("<?php echo get_option('region'); ?>" != ''){
                            selector='<?php echo get_option("region"); ?>';
                        }else{
                            selector='';
                        }
                    }else{
                        selector=selector;
                    }
                    url = (typeof(j(this).data('url')) != 'undefined') ? j(this).data('url'):'';
                    var urls="<?php echo SPRITZ__PLUGIN_URL.'wp.spritz.content.filter.php?url='; ?>"+url+"<?php echo "&selector=".get_option('region');?>&tages=.yoko-spritz-container";
                    j(this).data("controller").applyOptions(customOptions)
                    j(this).data("controller").loadText(false, {url:urls,selector:selector})
                })       
                if(j.cookie("toggle-state") == 1){
                    var maximize_btn = "<div class='max-spritz-btn'><div class='max-spritz-plus'>+</div><span>Speed Read with Spritz</span></div>";
                    j('.spritz-toggle a').html(maximize_btn);
                    j('.spritz-toggle').css("margin", "0px 0px 25px");
                }else{
                    j('.spritz-toggle a').html("- Minimize Spritz Reader");
                }
                <?php if($powered_by != "disable"){ ?>
                j('.yoko-spritz-title').html('Wordpress With Spritz Plugin by <a href="yokoco.com">Yoko Co.</a>');
                <?php } ?>
            })
        </script>
        <?php
        $page = ob_get_contents();
        ob_end_clean();
        return $page;
    }
	add_filter( 'plugin_action_links', 'wp_spritz_settings_plugin_link', 10, 2 );

	function wp_spritz_settings_plugin_link( $links, $file ) 
	{
		static $my_plugin;
		if (!$my_plugin) {
			$my_plugin = plugin_basename(__FILE__);
		}
		if ($file == $my_plugin) {
			$settings_link = '<a href="http://www.wpspritz.com/faqs/">Support</a>';
			array_unshift($links, $settings_link);
		}
		return $links;
	}
?>