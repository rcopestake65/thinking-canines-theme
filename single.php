<?php
/**
 * Single blog post.
 *
 * @package Thinking_Canines
 */

get_header();

$tc_posts_page = (int) get_option( 'page_for_posts' );
$tc_blog_url   = $tc_posts_page ? get_permalink( $tc_posts_page ) : home_url( '/' );
$tc_blog_title = $tc_posts_page ? get_the_title( $tc_posts_page ) : __( 'Blog', 'thinking-canines' );

while ( have_posts() ) :
	the_post();
	$tc_related = get_posts( array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'post__not_in'   => array( get_the_ID() ),
		'category__in'   => wp_get_post_categories( get_the_ID() ),
	) );
	?>

	<main id="primary">
		<article <?php post_class(); ?>>

			<header class="page-hero page-hero--xs">
				<div class="post-hero__inner container animate-down">
					<a href="<?php echo esc_url( $tc_blog_url ); ?>" class="post-hero__back">
						<?php echo tc_icon( 'arrow-left', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php
						/* translators: %s: blog page title. */
						echo esc_html( sprintf( __( 'Back to %s', 'thinking-canines' ), $tc_blog_title ) );
						?>
					</a>
					<p class="eyebrow"><?php echo esc_html( tc_post_meta_line() ); ?></p>
					<h1 class="post-hero__title"><?php the_title(); ?></h1>
					<?php if ( has_excerpt() ) : ?>
						<p class="post-hero__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
					<?php endif; ?>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="post-image animate-fade">
					<?php the_post_thumbnail( 'large', array( 'sizes' => '(max-width: 1300px) 100vw, 1240px', 'loading' => 'eager' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="section section--flush-top">
				<div class="post-body prose animate-up">
					<?php the_content(); ?>
				</div>

				<?php
				wp_link_pages( array(
					'before' => '<nav class="pagination post-footer" aria-label="' . esc_attr__( 'Post pages', 'thinking-canines' ) . '"><div class="nav-links">',
					'after'  => '</div></nav>',
				) );
				?>

				<footer class="post-footer">
					<?php if ( has_tag() ) : ?>
						<div class="post-footer__tags">
							<?php foreach ( get_the_tags() as $tc_tag ) : ?>
								<a href="<?php echo esc_url( get_tag_link( $tc_tag ) ); ?>" class="pill pill--sm"><?php echo esc_html( $tc_tag->name ); ?></a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<a href="<?php echo esc_url( $tc_blog_url ); ?>" class="btn btn--outline">
						<?php
						/* translators: %s: blog page title. */
						echo esc_html( sprintf( __( 'More from the %s', 'thinking-canines' ), strtolower( $tc_blog_title ) ) );
						?>
						<?php echo tc_icon( 'arrow', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</footer>
			</div>

		</article>

		<?php if ( $tc_related ) : ?>
			<section class="section section--gold">
				<div class="related container">
					<h2 class="section-title animate-up"><?php esc_html_e( 'Keep reading', 'thinking-canines' ); ?></h2>
					<div class="post-grid">
						<?php
						foreach ( $tc_related as $tc_post ) {
							tc_post_card( $tc_post );
						}
						?>
					</div>
				</div>
			</section>
		<?php endif; ?>
	</main>

	<?php
endwhile;

get_footer();
