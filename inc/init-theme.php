<?php 
  function bbi2020_cptui_register_my_cpts() {

    /**
     * Post Type: Articles.
     */

    $labels = [
      "name" => __( "Articles", "bbi2020" ),
      "singular_name" => __( "Article", "bbi2020" ),
    ];

    $args = [
      "label" => __( "Articles", "bbi2020" ),
      "labels" => $labels,
      "description" => "",
      "public" => true,
      "publicly_queryable" => true,
      "show_ui" => true,
      "show_in_rest" => true,
      "rest_base" => "",
      "rest_controller_class" => "WP_REST_Posts_Controller",
      "has_archive" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "delete_with_user" => false,
      "exclude_from_search" => false,
      "capability_type" => "post",
      "map_meta_cap" => true,
      "hierarchical" => false,
      "rewrite" => [ "slug" => "article", "with_front" => true ],
      "query_var" => true,
      "supports" => [ "title", "editor", "thumbnail", "revisions" ],
      "taxonomies" => [ "kind", "brand" ],
    ];

    register_post_type( "article", $args );
  }

  add_action( 'init', 'bbi2020_cptui_register_my_cpts' );

  function bbi2020_cptui_register_my_taxes() {

    /**
     * Taxonomy: Types.
     */
  
    $labels = [
      "name" => __( "Types", "bbi2020" ),
      "singular_name" => __( "Type", "bbi2020" ),
    ];
  
    $args = [
      "label" => __( "Types", "bbi2020" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'kind', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "kind",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      ];
    register_taxonomy( "kind", [ "post" ], $args );
  
    /**
     * Taxonomy: Brands.
     */
  
    $labels = [
      "name" => __( "Brands", "bbi2020" ),
      "singular_name" => __( "Brand", "bbi2020" ),
    ];
  
    $args = [
      "label" => __( "Brands", "bbi2020" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'brand', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "brand",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      ];
    register_taxonomy( "brand", [ "post" ], $args );
  }
  add_action( 'init', 'bbi2020_cptui_register_my_taxes' );
  
?>