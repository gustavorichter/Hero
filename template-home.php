<?php

/*
Template Name: Home Page
*/

get_header(); ?>

<div class="content-area">
	<main>
		<section class="slider">
			<div class="container-fluid remov-padding">
				<div class="swiper mySwiper">
					<div class="swiper-wrapper">
						<div class="swiper-slide"><img src="<?php echo get_theme_mod('first_slide') ?>" height="" width=""></div>
						<div class="swiper-slide"><img src="<?php echo get_theme_mod('second_slide') ?>" height="" width=""></div>
						<div class="swiper-slide"><img src="<?php echo get_theme_mod('third_slide') ?>" height="" width=""></div>
					</div>
					<div class="swiper-pagination"></div>
				</div>			  
			</div>
		</section>

		<?php 
		/*----------------------------------------------------------------------------------------------*/
		// We'll only show these sections if WooCommerce is ative
		if( class_exists( 'WooCommerce' ) ):
		?>
			<section class="popular-products">
				<?php 

				// Getting data from Customizer to display the Popular Products section
				$popular_limit 		= get_theme_mod( 'set_popular_max_num', 4 );
				$popular_col 		= get_theme_mod( 'set_popular_max_col', 4 );
				$arrivals_limit 	= get_theme_mod( 'set_new_arrivals_max_num', 4 );
				$arrivals_col 		= get_theme_mod( 'set_new_arrivals_max_col', 4 );					

				?>
				<div class="container">
					<div class="section-title">
						<h2><?php echo esc_html( get_theme_mod( 'set_popular_title', __( 'Popular products', 'fancy-lab' ) ) ); ?></h2>
					</div>
					<?php 
					echo do_shortcode( '[products limit=" ' . esc_attr( $popular_limit ) . ' " columns=" ' . esc_attr( $popular_col ) . ' " orderby="popularity" ]' );
					?>
				</div>
			</section>
			<section class="new-arrivals">
				<div class="container">
					<div class="section-title">
						<h2><?php echo esc_html( get_theme_mod( 'set_new_arrivals_title', __( 'New Arrivals', 'fancy-lab' ) ) ); ?></h2>
					</div>
					<?php 
					echo do_shortcode( '[products limit=" ' . esc_attr( $arrivals_limit ) . ' " columns=" ' . esc_attr( $arrivals_col ) . ' " orderby="date" visibility="visible" ]' ); 
					?>							
				</div>
			</section>

			<?php

			// Getting data from Customizer to display the Deal of the Week section
			$showdeal 				= get_theme_mod( 'set_deal_show', 0 );
			$deal 					= get_theme_mod( 'set_deal' ); 
			$currency 				= get_woocommerce_currency_symbol();
			$regular 				= get_post_meta( $deal, '_regular_price', true);
			$sale 					= get_post_meta( $deal, '_sale_price', true);
			
			// We'll only show this section if the user chooses to do so and if some deal product is set
			if( $showdeal == 1 && ( !empty( $deal )) ):
				$discount_percentage 	= absint( 100 - ( ( $sale/$regular ) * 100) );
			?>
				<section class="deal-of-the-week woocommerce">
					<div class="container">
						<div class="section-title">
							<h2><?php echo esc_html( get_theme_mod( 'set_deal_title', __( 'Deal of the Week', 'fancy-lab' ) ) ); ?></h2>
						</div>
						<div class="row d-flex align-items-center">
							<div class="deal-img col-md-6 col-12 ml-auto text-center">
									<?php echo get_the_post_thumbnail( $deal, 'large', array( 'class' => 'img-fluid' ) ); ?>
							</div>
							<div class="deal-desc col-md-4 col-12 mr-auto text-center">
								<?php if( !empty( $sale ) ): ?>
									<span class="discount">
										<?php echo esc_html( $discount_percentage ); ?><?php esc_html_e( '% OFF', 'fancy-lab' ) ?>
									</span>
								<?php endif; ?>
								<h3>
									<a href="<?php echo esc_url( get_permalink( $deal ) ) ?>"><?php echo esc_html( get_the_title( $deal ) );?></a>
								</h3>
								<p><?php echo esc_html( get_the_excerpt( $deal ) );?></p>
								<div class="prices">
									<span class="regular">
										<?php 
										echo esc_html( $currency ); 
										echo esc_html( $regular ); 
										?>
									</span>
									<?php if( !empty( $sale ) ): ?>
										<span class="sale">
											<?php 
											echo esc_html( $currency );
											echo esc_html( $sale ); 
											?>
										</span>
									<?php endif; ?>
								</div>
								<a href="<?php echo esc_url( '?add-to-cart=' . $deal ); ?>" class="add-to-cart"><?php esc_html_e( 'Add to Cart', 'fancy-lab' ) ?></a>	
							</div>
						</div>
					</div>
				</section>
			<?php endif; ?><!-- End $showdeal/$deal verification -->

		<?php endif; ?>
		<!---------------------------------------------------------------------------------------------->
		<!-- End class_exists for WooCommerce -->

		<section class="lab-blog">
			<div class="container">
				<div class="section-title">
					<h2><?php echo esc_html( get_theme_mod( 'set_blog_title', __( 'News From Our Blog', 'fancy-lab' ) ) ); ?></h2>
				</div>
				<div class="row">
					<?php
					$args = array(
						'post_type' 			=> 'post',
						'posts_per_page' 		=> 2,
						'ignore_sticky_posts' 	=> true,
					); 

					$blog_posts = new WP_Query( $args );

					if( $blog_posts->have_posts() ):
						while( $blog_posts->have_posts() ): $blog_posts->the_post();
					?>
						<article class="col-12 col-md-6">
							<a href="<?php the_permalink() ?>">
							<?php 
							if( has_post_thumbnail() ):
								the_post_thumbnail( 'fancy-lab-blog' , array( 'class' => 'img-fluid') );
							endif;
							?>
							</a>
							<h3>
								<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
							</h3>
							<span class="pub-date">
								<a href="<?php the_permalink() ?>"><?php echo esc_html( get_the_date() ); ?></a>
							</span>
							<div class="excerpt">
								<?php the_excerpt(); ?>
							</div>
						</article>

					<?php
						endwhile;
						wp_reset_postdata();
						else: 
					?>
						<p><?php esc_html_e( 'Nothing to display', 'fancy-lab' ) ?></p>
					<?php endif; ?>
				</div>
			</div>
		</section>											
	</main>
</div>
<!-- Initialize Swiper -->
<script>	
	var swiper = new Swiper(".mySwiper", {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
          delay: 4000,
          disableOnInteraction: false,
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      });
</script>
<?php get_footer(); ?>