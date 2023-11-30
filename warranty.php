<?php
/**
 * Plugin Name: WP Product Warranty Non WooCommerce
 * Description: This is Warranty Plugin for Non WooCommerce
 * Version: 1.0
 * Author: Sazid
 * Author URI: https://www.linkedin.com/in/sheikh-sazidul/
 */

 if(!defined('ABSPATH')) {
    header("Location: /");
    die();
 }

 function warranty_activation(){
    global $wpdb, $table_prefix;
    $wp_warranty = $table_prefix.'warranty';

    $q = "CREATE TABLE IF NOT EXISTS `$wp_warranty` (`id` INT NOT NULL AUTO_INCREMENT , 
         `user_id` INT NOT NULL , `order_id` VARCHAR(100) NOT NULL , `purchase_date` DATE NOT NULL , 
         `product_id` INT NOT NULL DEFAULT '1' , 
         `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
         PRIMARY KEY (`id`)) ENGINE = InnoDB;";

    $wpdb->query($q);

    $wp_wclaim = $table_prefix.'wclaim';

    $p = "CREATE TABLE IF NOT EXISTS `$wp_wclaim` (`id` INT NOT NULL AUTO_INCREMENT , 
    `user_id` INT NOT NULL , `warranty_id` INT NOT NULL , `description` VARCHAR(625) NOT NULL , 
    `status` VARCHAR(50) NOT NULL DEFAULT 'Initiated' , `order_id` VARCHAR(100) NOT NULL , 
    `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    PRIMARY KEY (`id`)) ENGINE = InnoDB;";
    
    $wpdb->query($p);

 }

 function my_custom_scripts(){
  $path_js = plugins_url('js/main.js', __FILE__);
  $path_style = plugins_url('css/style.css', __FILE__);

  $ver_js = filemtime(plugin_dir_path(__FILE__).'js/main.js');
  $ver_css = filemtime(plugin_dir_path(__FILE__).'css/style.css');

  wp_enqueue_style('psurvey-style', $path_style, '', $ver_css);

  wp_enqueue_script('psurvey-js', $path_js, '', $ver_js, true);
 }
 add_action('wp_enqueue_scripts', 'my_custom_scripts');


 register_activation_hook(__FILE__, 'warranty_activation');

 function warranty_deactivation(){

 }

 register_deactivation_hook(__FILE__, 'warranty_deactivation');

 function warranty_func(){
   include 'admin/warrany.php';
 }
 function claim_func(){
 	include 'admin/wclaim.php';

 }
 
 function wcuser_func(){
  include 'admin/wcuser.php';
 }

 function warranty_menu(){
   add_menu_page('Warranty', 'Warranty', 'manage_options', 'warranty-page', 'warranty_func', '', 6);

   add_submenu_page('warranty-page', 'Warranty Claimed', 'Warranty Claimed', 'manage_options', 'claim', 'claim_func');
   
   add_submenu_page('warranty-page', 'User List', 'User List', 'manage_options', 'wcuser', 'wcuser_func');
 }

 add_action('admin_menu', 'warranty_menu');

 function warranty_registration(){
   ob_start();
   include 'public/warranty-register.php';
   return ob_get_clean();
 }

 add_shortcode('warranty-register', 'warranty_registration');

 function warranty_info(){
   //ob_start();
   include 'public/warranty-info.php';
   //return ob_get_clean();
 }

 add_shortcode('warranty-info', 'warranty_info');

 function warranty_claim(){
   ob_start();
   include 'public/warranty-claim.php';
   return ob_get_clean();
 }

 add_shortcode('warranty-claim', 'warranty_claim');

 function warranty_cinfo(){
   //ob_start();
   include 'public/warranty-claim-status.php';
   //return ob_get_clean();
 }

 add_shortcode('warranty-cinfo', 'warranty_cinfo');