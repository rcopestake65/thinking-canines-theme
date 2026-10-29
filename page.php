<?php
/**
 * Default page template (e.g. Privacy Policy, Terms and Conditions).
 *
 * @package Thinking_Canines
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<main id="primary">
		<section class="page-hero page-hero--xs">
			<div class="page-hero__inner container">
				<h1 class="page-title page-title--compact"><?php the_title(); ?></h1>
			</div>
		</section>

		<section class="section section--flush-top">
			<div class="post-body prose">
				<?php the_content(); ?>
			</div>
		</section>
	</main>

	<?php
endwhile;

get_footer();
