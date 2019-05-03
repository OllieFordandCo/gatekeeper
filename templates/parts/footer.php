<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Amaranth
 */

?>

</div><!-- #content -->

<footer id="colophon" class="site-footer">
    <div class="site-info">
        <small><?php
        /* translators: 1: Theme name, 2: Theme author. */
        printf( esc_html__( 'Powered by %1$s.', 'amaranth' ), 'Amaranth' );
        ?></small>
    </div><!-- .site-info -->
</footer><!-- #colophon -->
</div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>