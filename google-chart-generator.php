<?php
/*
Plugin Name: Google Chart Generator
Plugin URI: http://brockangelo.com/wordpress/plugins/google-chart-generator/
Description: Allows the user to create and insert a Google Chart in posts and pages.
Version: 1.0
Author: Brock Angelo
Author URI: http://brockangelo.com

Copyright 2009  Brock Angelo  (email : email@brockangelo.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


# add_action('google_chart_generator', 'delete_spam_now');

# function gcg_start_schedule() {
# 	wp_schedule_event(time(), 'daily', 'google_chart_generator');
# }

function gcg_chart_now() {
	global $wpdb;
}

add_action('admin_menu', 'gcg_menu');
add_action('admin_head', 'gcg_admin_head');

function gcg_menu() {
  add_options_page('Google Chart Generator Options', 'Google Chart Generator', 8, __FILE__, 'gcg_options');
}

function gcg_admin_head() {
	?>
	<script type="text/javascript">
		function check(gcg_charttype)
			{
			document.getElementById("chart_link").value=gcg_charttype;
			}
		function selText()
			{
			document.getElementById("chart_link").select();
			}
	</script>
	
<script type="text/javascript">
	function gcg_create_link()
	{
	chart=document.forms[0].gcg_charttype;
	charttype="cht=p3";
	for (i=0;i<chart.length;++ i)
	{
	 if (chart[i].checked)
		{
		charttype="cht=" + chart[i].value;
		}
	}
	chartwidth=document.write(gcg_width);
	chartheight=document.write(gcg_height);
	document.getElementById("chart_link").value="<img src=\"http://chart.apis.google.com/chart?" + charttype + "&amp;" + chartwidth + "x" + chartheight + "\" />";
	}
</script>
	
<?php
}

function gcg_options() {
	$valid_nonce = wp_verify_nonce($_REQUEST['_wpnonce'],'google_chart_generator');
	if ( $valid_nonce ) {
		if(isset($_REQUEST['delete_spam_now_button'])) {
			gcg_chart_now();
		}
		if(isset($_REQUEST['google_chart_generator_button'])) {
			gcg_start_schedule();
		}
	}
  
	if ( !empty($_POST ) ) : ?>
	<div id="message" class="updated fade">
	<strong>Chart updated</strong>
	</div>
	<?php endif; ?>

	<div class="wrap">
	<h2>Google Chart Generator Options</h2>

	<form>
		<input type="radio" name="gcg_charttype" onclick="check(this.value)" value="bvs">Bar Chart<br />
		<input type="radio" name="gcg_charttype" onclick="check(this.value)" value="lc">Line Chart<br />
		<input type="radio" name="gcg_charttype" onclick="check(this.value)" value="p3">Pie Chart<br />
		<input type="radio" name="gcg_charttype" onclick="check(this.value)" value="gom">Google-o-Meter<br />
		<br />
		<input type="text" size="5" name="gcg_width" value="250">Width<br />
		<input type="text" size="5" name="gcg_height" value="100">Height<br />
		<br />
		<input type="text" id="chart_link" size="60" value="copy this code">
		<input type="button" onclick="gcg_create_link()" value="Update Chart">
		<input type="button" value="select" onclick="selText()"> 
	</form>


	<br />
	<br />
	</div>

	<?php
	}


?>