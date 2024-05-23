<?php
class Custom_Nav_Menu_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'custom-nav-menu';
	}

	public function get_title() {
		return __('Custom Nav Menu', 'custom-nav-menu-widget');
	}

	public function get_icon() {
		return 'fa fa-bars';
	}

	public function get_categories() {
		return ['basic']; // Replace 'custom-category' with your desired widget category
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __('Content', 'custom-nav-menu-widget'),
			]
		);

		$this->add_control(
			'selected_menu',
			[
				'label'    => __('Select Menu', 'custom-nav-menu-widget'),
				'type'     => \Elementor\Controls_Manager::SELECT,
				'options'  => $this->get_menus(),
				'default'  => '0', // Default to the first menu
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => __('Background Color', 'custom-nav-menu-widget'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .custom-nav-menu' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'text_color',
			[
				'label'     => __('Color', 'custom-nav-menu-widget'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .custom-nav-menu li > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'icon_typography',
				'selectors' => [
					'{{WRAPPER}} .custom-nav-menu' => '{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'list_style',
			[
				'label'     => __('List Style', 'custom-nav-menu-widget'),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => [
					''            => __('Default', 'custom-nav-menu-widget'),
					'none'        => __('None', 'custom-nav-menu-widget'),
					'disc'        => __('Disc', 'custom-nav-menu-widget'),
					'circle'      => __('Circle', 'custom-nav-menu-widget'),
					'square'      => __('Square', 'custom-nav-menu-widget'),
				],
				'selectors' => [
					'{{WRAPPER}} .custom-nav-menu ul' => 'list-style-type: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'text-align',
			[
				'label' => esc_html__( 'Menu Alignment', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'textdomain' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'textdomain' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'textdomain' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .custom-nav-menu ul' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'li_margin',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Margin', 'textdomain' ),
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .custom-nav-menu li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		

		$this->add_control(
			'list_display',
			[
				'label'   => __('List Display', 'custom-nav-menu-widget'),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					''            => __('Default', 'custom-nav-menu-widget'),
					'block'       => __('Block', 'custom-nav-menu-widget'),
					'inline'      => __('Inline', 'custom-nav-menu-widget'),
					'inline-block' => __('Inline Block', 'custom-nav-menu-widget'),
					'flex'        => __('Flex', 'custom-nav-menu-widget'),
				],
				'selectors' => [
					'{{WRAPPER}} .custom-nav-menu li' => 'display: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_effect',
			[
				'label'     => __('Hover Effect', 'custom-nav-menu-widget'),
				'type'      => \Elementor\Controls_Manager::HOVER_ANIMATION,
				'selectors' => [
					'{{WRAPPER}} .custom-nav-menu a' => '{{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .custom-nav-menu li',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		// Check if a menu is selected
		if (isset($settings['selected_menu']) && $settings['selected_menu'] !== '0') {
			// Output the menu with styles
			echo '<div class="custom-nav-menu">';
			wp_nav_menu(array('menu' => $settings['selected_menu']));
			echo '</div>';
		}
	}

	// Helper function to get all menus for the control
	private function get_menus() {
		$menus = array('0' => __('Select a menu', 'custom-nav-menu-widget')); // Default option

		$locations = get_nav_menu_locations();

		foreach ($locations as $location => $menu_id) {
			$menu         = wp_get_nav_menu_object($menu_id);
			$menus[$menu->slug] = $menu->name;
		}

		return $menus;
	}
	
}