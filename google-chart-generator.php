<?php
/*
Plugin Name: Google Chart Generator
Plugin URI: http://brockangelo.com/wordpress/plugins/google-chart-generator/
Description: Allows the user to create and insert a Google Chart in posts and pages.
Version: 1.0.2
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
add_action('admin_head', 'gcg_head');

function gcg_menu() {
  add_options_page('Google Chart Generator Options', 'Google Chart Generator', 8, __FILE__, 'gcg_options');
}

function gcg_head() {
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
	type=document.forms[0].gcg_charttype;
	charttype="cht=p3";
	for (i=0;i<type.length;++ i)
	{
	 if (type[i].checked)
		{
		charttype="cht=" + type[i].value;
		}
	}
	// Chart Size
	chart_width = document.forms[0].gcg_width.value;
	chart_height = document.forms[0].gcg_height.value;
	// Chart Data
	chartdata=document.forms[0].gcg_chartdata;
	data="";
	for (i=0;i<chartdata.length;i++)
	{
	  if (chartdata[i].value)
	  {
		data=data + chartdata[i].value;
		if (chartdata[i+1].value)
		{
		data=data + ",";
		}
	  }
	}
	document.getElementById("chart_link").value="http://chart.apis.google.com/chart?" + charttype + "&chs=" + chart_width + "x" + chart_height + "&chd=t:" + data;
	document.getElementById("chart").src=document.getElementById("chart_link").value;
	}
</script>

<?php
}

function gcg_options() {
	?>  
	<div class="wrap">
	<div id="icon-options-general" class="icon32"><br/></div>
	<h2>Google Chart Generator Options</h2>
	<div id="poststuff" class="metabox-holder">
		<div class="inner-sidebar" width="50%">
		<div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position: relative;">
		<div id="gcg_sidebar" class="postbox">
		<h3 class="hndle">
		<span>About this Plugin:</span>
		</h3>
		<div class="inside">
		<ul>
		<li><a href="http://brockangelo.com/wordpress/plugins/google-chart-generator/">Plugin Homepage</a></li>
		<li><a href="http://brockangelo.com/">Author Homepage</a><br /></li>
		<li><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5858131">Support this Plugin</a></li><br />
		</ul>
		</div>
		</div>
		<div id="gcg_sidebar" class="postbox">
		<h3 class="hndle">
		<span>Version Notes: 1.0.2</span>
		</h3>
		<div class="inside">
		<ul>
		<li>This plugin was accidentally released before development was complete. So this is the beta version. :-) Some known issues:<br/>
		1. Doesn't actually support 8 data sets.<br />
		2. There are so many more Google Charts. More to come.<br />
		3. Changing the color and adding labels is in the works.<br /><br />
		If you like the direction this plugin is headed, please <a href="http://brockangelo.com/wordpress/plugins/google-chart-generator/">leave feedback</a> and <a href="http://wordpress.org/extend/plugins/google-chart-generator/">give me five stars</a>.</li><br />
		</ul>
		</div>
		</div>
		</div>
		</div>
	<div class="has-sidebar">
	<div id="post-body-content" class="has-sidebar-content">
	<div class="meta-box-sortabless">
	<form>

		<div id="chart_box" class="postbox">
		<h3 id="chart_box_hndle" class="hndle">Google Chart</h3>
		<div id="chart_box_inside" class="inside">
		<img id="chart" src="http://chart.apis.google.com/chart?cht=p3&chd=s:Uf9a&chs=250x100&chl=January|February|March|April" style="border: 1px solid #D8D1BE" />
		<br />
		<br />
		<input type="text" id="chart_link" size="50" value="copy this code"><br /><br />
		<input type="button" class="button-primary" onclick="gcg_create_link()" value="Update Chart">
		<input type="button" class="button" value="select" onclick="selText()"> 
		</div>
		</div>
		
		<div id="chart_type_box" class="postbox">
		<h3 id="chart_type_box_hndle" class="hndle">Chart Type</h3>
		<div id="chart_type_box_inside" class="inside">
		<input type="radio" name="gcg_charttype" value="bvs">Bar Chart<br />
		<input type="radio" name="gcg_charttype" value="lc">Line Chart<br />
		<input type="radio" name="gcg_charttype" value="p3">Pie Chart<br />
		<input type="radio" name="gcg_charttype" value="gom">Google-o-Meter<br /></div>
		</div>
		
		<div id="chart_size_box" class="postbox">
		<h3 id="chart_size_box_hndle" class="hndle">Chart Size</h3>
		<div id="chart_size_box_inside" class="inside">
		<input type="text" size="4" name="gcg_width" value="250">Width<br />
		<input type="text" size="4" name="gcg_height" value="100">Height<br /></div>
		</div>
		
		<div id="data_points_box" class="postbox">
		<h3 id="data_points_box_hndle" class="hndle">Data Points</h3>
		<div id="data_points_box_inside" class="inside">
		<input type="text" size="4" name="gcg_chartdata" value="15">Data1<br />
		<input type="text" size="4" name="gcg_chartdata" value="45">Data2<br />
		<input type="text" size="4" name="gcg_chartdata" value="30">Data3<br />
		<input type="text" size="4" name="gcg_chartdata" value="85">Data4<br />
		<input type="text" size="4" name="gcg_chartdata" value="">Data5<br />
		<input type="text" size="4" name="gcg_chartdata" value="">Data6<br />
		<input type="text" size="4" name="gcg_chartdata" value="">Data7<br />
		<input type="text" size="4" name="gcg_chartdata" value="">Data8<br /></div>
		</div>
	
		
</form>

	
	
		</div>
		</div>
	<br />
	<br />
	</div>
	</div>

	<?php
	}


?>