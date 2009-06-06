<?php
/*
Plugin Name: Google Chart Generator
Plugin URI: http://brockangelo.com/wordpress/plugins/google-chart-generator/
Description: Allows the user to create and insert a Google Chart in posts and pages.
Version: 1.0.4
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

add_action('admin_menu', 'gcg_menu');
add_action('admin_head', 'gcg_head');

function gcg_menu() {
  add_options_page('Google Chart Generator Options', 'Google Chart Generator', 8, __FILE__, 'gcg_options');
}

function gcg_head() {
	?>
<script type="text/javascript">

	function selText()
		{
		document.getElementById("chart_link").select();
		}

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
	
	// Chart Background
	chart_bg = document.forms[0].gcg_bgcolor.value;
	if (chart_bg != "")
	{
		chart_bg = "&chf=bg,s," + chart_bg;
	}
	
	// Chart Data
	chartdata=document.forms[0].gcg_chartdata;
	var data = new Array();
	{
	for (i=0;i<chartdata.length;i++)
		if (chartdata[i].value) {
		data[i] = chartdata[i].value;
	  	}
	}
		
	// Chart Data Colors
	chartdata_colors=document.forms[0].gcg_data_color;
	var chart_colors= new Array();
	for (i=0;i<chartdata_colors.length;i++)
	{
	  if (chartdata_colors[i].value)
	  {	  
		chart_colors[i] = chartdata_colors[i].value;
		}
	}
	var data_color_string = chart_colors.join("|");
	if (data_color_string != "") {
	data_color_string = "&chco=" + data_color_string;
	}
	
	
	// Chart Labels
	chartlabels=document.forms[0].gcg_labels;
	var labels = new Array();
	for (i=0;i<chartlabels.length;i++)
	{
	  if (chartlabels[i].value)
	  {
		labels[i] = chartlabels[i].value;
		}
	}
	var labelstring = labels.join("|");
	if ((labelstring != "") && (charttype != "cht=lc")){
	labelstring = "&chl=" + labelstring;
	} else if ((labelstring != "") && ((charttype == "cht=lc") || (charttype == "cht=bvs"))){
	labelstring = "&chxt=x&chxl=0:|" + labelstring;
	}

	// Show Chart Data Point Labels
	
	if (document.forms[0].gcg_chart_point_labels.checked) {
		data_point_labels = "&chm=N*f0*,000000,0,-1,11";
	}
	else {
	data_point_labels = "";
	}
	
	// Chart Title
	chart_title_line_1 = document.forms[0].gcg_title_line1.value;
	if (chart_title_line_1 !="") {
		chart_title_line_1 = chart_title_line_1.replace(" ", "+");
		title="&chtt=" + chart_title_line_1;
		chart_title_line_2 = document.forms[0].gcg_title_line2.value;
			if (chart_title_line_2 !="") {
				chart_title_line_2 = chart_title_line_2.replace(" ", "+");
				title=title + "|" + chart_title_line_2;
			}
	}
	else {
	chart_title_line_2 = document.forms[0].gcg_title_line2.value;
	if (chart_title_line_2 !="") {
			alert("Chart Title Line 1 is empty.");
		}
		title="";
	}
	
	if (title !=""){
		chart_title_font_color = document.forms[0].gcg_title_font_color.value;
		chart_title_font_size = document.forms[0].gcg_title_font_size.value;
		if (chart_title_font_color != "") 
		{
			if (chart_title_font_size != "") 
				{
				title_font="&chts=" + chart_title_font_color + "," + chart_title_font_size;
				}
			else
				{
				title_font="&chts=" + chart_title_font_color;
				}
		}
		else 
		{
				title_font="";
				if (chart_title_font_size != "")
				{
				alert("Chart Tile must have a color if size is specified.");
				}
		}
	}
	
	document.getElementById("chart_link").value="http://chart.apis.google.com/chart?" + charttype + "&chs=" + chart_width + "x" + chart_height + chart_bg + "&chd=t:" + data + data_color_string + data_point_labels + labelstring + title + title_font;
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
		<span>Version Notes: 1.0.4</span>
		</h3>
		<div class="inside">
		<ul>
		<li>Data Points and Axis Labels! Have you <a href="http://wordpress.org/extend/plugins/google-chart-generator/">rated this plugin</a> yet?<br/>
		<br />
		Ideas & Known Issues:<br /><br />
		1. Now supports up to 8 data points!<br />
		2. The labels box will now give you the most relevant looking results possible: if you are using a bar chart, the labels used are called "Axis Labels" (according to Google) but when you switch over to a Pie Chart, the labels intelligently move to become data points.<br />
		3. IE no longer looks <i>really</i> crappy.<br />
		4. Data Points Labels! Add these to Line & Bar charts.<br />
		5. Once I get static data input pretty polished, I'll move on to link this into the WordPress database so you can see dynamic charts for things like "Today's Visitors were from these continents". Pretty dang shlick.<br />
		6. Add button on the write post screen. (for write/edit and posts/pages)<br />
		7. Save charts to a table so that you can insert "favorite charts"<br /><br />

		If you like the direction this plugin is headed, please <a href="http://brockangelo.com/wordpress/plugins/google-chart-generator/">leave feedback</a>, spread the word, or <a href="http://wordpress.org/extend/plugins/google-chart-generator/">give me some stars</a>.</li><br />
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
		<table cellspacing="10">
		<td width="250">
		<img id="chart" src="http://chart.apis.google.com/chart?cht=lc&chs=500x300&chf=bg,s,E7E7E7&chd=t:41,100,22,72,26&chm=N*f0*,000000,0,-1,11&chxt=x&chxl=0:|Mon|Tue|Wed|Thur|Fri&chtt=Daily+Downloads|for+this plugin&chts=000000,16" />
		<br />
		<br />
		<input type="text" id="chart_link" size="50" value="copy this code"><br /><br />
		<input type="button" class="button-primary" onclick="gcg_create_link()" value="Update Chart">
		<input type="button" class="button" value="select" onclick="selText()"> 
		</td>
		</table>
		</div>
		</div>
		
		<div id="chart_type_box" class="postbox">
		<h3 id="chart_type_box_hndle" class="hndle">Chart Type, Size, Background</h3>
		<div id="chart_type_box_inside" class="inside">
		<table cellspacing="10">
		<td width="250">
		<input type="radio" name="gcg_charttype" value="bvs">Bar Chart<br />
		<input type="radio" name="gcg_charttype" value="lc">Line Chart<br />
		<input type="radio" name="gcg_charttype" value="p3">Pie Chart<br />
		<input type="radio" name="gcg_charttype" value="gom">Google-o-Meter<br />
		</td>
		<td width="250">
		<input type="text" size="6" name="gcg_width" value="500"> Width<br />
		<input type="text" size="6" name="gcg_height" value="300"> Height<br />
		<input type="text" size="6" name="gcg_bgcolor" value="E7E7E7"> Background Color<br />
		</td>
		</table>
		</div>
		</div>

		
		<div id="chart_title_box" class="postbox">
		<h3 id="chart_title_box_hndle" class="hndle">Chart Title</h3>
		<div id="chart_title_box_inside" class="inside">
		<table cellspacing="10">
		<td width="250">
		<input type="text" size="20" id="gcg_title_line1" value="Daily Downloads"> Line 1<br />
		<input type="text" size="20" id="gcg_title_line2" value="for this plugin"> Line 2<br />
		</td>
		<td width="250">
		<input type="text" size="6" name="gcg_title_font_size" value="16"> Font Size<br />
		<input type="text" size="6" name="gcg_title_font_color" value="000000"> Font Color<br />
		</td>
		</table>
		</div>
		</div>
		
		<div id="chart_data_points_box" class="postbox" style="display:block">
		<h3 id="data_points_box_hndle" class="hndle">Data Points</h3>
		<div id="data_points_box_inside" class="inside">
		<table cellspacing="10">
		<td width="450">
		
		<input type="text" size="4" name="gcg_chartdata" value="41"> Data1 
		<input type="text" size="6" name="gcg_data_color" value="006600"> Color		
		<input type="text" size="10" name="gcg_labels" value="Mon"> Label<br />

		<input type="text" size="4" name="gcg_chartdata" value="100"> Data2  
		<input type="text" size="6" name="gcg_data_color" value=""> Color	
		<input type="text" size="10" name="gcg_labels" value="Tue"> Label<br />

		<input type="text" size="4" name="gcg_chartdata" value="22"> Data3  
		<input type="text" size="6" name="gcg_data_color" value=""> Color	
		<input type="text" size="10" name="gcg_labels" value="Wed"> Label<br />

		<input type="text" size="4" name="gcg_chartdata" value="72"> Data4  
		<input type="text" size="6" name="gcg_data_color" value=""> Color	
		<input type="text" size="10" name="gcg_labels" value="Thur"> Label<br />

		<input type="text" size="4" name="gcg_chartdata" value="26"> Data5  
		<input type="text" size="6" name="gcg_data_color" value=""> Color	
		<input type="text" size="10" name="gcg_labels" value="Fri"> Label<br />

		<input type="text" size="4" name="gcg_chartdata" value=""> Data6  
		<input type="text" size="6" name="gcg_data_color" value=""> Color	
		<input type="text" size="10" name="gcg_labels" value=""> Label<br />

		<input type="text" size="4" name="gcg_chartdata" value=""> Data7  
		<input type="text" size="6" name="gcg_data_color" value=""> Color	
		<input type="text" size="10" name="gcg_labels" value=""> Label<br />

		<input type="text" size="4" name="gcg_chartdata" value=""> Data8  
		<input type="text" size="6" name="gcg_data_color" value=""> Color	
		<input type="text" size="10" name="gcg_labels" value=""> Label<br />
		
		<br /><br />

		<input type="button" class="button-primary" onclick="gcg_create_link()" value="Update Chart">
		<input type="button" class="button" onclick="document.forms[0].reset()" value="reset all data"><br />
		</td>
		
		<td width="450" align="right" valign="top">
		<input type="checkbox" name="gcg_chart_point_labels" checked="checked"> Data Point Labels <i><small>(for Line & Bar charts)</small></i>
		</td>
		</table>
		</div>
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