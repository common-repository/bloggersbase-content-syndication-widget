<?php
/*
 
Plugin Name: Hot on BloggersBase Widget
Plugin URI: http://www.bloggersbase.com/wordpress/
Description: Syndication of BloggersBase's hot stories on your site
Author: Alex Dvorkin
License: GPL
Version: 1.0.0
Author URI: http://www.bloggersbase.com

*/

// This prints the widget
function xBBSWWidgetShow($args)
{
			extract($args);
			
			$xBBSWTitle = get_option('xBBSWTitle');
			$referrer_id = get_option('xBBSWRefId');
			$color = get_option('xBBSWColor');
			$category = get_option('xBBSWCategory');
			
			if ($category == "") $category = "a6a842c6^1";
			if ($title == "") $title = "Hot on BloggersBase";
			if ($color == "") $color = "White";

			$temp = explode("^", $category);
			
			echo $before_widget.$before_title.$xBBSWTitle.$after_title;
			echo xBBSWWGetPage("http://www.bloggersbase.com/get_hot_stories.aspx?category=".$temp[0]."&referrer=$referrer_id&size=99&schema=$color&language=1".($temp[1] == 1 ? "" : "&blog=".$temp[0]));
			echo $after_widget;
}
	
function xBBSWWidgetInit()
{
			// Tell Dynamic Sidebar about our new widget and its control
			register_sidebar_widget(array('Hot on BloggersBase', 'widgets'), 'xBBSWWidgetShow');
			register_widget_control(array('Hot on BloggersBase', 'widgets'), 'xBBSWform');
}

function xBBSWform()
{
			$colors = array('White:1', 'Gray:2');
			$scope = explode("|", xBBSWWGetPage("http://www.bloggersbase.com/api/get_widget_scopes.ashx"));			
			
			if ($_POST['xBBSWTitle']) update_option('xBBSWTitle', $_POST['xBBSWTitle']);
			if ($_POST['xBBSWCategory']) update_option('xBBSWCategory', $_POST['xBBSWCategory']);
			if ($_POST['xBBSWColor']) update_option('xBBSWColor', $_POST['xBBSWColor']);
			if ($_POST['xBBSWRefId']) update_option('xBBSWRefId', $_POST['xBBSWRefId']);

			$referrer_id = get_option('xBBSWRefId');
			$title = get_option('xBBSWTitle');
			$color = get_option('xBBSWColor');			
			$category = get_option('xBBSWCategory');

			if ($category == "") $category = "a6a842c6^1";
			if ($title == "") $title = "Hot on BloggersBase";
			if ($color == "") $color = "White";
			
			echo "Widget title: <input type='text' name='xBBSWTitle' value='$title' />";
			echo "Subject: <select id='xBBSWCategory' name='xBBSWCategory'>";
			
			foreach ($scope as $key => $value)
			{
						$temp = explode(":", $value);
						echo "<option value='".$temp[1]."'".($temp[1] == $category ? " selected='selected'" : "").">".$temp[0]." </option>";
			}
			
			echo "</select><br />";
			echo "Color schema: <select name='xBBSWColor'>";
			
			foreach ($colors as $key => $value)
			{
						$temp = explode(":", $value);
						echo "<option value='".$temp[1]."'".($temp[1] == $color ? " selected='selected'" : "").">".$temp[0]." </option>";
			}
			
			echo "</select><br />";
			
			echo "Referrer ID: <input type='text' size='5' name='xBBSWRefId' value='$referrer_id' />";
			echo "&nbsp;<a href='http://www.bloggersbase.com/wordpress/' target='_blank'>what is it?</a>";
}


function xBBSWAddStyle()
{
?>
			<script type = "text/javascript"src = "<? echo bloginfo('url'); ?>/wp-content/plugins/BB-Syndication-Widget/script.js" > </script>
			<link rel="stylesheet" href="<?php echo bloginfo('url'); ?>/wp-content/plugins/BB-Syndication-Widget/style.css" type="text/css" media="screen" />
<?php
}

include('BB-syndication-utilities.php');

// Delay plugin execution to ensure Dynamic Sidebar has a chance to load first
add_action('plugins_loaded', 'xBBSWWidgetInit');
add_action('wp_print_styles', 'xBBSWAddStyle');

 
?>