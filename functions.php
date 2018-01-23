<?php
/*
 Theme Name:	Brasa 2018
 Theme URI:		http://brasa.art.br
 Description:	Brasa 2018 - Tema filho do Tema Coletivo
 Author:		Matheus Gimenez
 Author URI:	http://brasa.art.br
 Template:		tema-coletivo
 Version:		0.1alpha
 License:		GNU General Public License v2 or later
 License URI:	http://www.gnu.org/licenses/gpl-2.0.html
 Text Domain:	brasa2018
*/

/**
 * Load site scripts.
 *
 * @since 2.2.0
 */
function brasa2018_enqueue_scripts() {
	$template_url = get_stylesheet_directory_uri();


	// Loads Brasa2018 CSS file
	wp_enqueue_style( 'brasa2018-sourcesans', 'https://fonts.googleapis.com/css?family=Source+Sans+Pro', array(), null, 'all' );
	wp_enqueue_style( 'brasa2018-css', $template_url . '/brasa2018.css', array(), null, 'all' );

	// Loads Brasa2018 JS file
	//wp_enqueue_script( 'brasa2018-js', $template_url . '/brasa2018.js', array(), null, true );
}

add_action( 'wp_footer', 'brasa2018_enqueue_scripts', 1 );

/**
 * Página de equipe
 */
// Register Custom Post Type
function custom_post_type() {

	$labels = array(
		'name'                => _x( 'Equipe', 'Post Type General Name', 'tema-brasa' ),
		'singular_name'       => _x( 'Equipe', 'Post Type Singular Name', 'tema-brasa' ),
		'menu_name'           => __( 'Equipe', 'tema-brasa' ),
		'parent_item_colon'   => __( 'Item parente', 'tema-brasa' ),
		'all_items'           => __( 'Todos membros', 'tema-brasa' ),
		'view_item'           => __( 'Ver membro', 'tema-brasa' ),
		'add_new_item'        => __( 'Adicionar novo membro', 'tema-brasa' ),
		'add_new'             => __( 'Adicionar novo', 'tema-brasa' ),
		'edit_item'           => __( 'Editar item', 'tema-brasa' ),
		'update_item'         => __( 'Atualizar item', 'tema-brasa' ),
		'search_items'        => __( 'Buscar membro', 'tema-brasa' ),
		'not_found'           => __( 'Não encontrado', 'tema-brasa' ),
		'not_found_in_trash'  => __( 'Não encontrado na lixeira', 'tema-brasa' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-groups',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'equipe', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type', 0 );

if (!function_exists('get_field')) {
  function get_field($field) {
  	global $post;
  	return get_post_meta($post->ID, $field, true);
  }
}
if (!function_exists('the_field')) {
  function the_field($field) {
  	global $post;
  	echo get_field($field);
  }
}
function team_query( $query ) {
    if ( is_post_type_archive('equipe') ) {
        $query->set( 'orderby', 'rand' );
        return;
    }
}
add_action( 'pre_get_posts', 'team_query' );

require get_template_directory() . '/inc/class-metabox.php';
$team_metabox = new Odin_Metabox(
	'team_metabox', // Slug/ID do Metabox (obrigatório)
	'Team', // Nome do Metabox  (obrigatório)
	'equipe', // Slug do Post Type, sendo possível enviar apenas um valor ou um array com vários (opcional)
	'normal', // Contexto (opções: normal, advanced, ou side) (opcional)
	'high' // Prioridade (opções: high, core, default ou low) (opcional)
);
$team_metabox->set_fields(
	array(
		array(
			'id'          => 'team_position',
			'label'       => 'Cargo',
			'type'        => 'text',
			'description' => ''
		),
		array(
			'id'          => 'team_phone',
			'label'       => 'Telefone',
			'type'        => 'text',
			'description' => ''
		),
		array(
			'id'          => 'team_email',
			'label'       => 'E-mail',
			'type'        => 'text',
			'description' => ''
		),
		array(
			'id'          => 'team_twitter',
			'label'       => 'Twitter URL',
			'type'        => 'text',
			'description' => ''
		),
		array(
			'id'          => 'team_linkedin',
			'label'       => 'Linkedin URL',
			'type'        => 'text',
			'description' => ''
		),
		array(
			'id'          => 'team_github',
			'label'       => 'Github URL',
			'type'        => 'text',
			'description' => ''
		),
		array(
			'id'          => 'team_wporg',
			'label'       => __('URL da Conta no WordPress.org','tema-brasa'),
			'type'        => 'text',
			'description' => ''
		),
	)
);
