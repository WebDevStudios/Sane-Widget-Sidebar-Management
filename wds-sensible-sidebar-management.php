<?php
/*
Plugin Name: NBC Widget Sidebar Management
Plugin URI: http://webdevstudios.com/
Description: Select one sidebar for management at a time to maintain widget sanity.
Author: WebDevStudios.com
Version: 1.0.0
Author URI: http://webdevstudios.com/
*/

class NBC_Widget_Sidebar_Manage {

	public function __construct() {
		add_action( 'admin_init', array( $this, 'init_hooks' )  );
		add_action( 'admin_enqueue_scripts', array( $this, 'js' )  );
	}

	public function init_hooks() {
		add_action( 'widgets_admin_page', array( $this, 'sidebar_select' )  );
	}

	public function js() {
		wp_register_script( 'nbc-widget-manage-scripts', plugins_url( '/nbc-widget-manage.js', __FILE__ ), array( 'jquery', 'admin-widgets' ), '1.0.0' );
	}

	public function sidebar_select() {
		global $wp_registered_sidebars;
		wp_enqueue_script( 'nbc-widget-manage-scripts' );

		?>
		<style type="text/css">
		#widgets-right {
			position: relative;
		}
		#widgets-right > div.managed {
			position: absolute;
			top: 0;
			right: 0;
			width: 285px;
		}
		#widget-sidebar-manage {
			float: right;
			vertical-align: top;
			width:  285px;
			margin-right: 8px;
		}
		#widget-sidebar-manage-label {
			float: right;
			vertical-align: top;
			display: block;
			margin: 2px 33px 0 0;
		}
		</style>
		<div id="widget-sidebar-manage-wrap" style="display: none;">
			<select id="widget-sidebar-manage" name="widget-sidebar-manage">
				<option value=""><?php _e( 'Select Sidebar', 'wds' ); ?></option>
				<?php
				foreach ( $wp_registered_sidebars as $id => $sidebar ) {
					if (
						$sidebar['id'] == 'wp_inactive_widgets'
						|| ( false !== strpos( $sidebar['id'], 'orphaned_widgets' ) )
					)
						continue;
					echo '<option value="'. $sidebar['id'] .'">'. $sidebar['name'] .'</option>';
				}
				?>
			</select>
			<label id="widget-sidebar-manage-label"><b><?php _e( 'Select a Sidebar to Edit:', 'wds' ); ?></b></label>
			<div style="clear:both;"></div>
		</div>
		<?php
	}
}
new NBC_Widget_Sidebar_Manage();