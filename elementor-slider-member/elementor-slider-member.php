<?php
/**
 * Elementor Slider Member Plugin
 *
 * @package ElementorSliderMember
 *
 * Plugin Name: Elementor Slider Member
 * Description: Simple Elementor Slider Member plugin
 * Plugin URI:  https://www.linkedin.com/in/miguel-mariano-developer/
 * Version:     1.0.0
 * Author:      Miguel Mariano
 * Author URI:  https://www.linkedin.com/in/miguel-mariano-developer/
 * Text Domain: elementor-slider-member
 */
namespace ElementorSliderMember;

define( 'ELEMENTOR_SLIDER_MEMBER', __FILE__ );

/**
 * Include the Elementor_Awesomesauce class.
 */
require plugin_dir_path( ELEMENTOR_SLIDER_MEMBER ) . 'class-elementor-slider-member.php';