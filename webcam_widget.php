<?php
/*
 * Plugin Name: FM-WebCam Widget
 * Version: 1.02
 * Plugin URI: http://www.frozen-media.de
 * Description: Show Webcam in Sidebar
 * Author: Thomas Ziegler, Frozen-Media
 * Author URI: http://www.frozen-media.de
 */

class FM_WebCam_Widget extends WP_Widget
{
 /**
  * Declares the FM_WebCam_Widget  class.
  *
  */
    function FM_WebCam_Widget(){
    $widget_ops = array('classname' => 'FM_WebCam_Widget', 'description' => __( "Show WebCam in Sidebar") );
    $control_ops = array('width' => 300, 'height' => 300);
    $this->WP_Widget('FM_WebCam', __('FM_WebCam'), $widget_ops, $control_ops);
    }

  /**
    * Displays the Widget
    *
    */
    function widget($args, $instance){

      $fmcam_plugin_path = plugin_basename(dirname(__FILE__))."/";

      /* Define Constants and variables*/
      if (is_multisite()) {
	global $blog_id;

	$fmcam_plugins_dir = __FILE__;
	if (!stristr($fmcam_plugins_dir, "mu-plugins") === false)
		$fmcam_plugins_dir = "mu-plugins";
	else
		$fmcam_plugins_dir = "plugins";
	$blog_path = $blog_id."/";
      }
      else {
	$blog_path = "";
	$fmcam_plugins_dir = "plugins";
      }
      if (!defined("WP_CONTENT_DIR")) define("WP_CONTENT_DIR", ABSPATH."/wp_content");
      if (!defined("FMCAM_PLUGIN_URI")) define('FMCAM_PLUGIN_URI', WP_CONTENT_URL.'/'.$fmcam_plugins_dir.'/'.$fmcam_plugin_path);
      
      extract($args);
      $title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title']);
      $imageurl = empty($instance['imageurl']) ? 'http://www.opentopia.com/images/data/cams/14312/medium.jpg' : $instance['imageurl'];
      $interval = empty($instance['interval']) ? '30' : $instance['interval'];
      $picwidth = empty($instance['picwidth']) ? '200' : $instance['picwidth'];
      $intervalMS = $interval * 1000; // Convert to ms


      // Workaround width is set
      if ($picwidth > 0) { $imageurl = FMCAM_PLUGIN_URI."minipic.php?size=".$picwidth."&pic=".$imageurl; }

      echo $before_widget;
      if ( $title ) echo $before_title . $title . $after_title;

      $widgetID = str_replace("-","_",$this->id);
      echo '<img name="'.$widgetID.'" src="'.$imageurl.'" alt="" />'."\n";
      echo '<script type="text/javascript"><!--'."\n";
      echo 'function reloadImage_'.$widgetID.'() {'."\n";
      echo 'var now = new Date();'."\n";
      echo 'if (document.images) {'."\n";
      echo 'document.images.'.$widgetID.'.src = "'.$imageurl.'&" + now.getTime();'."\n";
      echo '}'."\n";
      echo 'setTimeout("reloadImage_'.$widgetID.'()",'.$intervalMS.');'."\n";
      echo '}'."\n";
      echo 'setTimeout("reloadImage_'.$widgetID.'()",'.$intervalMS.');'."\n";
      echo '//--></script>'."\n";  

      echo $after_widget;
  }

  /**
    * Saves the widgets settings.
    *
    */
    function update($new_instance, $old_instance){
      $instance = $old_instance;
      $instance['title'] = strip_tags(stripslashes($new_instance['title']));
      $instance['imageurl'] = strip_tags(stripslashes($new_instance['imageurl']));
      $instance['interval'] = strip_tags(stripslashes($new_instance['interval']));
      $instance['picwidth'] = strip_tags(stripslashes($new_instance['picwidth']));

    return $instance;
  }

  /**
    * Creates the edit form for the widget.
    *
    */
    function form($instance){
      //Defaults
      $instance = wp_parse_args( (array) $instance, array('title'=>'', 'imageurl'=>'http://www.opentopia.com/images/data/cams/14312/medium.jpg', 'interval'=>'30', 'picwidth'=>'200') );

      $title = htmlspecialchars($instance['title']);
      $imageurl = htmlspecialchars($instance['imageurl']);
      $interval = htmlspecialchars($instance['interval']);
      $picwidth = htmlspecialchars($instance['picwidth']);

      # Output the options
      echo '<p style="text-align:left;"><label for="' . $this->get_field_name('title') . '">' . __('Title:') . ' <input style="width: 250px;" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></label></p>';

      echo '<p style="text-align:left;"><label for="' . $this->get_field_name('imageurl') . '">' . __('ImageURL:') . ' <input style="width: 200px;" id="' . $this->get_field_id('imageurl') . '" name="' . $this->get_field_name('imageurl') . '" type="text" value="' . $imageurl . '" /></label></p>';

      echo '<p style="text-align:left;"><label for="' . $this->get_field_name('picwidth') . '">' . __('Image width(px):') . ' <input style="width: 50px;" id="' . $this->get_field_id('picwidth') . '" name="' . $this->get_field_name('picwidth') . '" type="text" value="' . $picwidth . '" /> (0=disable)</label></p>';

      echo '<p style="text-align:left;"><label for="' . $this->get_field_name('interval') . '">' . __('Refresh(sec):') . ' <input style="width: 50px;" id="' . $this->get_field_id('interval') . '" name="' . $this->get_field_name('interval') . '" type="text" value="' . $interval . '" /></label></p>';
  }

}// END class

/**
  * Register FM_WebCam_Widget widget.
  * Calls 'widgets_init' action after the FM_WebCam_Widget has been registered.
  */
  function FM_WebCam_WidgetInit() {
  register_widget('FM_WebCam_Widget');
  }
  add_action('widgets_init', 'FM_WebCam_WidgetInit');
?>
