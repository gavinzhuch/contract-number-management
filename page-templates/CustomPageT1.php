<?php /* Template Name: CustomPageT1 */ ?>

<?php if (function_exists('get_header'))
			{
				get_header();
			}
			else{
				exit;
			}
?>

<?php get_template_part( 'template-parts/header-image', '' ); ?>

<script type="text/javascript">
	jQuery(function ($) {
	    $('#field1').on('change', function() {

					$.ajax({
			        url: '../user/php/edit-database.php',
			        type: 'GET',
			        dataType: "json",
			        data: {
			            field1: $('#field1').val(),
									status:3
			        }
			    }).done(function(data){
							var $el = $("#field2");
							$el.empty(); // remove old options
							for(i = 0; i < data.length; i++)
							{
									$el.append($("<option></option>")
							     .attr("value", data[i].id).text( data[i].value));
							}

			    });

	    });
	});

	function validateForm() {
	    var check7 = document.forms["myForm"]["field7"].value;
	    if (check7 == "") {
	        alert("Email must be filled out");
	        return false;
	    }
			var check5 = document.forms["myForm"]["field5"].value;
	    if (check5 == "") {
	        alert("Date must be filled out");
	        return false;
	    }
	}
</script>


<link rel="stylesheet" href="../user/css/CustomPageT1.css">


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

					<form name="myForm" action="../user/php/edit-database.php" onsubmit="return validateForm()" >
						<ul class="form-style-1">
							<li><!-- contract_numbers -->
								<label>Contract Number <span class="required">*</span></label>
								<select name="field1" id="field1" class="field-select">
									<?php
											global $wpdb;
											$contract_numbers = $wpdb->get_col("SELECT * FROM wp_trevet_relationships WHERE level = 1 order by value asc",1);
											$contract_numbers_id = $wpdb->get_col("SELECT * FROM wp_trevet_relationships WHERE level = 1 order by value asc",0);

											if ($contract_numbers && $contract_numbers_id) {
												$choosed_contract_numbers_id = $contract_numbers_id[0];
												$i=0;
												while(count($contract_numbers)==count($contract_numbers_id) && $i < count($contract_numbers))
												{
														echo "<option value=".$contract_numbers_id[$i].">".$contract_numbers[$i]."</option>";
														$i++;
												}
											 }
									 ?>
								</select>
							</li>
							<li>
								<label>Task Order Number <span class="required">*</span></label>
								<select id="field2" name="field2" class="field-select">
									<?php
											global $wpdb;
											$choosed_ids = $choosed_contract_numbers_id.'-%';
											$task_order_rows = $wpdb->get_results("SELECT * FROM wp_trevet_relationships WHERE level = 2 AND track_id like '$choosed_ids'");

											if ($task_order_rows) {
													foreach ($task_order_rows as $task_order_row) {
															echo "<option value=".$task_order_row->id.">".$task_order_row->value."</option>";
												 	}
											 }
									 ?>
								</select>
							</li>
							<li>
								<label>Document Description </label>
								<textarea name="field3" id="field3" class="field-long field-textarea"></textarea>
							</li>
							<li>
								<label>Document Verison <span class="required">*</span></label>
								<select name="field4" class="field-select">
									<option value="1">Pre-Draft</option>
									<option value="2">Draft</option>
									<option value="3">Pre-Final</option>
									<option value="4">Final</option>
								</select>
							</li>
							<li>
								<label>Document Date <span class="required">*</span></label>
								<input type="date" name="field5" class="field-long" />
							</li>
							<li>
								<label>Email <span class="required">*</span></label>
								<input type="email" name="field7" class="field-long" />

							</li>
							<li>
								<input type="submit" value="Submit" />
							</li>
						</ul>
					</form>
				</div><!-- .site-content-wrapper .clearfix -->

				<!-- <?php endwhile; // End of the loop. ?> -->

			</main><!-- #site-content -->

		</div><!-- .wrapper-frame -->

	</div><!-- .wrapper .wrapper-main -->

</div><!-- #site-main -->

<?php get_footer(); ?>
