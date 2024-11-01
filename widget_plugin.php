<?php
/**
Plugin Name: Sticky Notes
Plugin URI: http://wordpress.org/plugins//
Description: Used To Display Notes on Sidebar
Author: Dolar Patel
Version: 1.1
Author URI: 
*/
if(!defined( 'ABSPATH' ) )
	exit();

class stn_plugin extends WP_Widget {

	function stn_plugin() {
		parent::__construct(false, $name = __('Sticky Notes', 'stn_plugin') );
		
	}

	function form($instance) {
		if( $instance) {
			 $title = esc_attr($instance['title']);
			 $color = esc_attr($instance['color']);
			 $text_color = esc_attr($instance['text_color']);
			 $textarea = esc_textarea($instance['textarea']);
			 $page_type = esc_textarea($instance['page_type']);
		} else {
			 $title = '';
			 $textarea = '';
			 $color = '';
			 $text_color = '';
			 $page_type = '';
		}
		wp_enqueue_script('colorbox',plugins_url( '', __FILE__ ).'/assests/js/jscolor.js',array('jquery'), '', true  );
	?>

        <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'stn_plugin'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p><label for="<?php echo $this->get_field_id('Title Color'); ?>"><?php _e('Title Color', 'wp_widget_plugin'); ?></label>
        <input id="<?php echo $this->get_field_id('color'); ?>" name="<?php echo $this->get_field_name('color'); ?>" type="text" class="jscolor" <?php if($color){?> value="<?php echo $color; ?>" <?php }else{ ?> value="#000000" <?php } ?>>
        </p>
         <p><label for="<?php echo $this->get_field_id('Text Color'); ?>"><?php _e('Text Color', 'wp_widget_plugin'); ?></label>
        <input id="<?php echo $this->get_field_id('text_color'); ?>" name="<?php echo $this->get_field_name('text_color'); ?>" type="text" class="jscolor" <?php if($text_color){?> value="<?php echo $text_color; ?>" <?php }else{ ?> value="#FFFFFF" <?php } ?>">
        </p>
        <p><label for="<?php echo $this->get_field_id('Page Type'); ?>"><?php _e('Page Type', 'wp_widget_plugin'); ?></label>
        <select class='widefat' id="<?php echo $this->get_field_id('page_type'); ?>" name="<?php echo $this->get_field_name('page_type'); ?>" type="text">
          <option value=' '<?php echo ($page_type=='multicolor_page')?'selected':''; ?>>
            Select
          </option>
          <option value='multicolor_page'<?php echo ($page_type=='multicolor_page')?'selected':''; ?>>
            Multicolor Page
          </option>
         <?php /*?> <option value='single_yellow_page'<?php echo ($page_type=='single_yellow_page')?'selected':''; ?>>
            Single Yellow Page
          </option><?php */?>
          <option value='purple_with_Stich_pin'<?php echo ($page_type=='purple_with_Stich_pin')?'selected':''; ?>>
            Purple With Stich Pin
          </option>
          <option value='purple_with_dot_pin'<?php echo ($page_type=='purple_with_dot_pin')?'selected':''; ?>>
            Purple With Dot Pin
          </option>
        </select> 
        </p>
        <p>
        <label for="<?php echo $this->get_field_id('textarea'); ?>"><?php _e('Textarea:', 'wp_widget_plugin'); ?></label>
        <textarea class="widefat" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>" maxlength="100"  ><?php echo $textarea; ?></textarea>
        </p>
	<?php }

	
	function stn_update($new_instance, $old_instance) {
		  $instance = $old_instance;
		  $instance['title'] = strip_tags($new_instance['title']);
		  $instance['textarea'] = strip_tags($new_instance['textarea']);
		  $instance['color'] = strip_tags($new_instance['color']);
		  $instance['text_color'] = strip_tags($new_instance['text_color']);
		  $instance['page_type'] = strip_tags($new_instance['page_type']);
		 return $instance;
	}

	function widget($args, $instance) {
	   extract( $args );
	   wp_enqueue_style( 'sticky-note-style', plugins_url( '', __FILE__ ).'/assests/css/sticky.css' );	
	   $title = apply_filters('widget_title', $instance['title']);
   	   $textarea = $instance['textarea'];
   	   $color = $instance['color'];
	   $text_color = $instance['text_color'];
	   $page_type = $instance['page_type'];
	  
	  
	   echo $before_widget;
	   $div = '';
	  if($page_type && $page_type != ' '){
		  echo $div = '<div class="sticky_cover" style="color:#'.$color.';background-image: url('.plugins_url( "", __FILE__ ).'/assests/image/'.$page_type.'.png);">';
	   }else{		
			echo '<div class="sticky_cover">';	
	   }
	  
	   if ( $title ) {
		   if($text_color){
		   		echo '<h2 class="sticky_cover_title" style="color:#'.$color.'">' . $title . "</h2>";
		   }else{
		  		echo '<h2 class="sticky_cover_title">' . $title . "</h2>";
		   }
	   }
	
	   if( $textarea ) {
		  if($text_color) 
			 	echo '<p class="sticky_cover_text" style="color:#'.$text_color.'">'.$textarea.'</p>';
		   else
		   		echo '<p class="sticky_cover_text">'.$textarea.'</p>';	 
	   }
	   echo '</div>';
	   
	   echo $after_widget;
	}
}
add_action('widgets_init', create_function('', 'return register_widget("stn_plugin");'));
?>