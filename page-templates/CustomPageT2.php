<?php /* Template Name: CustomPageT2 */ ?>

<?php get_header(); ?>

<?php get_template_part( 'template-parts/header-image', '' ); ?>


<link rel="stylesheet" href="../user/css/jquery.dataTables.min.css">

<script src="../user/js/jquery.dataTables.min.js"></script>

<div id="site-main" class="page-has-frame<?php if ( isset($ilovewp_has_image) && $ilovewp_has_image === TRUE) { echo ' page-has-image'; } ?>">

	<div class="wrapper wrapper-main wrapper-full clearfix">

		<div class="wrapper-frame clearfix">

			<main id="site-content" class="site-main" role="main">

				<!-- <?php while ( have_posts() ) : the_post(); ?> -->

				<div class="site-content-wrapper clearfix">

					<!-- <?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) {
							comments_template();
						}
					?> -->

					<?php
						$table_col_num = 5;
						$database_DCN_table_name = 'wp_trevet_dcn';
					 ?>


					<table id="example" class="display" cellspacing="0" width="100%">
		        <thead>
		            <tr>
										<?php
												global $wpdb;
												$column_names = $wpdb->get_col( "DESC " . $database_DCN_table_name, 0 );

												for($index = 0; $index < $table_col_num; $index++)
												{
													echo "<th>".$column_names[$index]."</th>";
												}
										?>
		            </tr>
		        </thead>
		        <tfoot>
		            <tr>
		                <?php
												for($index = 0; $index < $table_col_num; $index++)
												{
													echo "<th>".$column_names[$index]."</th>";
												}
										 ?>

		            </tr>
		        </tfoot>

		        <tbody>
							<?php
									global $wpdb;
									$database = $wpdb->get_results("SELECT * FROM $database_DCN_table_name ORDER BY $database_DCN_table_name.DCN ASC");

									if($database)
									{
										foreach ($database as $eachrow) {
											echo "<tr>";
												echo "<td>";
												echo $eachrow->DCN;
												echo "</td>";

												echo "<td>";
												// enum of Version
												switch ($eachrow->Version)
												{
													case 1:
													  echo "Pre-Draft";
													  break;
													case 2:
													  echo "Draft";
													  break;
													case 3:
													  echo "Pre-Final";
													  break;
													case 4:
													  echo "Final";
													  break;
													default:
													  echo "";
												}
												echo "</td>";

												echo "<td>";
												echo $eachrow->Description;
												echo "</td>";

												echo "<td>";
												echo $eachrow->Date;
												echo "</td>";

												echo "<td>";
												echo $eachrow->Contract_number;
												echo "</td>";

											echo "</tr>";
										}
									}
							?>
		        </tbody>
		    	</table>

					<script type='text/javascript'>
						(function ($) {
								function init() {
									$('#example').DataTable( {
										//  "paging":   false,
										 "ordering": true,
										 "info":     true
										//  "searching": true
								 } );
								}

								window.onload = init();
						})(jQuery)
					</script>

				</div><!-- .site-content-wrapper .clearfix -->

				<!-- <?php endwhile; // End of the loop. ?> -->

			</main><!-- #site-content -->

		</div><!-- .wrapper-frame -->

	</div><!-- .wrapper .wrapper-main -->

</div><!-- #site-main -->

<?php get_footer(); ?>
