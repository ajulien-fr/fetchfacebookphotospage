<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.juavenel.fr/
 * @since      1.0.0
 *
 * @package    Fetchfacebookphotospage
 * @subpackage Fetchfacebookphotospage/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Fetchfacebookphotospage
 * @subpackage Fetchfacebookphotospage/public
 * @author     juavenel <juavenel@outlook.fr>
 */
class Fetchfacebookphotospage_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fetchfacebookphotospage_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fetchfacebookphotospage_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/fetchfacebookphotospage-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fetchfacebookphotospage_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fetchfacebookphotospage_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/fetchfacebookphotospage-public.js', array( 'jquery' ), $this->version, false );

	}

    public function config_change_event( $value ) {
        
        wp_clear_scheduled_hook( 'fetch_photos_daily_event' );
        
        if ( $value['opt-facebook-start'] == TRUE ) {
            if ( !empty($value['opt-facebook-id']) && !empty($value['opt-facebook-secret']) && !empty($value['opt-facebook-token'])) {
                if ( !wp_next_scheduled( 'fetch_photos_daily_event' ) ) wp_schedule_event( time(), 'daily', 'fetch_photos_daily_event' );
            }
        }
        
    }
    
    public function fetch_photos() {
        
        global $opt_FetchFacebookPhotosPage;
        
        $fb = new Facebook\Facebook([
            'app_id'  => $opt_FetchFacebookPhotosPage['opt-facebook-id'],
            'app_secret' => $opt_FetchFacebookPhotosPage['opt-facebook-secret'],
            'default_graph_version' => 'v2.8',
        ]);
        
        // You have to overwrite this String: "****************" from $fb->get();
        // by the album id of your facebook page!
        try {
            $response = $fb->get('/****************/photos?fields=images,link', $opt_FetchFacebookPhotosPage['opt-facebook-token']);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            error_log( 'Graph returned an error: ' . $e->getMessage() );
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            error_log( 'Facebook SDK returned an error: ' . $e->getMessage() );
            exit;
        }
        
        $photos = $response->getGraphEdge();
        
        $all_photos = array();
        
        if ( $fb->next( $photos ) ) {
            $photos_array = $photos->asArray();
            $all_photos = array_merge( $all_photos, $photos_array );
            
            while ( $photos = $fb->next( $photos ) ) { 
                $photos_array = $photos->asArray();
                $all_photos = array_merge( $all_photos, $photos_array );
            }
        }
        
        else {
            $photos_array = $photos->asArray();
            $all_photos = array_merge( $all_photos, $photos_array );
        }
        
        foreach($all_photos as $photo) {
            
            if ( !function_exists( 'post_exists' ) ) {
                require_once( ABSPATH . "wp-admin" . '/includes/post.php' );
            }
            
            if ( post_exists( wp_strip_all_tags( 'adoption-' . $photo['id'] ) ) == 0 ) {
                
                $post_id = $this->add_post( $photo );
            
                if ( is_wp_error( $post_id ) ) {
                    error_log( $post_id->get_error_message() );
                    exit;
                }
            
                $photo_id = $this->add_photo( $photo, $post_id);
            
                if ( is_wp_error( $photo_id ) ) {
                    error_log( $photo_id->get_error_message() );
                    exit;
                }
            }
        }
        
    }
    
    public function add_post( $photo ) {
        
        $post = array(
            'post_title'    => wp_strip_all_tags( 'adoption-' . $photo['id'] ),
            'post_category' => array( get_cat_ID( 'adoption' ) ),
            'post_status'   => 'publish',
            'post_author'   => get_user_by( 'slug', 'juavenel')->ID,
        );
        
        $post_id = wp_insert_post( $post );
        
        add_post_meta($post_id, 'facebook-url', $photo['link'], true);
        
        return $post_id;
    }
    
    public function add_photo( $photo, $post_id) {
        
        if ( !function_exists( 'media_handle_upload' ) ) {
            require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
            require_once( ABSPATH . "wp-admin" . '/includes/file.php' );
            require_once( ABSPATH . "wp-admin" . '/includes/media.php' );
        }
        
        // I have not found how to get the source of image
        // with the full size in single line from the graph api.
        // So, I take the "['images'][0]['source']" which is the max large size...
        $url = $photo['images'][0]['source'];
        $name = $photo['id'];
        
        $tmp = download_url( $url );
        
        if ( is_wp_error( $tmp ) ){
            return $tmp;
        }
        
        preg_match( '/[^\?]+\.(jpg|png)/i', $url, $matches );
        $type = wp_check_filetype( basename( $matches[0] ) );
        
        // rename the file downloaded with the name of its ID in Facebook
        $name = sanitize_file_name( $name );
        $path = pathinfo( $tmp );
        $new = $path['dirname'] . "/". $name . "." . $path['extension'];
        rename( $tmp, $new );
        $tmp = $new;
        
        $file_array = array();
        $file_array['tmp_name'] = $tmp;
        $file_array['name'] = $name . "." . $type['ext'];

        if ( is_wp_error( $tmp ) ) {
            @unlink($file_array['tmp_name']);
            $file_array['tmp_name'] = '';
            return $tmp;
        }

        $photo_id = media_handle_sideload( $file_array, $post_id );

        if ( is_wp_error( $photo_id ) ) {
            @unlink( $file_array['tmp_name'] );
            return $photo_id;
        }
        
        $meta_id = set_post_thumbnail( $post_id, $photo_id );
        
        return $meta_id;
    }
    
}
