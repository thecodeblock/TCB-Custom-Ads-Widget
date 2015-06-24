<?php
/**
Plugin Name: TheCodeBlock Ads Banner Widget
Description: TheCodeBlock Ads Banner Widget to Display Ads
Author: thecodeblock.com
*/
 
// Creating custom widget by inheriting WP_Widget Class
class tcb_ads_banners extends WP_Widget{
    /**
    * Constructer will be used to setup widgets name etc
    */
    public function __construct(){
        parent::__construct(
            /* Base ID for widget options */
            'tcb_ads_banners',
            /* Widget Title */
            __('TheCodeBlock Ads Banner Widget', 'tcb_widget_domain'),
            /* Widget Description */
            array('description' => __('TheCodeBlock Ads Banner Widget to Display Ads', 'tcb_widget_domain'), )
        );
    }
    
    /**
    * Output the content of the widget while generating html
    * @parameter array $args
    */
    public function widget($args, $instance){
        // Outputs the content of the Widget 
        $title = ($instance['title']) ? $instance['title'] : __('Advertisement', 'tcb_widget_domain');
        $link = ($instance['link']) ? $instance['link'] : '';
        $image_uri = ($instance['image_uri']) ? $instance['image_uri'] : plugin_dir_url(__FILE__ ).'/images/img-placeholder.png';
        echo $args['before_widget'];
        if(!empty($instance['title'])){
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        ?>
        <a href="<?php echo $link; ?>">
            <img src="<?php echo $image_uri; ?>" class="img-responsive" alt="Advertisement">
        </a>
        <?php
        echo $args['after_widget'];
    }
    
    /**
    * Outputs the options form on admin
    * @param array $instance holds the widgets options
    */
    public function form($instance){        
        if(!isset($instance['title'])) $instance['title'] = __('Advertisement');
        if(!isset($instance['link'])) $instance['link'] = '';
        if(!isset($instance['image_uri'])) $instance['image_uri'] = plugin_dir_url(__FILE__ ).'/images/img-placeholder.png';
        // Output the fields to admin widget area here
        ?>
          <p>
              <label for="<?php echo $this->get_field_id('title'); ?>">Widget Title</label>
              <input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo $this->get_field_name('title'); ?>" id="<?php $this->get_field_id('title'); ?>" />
          </p>
          <p>
              <label for="<?php echo $this->get_field_id('link'); ?>">Ad Link</label>
              <input class="widefat" type="url" value="<?php echo esc_attr($instance['link']); ?>" name="<?php echo $this->get_field_name('link'); ?>" id="<?php $this->get_field_id('link'); ?>" />
          </p>
          <p style="border: 1px dashed #aaa; padding: 20px 0; text-align: center;">
              <img class="custom_media_image" src="<?php echo esc_attr($instance['image_uri']); ?>" style="margin: 0 auto; display: block; height: auto; margin-bottom: 10px; max-width: 100%;" />
              <input type="button" value="Upload Image" class="button upload_ad_image" id="custom_image_uploader"/>
          </p>      
          <p>
              <input type="hidden" class="widefat custom_media_url" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo esc_attr($instance['image_uri']); ?>">
          </p>
          <br> 
        <?php
    }
    
    /**
    * Processing form option when hit save
    *
    * @parameter array $new_instance holds the new options
    * @parameter array $old_instance holds the old options
    */
    public function update( $new_instance, $old_instance){
        //save widget options
        $instance = $old_instance;
        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
        $instance[ 'link' ] = strip_tags( $new_instance[ 'link' ] );
        $instance[ 'image_uri' ] = strip_tags( $new_instance[ 'image_uri' ] );
        return $instance;
    }
    
}

/**
* Enqueues all scripts, styles, settings, and templates necessary to use all media JavaScript APIs.
*/
function tcb_media_scripts(){
    wp_enqueue_media();
    wp_enqueue_script('tcb_ad_script', plugin_dir_url(__FILE__ ) .'/js/tcb_ads_widget.js' , array( 'jquery' ));
}
add_action('admin_enqueue_scripts', 'tcb_media_scripts');

// register tcb_ads_banners
function register_tcb_widget(){
    register_widget('tcb_ads_banners');
}
// Action hook to Add Widget
add_action( 'widgets_init', 'register_tcb_widget' );