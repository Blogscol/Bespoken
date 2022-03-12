<?php
/**
 * Widgets class.
 *
 * @category   Class
 * @package    ElementorSliderMember
 * @subpackage WordPress
 * @author     Miguel Mariano <miguel@blogscol.com>
 * @copyright  2022 Miguel Mariano
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @since      1.0.0
 * php version 7.0.0
 */

namespace ElementorSliderMember;

use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Slider_Member_Widget extends Widget_Base {

	public static $slug = 'elementor-slider-member';

	public function get_name() { return self::$slug; }

	public function get_title() { return __('Slider Member', self::$slug); }

	public function get_icon() { return 'eicon-slides'; }

	public function get_categories() { return [ 'general' ]; }

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

        add_action('wp_print_styles', array($this, 'add_enqueue_style'));
        add_action('wp_print_scripts', array($this, 'add_enqueue_scripts'), 5 );
	}

    public function add_enqueue_style()
    {
		wp_enqueue_style('swiper-slider-member', plugins_url( '/assets/css/swiper.min.css', __FILE__ ), array(), '1.0.0');

		wp_enqueue_style('elementor-slider-member', plugins_url( '/assets/css/elementor-slider-member.css', __FILE__ ), array(), '1.0.0');
    }

    public function add_enqueue_scripts()
    {
   		wp_register_script('swiper-slider-member', plugins_url('/assets/js/swiper.min.js', __FILE__), array('jquery'), '1.0.0', true);

		wp_enqueue_script('swiper-slider-member');

		wp_register_script('elementor-slider-member', plugins_url('/assets/js/elementor-slider-member.js', __FILE__), array('jquery'), '1.0.0', true);

		wp_enqueue_script('elementor-slider-member');

    }

	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Members', self::$slug ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Use the repeater to define one one set of the items we want to repeat look like
		$repeater = new Repeater();

		$repeater->add_control(
			'member_name',
			[
				'label' => __( 'Name', self::$slug ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( "", self::$slug ),
				'placeholder' => __( '', self::$slug ),
			]
		);

		$repeater->add_control(
			'member_image',
			[
				'label' => esc_html__( 'Choose Image', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'member_description',
			[
				'label' => __( 'Description', self::$slug ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => __( "", self::$slug ),
				'placeholder' => __( '', self::$slug ),
			]
		);

		$repeater->add_control(
			'member_link',
			[
				'label' => __( 'Social Profile', self::$slug ),
				'type' => \Elementor\Controls_Manager::URL,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
					'custom_attributes' => '',
				],
				'placeholder' => __( '', self::$slug ),
			]
		);

		// Add the
		$this->add_control(
			'member_list',
			[
				'label' => __( 'Repeater List', self::$slug ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[]
				],
				'title_field' => 'Member'
			]
		);

		$this->end_controls_section();
	}

    public function strimwidth($text, $start, $width, $trimmarker)
    {
        $decoded = html_entity_decode($text);
        return mb_strimwidth($decoded, $start, $width, $trimmarker);
    }

	protected function render()
	{
		$member_list = $this->get_settings_for_display('member_list');

		$count = count($member_list);

		  switch ($count)
		  {
		    case 1: $class = 'one-cols-images-slider images-slider column-xs-12';
		            break;

		    case 2: $class = 'two-cols-images-slider images-slider two-cols';
		            break;

		    default: $class = 'three-cols-images-slider images-slider three-cols'; 
		             break;
		  }


		?>
		<div class="<?php echo $class; ?>">
            <div class="swiper-container <?php echo ($count == 1) ? '' : 'swiper-images';?>" data-size="<?php echo $count; ?>">
				<?php
					if($count > 1)
					{
				?>
					<div class="swiper-images-navigation">
						<div class="swiper-button-next swiper-images-button-next" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false">
							<img src="<?php echo plugins_url('/elementor-slider-member/assets/images/next-navigation.png') ?>">
						</div>
						<div class="swiper-button-prev swiper-images-button-prev" tabindex="0" role="button" aria-label="Previous slide" aria-disabled="false">
							<img src="<?php echo plugins_url('/elementor-slider-member/assets/images/prev-navigation.png') ?>">
						</div>
					</div>
				<?php
                	}
              	?>
				<div class="swiper-wrapper">
	                <?php
						foreach ($member_list as $member_item)
						{
							$link = $member_item['member_link'];
							$image = $member_item['member_image'];
							$name = $member_item['member_name'];
							$description = $this->strimwidth($member_item['member_description'], 0, 100, "...");
							?>
							<div class="swiper-slide">
								<a href="<?php echo $link['url']; ?>" class="text-black">
									<div class="image">
										<img src="<?php echo $image['url']; ?>">
										<div class="texto">
											<div class="title">
												<?php echo $name ?>
											</div>
											<div class="subtitle">
												<?php echo $description ?>
											</div>
										</div>
									</div>
								</a>
							</div>
					<?php
						}
	                ?>
              	</div>
            </div>
        </div>
		<?php
	}
}