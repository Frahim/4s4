<?php
/**
 * Trigger this file on Plugin uninstall
 *
 * @package Custom_Store_Locator
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}
// Clear Database stored data using WordPress functions
$locations = get_posts( array(
    'post_type'   => 'csl_locations',
    'numberposts' => -1,
    'fields'      => 'ids', // Only retrieve post IDs for better performance
) );
foreach ( $locations as $location_id ) {
    // Delete the post and its metadata using WordPress functions
    wp_delete_post( $location_id, true ); // Force delete the post
}
// Delete post meta associated with the 'csl_locations' post type
$meta_keys = get_post_meta( $location_id ); // Get all metadata for the post type
foreach ( $locations as $location_id ) {
    // Delete all associated post meta
    delete_post_meta( $location_id, $meta_keys );
}
// Clean up orphaned term relationships using WordPress functions
foreach ( $locations as $location_id ) {
    // Get associated terms for the post
    $terms = wp_get_post_terms( $location_id, 'csl_locations_categories' );
    foreach ( $terms as $term ) {
        // Remove the term relationship for this post
        wp_remove_object_terms( $location_id, $term->term_id, 'csl_locations_categories' );
    }
}
// Optionally, if you want to delete the custom taxonomy itself:
$taxonomy = 'csl_locations_categories';
$terms = get_terms( array(
    'taxonomy' => $taxonomy,
    'hide_empty' => false,
) );
foreach ( $terms as $term ) {
    // Delete orphaned terms if they no longer have any posts assigned to them
    if ( ! term_has_term( '', $taxonomy, $term->term_id ) ) {
        wp_delete_term( $term->term_id, $taxonomy );
    }
}
return true;