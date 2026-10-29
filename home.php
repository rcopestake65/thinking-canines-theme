<?php
/**
 * Blog listing (the posts page).
 *
 * The newest post is featured on the first page; the rest follow in a grid.
 * Category and other post archives use archive.php, which shares the same
 * listing.
 *
 * @package Thinking_Canines
 */

get_header();

$tc_posts_page = (int) get_option( 'page_for_posts' );
$tc_eyebrow    = $tc_posts_page ? tc_field( 'eyebrow', $tc_posts_page ) : '';
$tc_intro      = $tc_posts_page ? tc_field( 'intro', $tc_posts_page ) : '';
$tc_title      = $tc_posts_page ? get_the_title( $tc_posts_page ) : __( 'Blog', 'thinking-canines' );
?>

<main id="primary">

	<section class="page-hero page-hero--xs">
		<div class="page-hero__inner container animate-down">
			<?php if ( $tc_eyebrow ) : ?>
				<p class="eyebrow"><?php echo esc_html( $tc_eyebrow ); ?></p>
			<?php endif; ?>
			<h1 class="page-title"><?php echo esc_html( $tc_title ); ?></h1>
			<?php if ( $tc_intro ) : ?>
				<p class="page-hero__intro"><?php echo esc_html( $tc_intro ); ?></p>
			<?php endif; ?>
			<?php tc_category_pills(); ?>
		</div>
	</section>

	<?php
	if ( have_posts() && ! is_paged() ) :
		the_post();
		?>
		<section class="post-feature">
			<a href="<?php the_permalink(); ?>" class="post-feature__card card animate-up">
				<span class="post-feature__media">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large', array( 'alt' => '', 'sizes' => '(max-width: 900px) 100vw, 680px' ) ); ?>
					<?php else : ?>
						<?php echo tc_icon( 'paw', 0, array( 'class' => 'post-feature__paw' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php endif; ?>
				</span>
				<span class="post-feature__body">
					<span class="post-feature__meta">
						<?php
						/* translators: %s: post date. */
						echo esc_html( sprintf( __( 'Latest post · %s', 'thinking-canines' ), get_the_date() ) );
						?>
					</span>
					<span class="post-feature__title"><?php the_title(); ?></span>
					<span class="post-feature__excerpt"><?php echo esc_html( tc_card_excerpt() ); ?></span>
					<span class="post-feature__more"><?php esc_html_e( 'Read the post', 'thinking-canines' ); ?></span>
				</span>
			</a>
		</section>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/post-list' ); ?>

</main>

<?php
get_footer();
