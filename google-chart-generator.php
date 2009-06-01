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
	// Chart Type
	chart=document.forms[0].gcg_charttype;
	charttype="cht=p3";
	for (i=0;i<chart.length;++ i)
	{
	 if (chart[i].checked)
		{
		charttype="cht=" + chart[i].value;
		}
	}
	// Chart Size
	chart_width = document.forms[0].gcg_width.value;
	chart_height = document.forms[0].gcg_height.value;
	// Chart Data
	chartdata=document.forms[0].gcg_chartdata;
	data="";
	for (i=0;i<chartdata.length;++ i)
	{
	  if (i>0)
	  {
		data=data+",";
	  }
	  if (chartdata[i].value)
	  {
		data=data + chartdata[i].value;
	  }
	}
	
	document.getElementById("chart_link").value="http://chart.apis.google.com/chart?" + charttype + "&chs=" + chart_width + "x" + chart_height + "&chd=t:" + data;
	document.getElementById("chart_url").value=chart_link;
	document.getElementById("chart").src="\"" + chart_link + "\"";
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
		<input type="radio" name="gcg_charttype" value="bvs">Bar Chart<br />
		<input type="radio" name="gcg_charttype" value="lc">Line Chart<br />
		<input type="radio" name="gcg_charttype" value="p3">Pie Chart<br />
		<input type="radio" name="gcg_charttype" value="gom">Google-o-Meter<br />
		<br />
		<input type="text" size="5" name="gcg_width" value="250">Width<br />
		<input type="text" size="5" name="gcg_height" value="100">Height<br />
		<br />
		<input type="text" size="5" name="gcg_chartdata" value="30">Data1<br />
		<input type="text" size="5" name="gcg_chartdata" value="100">Data2<br />
		<br />
		<input type="text" id="chart_link" size="60" value="copy this code">
		<input type="button" onclick="gcg_create_link()" value="Update Chart">
		<input type="button" value="select" onclick="selText()"> 
		<br />
		<br />
		<img id="chart" src="http://chart.apis.google.com/chart?cht=p3&chd=s:Uf9a&chs=250x100&chl=January|February|March|April" />
	</form>


	<br />
	<br />
	</div>

	<?php
	}


?>