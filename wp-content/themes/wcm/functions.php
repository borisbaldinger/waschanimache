<?
// Custom Taxonomy Code
add_action( 'init', 'build_taxonomies', 0 );
function build_taxonomies() {
  register_taxonomy( 'age', 'post', array( 'hierarchical' => true, 'label' => 'Alter', 'query_var' => true, 'rewrite' => true ) );
  register_taxonomy( 'gender', 'post', array( 'hierarchical' => true, 'label' => 'Geschlecht', 'query_var' => true, 'rewrite' => true ) );
  register_taxonomy( 'parent', 'post', array( 'hierarchical' => true, 'label' => 'Elternteil(e)', 'query_var' => true, 'rewrite' => true ) );
  register_taxonomy( 'region', 'post', array( 'hierarchical' => true, 'label' => 'Region', 'query_var' => true, 'rewrite' => true ) );
  register_taxonomy( 'season', 'post', array( 'hierarchical' => true, 'label' => 'Jahreszeit', 'query_var' => true, 'rewrite' => true ) );
  register_taxonomy( 'location', 'post', array( 'hierarchical' => true, 'label' => 'Lokalität', 'query_var' => true, 'rewrite' => true ) );
}
