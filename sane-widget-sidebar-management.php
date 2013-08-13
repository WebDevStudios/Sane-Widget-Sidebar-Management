<?php
/*
Plugin Name: Sane Widget Sidebar Management
Plugin URI: http://webdevstudios.com/
Description: Manage one sidebar at a time to maintain widget sanity.
Author: WebDevStudios.com
Version: 1.0.1
Author URI: http://webdevstudios.com/
*/

class WDS_Widget_Sidebar_Manage {

	public function __construct() {
		add_action( 'load-widgets.php', array( $this, 'init_hooks' )  );
	}

	public function init_hooks() {
		add_action( 'widgets_admin_page', array( $this, 'sidebar_select' )  );
		add_action( 'admin_print_styles', array( $this, 'print_styles' ) );

		wp_enqueue_script( 'wds-widget-manage-scripts', plugins_url( '/widget-sidebar-manage.js', __FILE__ ), array( 'jquery', 'admin-widgets' ), '1.0.0' );
	}

	public function print_styles() {
?>
<style type="text/css">
.wrap > h2 {
	float: left;
}
#widgets-right {
	position: relative;
}
#widget-sidebar-manage-wrap {
	float: right;
	margin-top: 15px;
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
	margin: 5px 33px 0 0;
}
</style>
<?php
	}

	public function sidebar_select() {
		global $wp_registered_sidebars;
		?>
		<div id="widget-sidebar-manage-wrap" style="display: none;">
			<select id="widget-sidebar-manage" name="widget-sidebar-manage">
				<option value=""><?php _e( 'Select Widget Area', 'wds' ); ?></option>
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
			<label id="widget-sidebar-manage-label"><b><?php _e( 'Select a Widget Area to Edit:', 'wds' ); ?></b></label>
			<div style="clear:both;"></div>
		</div>
		<?php
	}
}
new WDS_Widget_Sidebar_Manage();
