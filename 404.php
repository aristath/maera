<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Maera_Timber::get_context();
Timber::render( '404.twig', $context, apply_filters( 'maera/timber/cache', false ) );
