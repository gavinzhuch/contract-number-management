<?php /* Template Name: CustomPageT3 */ ?>

<?php get_header(); ?>

<?php get_template_part( 'template-parts/header-image', '' ); ?>

<html lang="en">
<!-- easyTree -->
<head>
    <meta charset="UTF-8">
    <title>Easy Tree Example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../user/css/bootstrap.css">
    <link rel="stylesheet" href="../user/css/easyTree.css">
    <script src="../user/js/bootstrap.js"></script>
    <script src="../user/js/easyTree.js"></script>
</head>


<div id="site-main" class="page-has-frame<?php if ( isset($ilovewp_has_image) && $ilovewp_has_image === TRUE) { echo ' page-has-image'; } ?>">

	<div class="wrapper wrapper-main wrapper-full clearfix">

		<div class="wrapper-frame clearfix">

			<main id="site-content" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

				<div class="site-content-wrapper clearfix">


					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) {
							comments_template();
						}
					?>
          //test
          <?php wp_mail( 'zgavin01@gamil.com', 'The subject', 'The message' ); ?>
					<!-- easy-tree -->
					<div >
					    <!-- <h3 class="text-success">Easy Tree Example</h3> -->
					    <div class="easy-tree">
								<?php
    								global $wpdb;
    								$database_level1 = $wpdb->get_results("SELECT * FROM wp_trevet_relationships WHERE level = 1 ORDER BY wp_trevet_relationships.value ASC");
    								$database_level2 = $wpdb->get_results("SELECT * FROM wp_trevet_relationships WHERE level = 2");

    								if($database_level1)
    								{
    									echo "<ul>";
    									foreach($database_level1 as $cn)
    									{
    										//contract_numbers
    										echo "<li title=".$cn->id.">".$cn->value;

    										if($database_level2)
    										{
    											echo "<ul>";
    											foreach($database_level2 as $ton)
    											{
    												if($ton->parent_id == $cn->id)
    												{
    													//contract_numbers
    													echo "<li title=".$ton->id.">".$ton->value."</li>";
    												}
    											}
    											echo "</ul>";
    										}
    										echo "</li>";
    									}
    									echo "</ul>";
    								}
								 ?>
					    </div>
					</div>

					<script>
					    (function ($) {
					        function init() {
					            $('.easy-tree').EasyTree({
					                addable: true,
					                editable: false,
					                deletable: true
					            });
					        }

					        window.onload = init();
					    })(jQuery)
					</script>




				</div><!-- .site-content-wrapper .clearfix -->

				<?php endwhile; // End of the loop. ?>



			</main><!-- #site-content -->

		</div><!-- .wrapper-frame -->

	</div><!-- .wrapper .wrapper-main -->

</div><!-- #site-main -->

<?php get_footer(); ?>
