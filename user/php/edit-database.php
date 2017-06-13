<?php
 require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php' );
 require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-includes/wp-db.php' );
 global $wpdb;

?>
<?php
 //0: save new DSN and send email----call by CustomPageT1.php
 //1:add----call by easyTree.js
 //2:delete----call by easyTree.js
 //3:get data(page1)----call by CustomPageT1.php
 $status = (isset($_GET['status'])) ? $_GET['status'] : 0;

 //call by CustomPageT1.php
 //submit action
 if($status == 0)
 {
   $f1 = (isset($_GET['field1'])) ? $_GET['field1'] : 0;
   $f2 = (isset($_GET['field2'])) ? $_GET['field2'] : 0;
   $f3 = (isset($_GET['field3'])) ? $_GET['field3'] : 0;
   $f4 = (isset($_GET['field4'])) ? $_GET['field4'] : 0;
   $f5 = (isset($_GET['field5'])) ? $_GET['field5'] : 0;
   $f6 = (isset($_GET['field6'])) ? $_GET['field6'] : 0;
   $f7 = (isset($_GET['field7'])) ? $_GET['field7'] : 0;


  //get the track_id like
  $track_sample = '%'.$f1.'-'.$f2.'-%%';
  // echo json_encode($track_sample);
  //count dsn number in this contract_numbers and task_order_number
  $curr_dsn = $wpdb->get_results("SELECT * FROM wp_trevet_relationships WHERE level = 3 AND track_id like '$track_sample' ");
   $curr_dsn_number = count($curr_dsn);
   // echo json_encode($curr_dsn_number);

  //get last 4 number of the contract number
   $curr_contract_num = $wpdb->get_col("SELECT * FROM wp_trevet_relationships WHERE id = $f1",1);
   $short_contract_num = substr($curr_contract_num[0], -4);
   // echo json_encode($short_contract_num);
   //get current task order number
   $curr_task_num = $wpdb->get_col("SELECT * FROM wp_trevet_relationships WHERE id = $f2",1);
    // echo json_encode($curr_task_num[0]);

  $new_dsn_last4 = str_pad($curr_dsn_number+1, 4, '0', STR_PAD_LEFT);
  // echo json_encode($new_dsn_last4);

  //combine the new dsn number
  $new_dsn = 'TRVT-'.$short_contract_num.'-'.$curr_task_num[0].'-'.$new_dsn_last4;


  //get next id
  $get_id = $wpdb->get_row("SHOW TABLE STATUS LIKE 'wp_trevet_relationships'");
  $next_id = $get_id->Auto_increment;


  //save option in database of wp_trevet_relationships
  $wpdb->insert(
    'wp_trevet_relationships',
    array(
  		'id' => null,
  		'value' => $new_dsn,
      'parent_id' => $f2,
  		'track_id' => $f1.'-'.$f2.'-'.$next_id,
      'level' => '3'
  	),
  	array(
      '%d',
  		'%s',
  		'%d',
      '%s',
      '%d'
  	)
  );

  ////save option in database of wp_trevet_dcn
  $wpdb->insert(
    'wp_trevet_dcn',
    array(
  		'DCN' => $new_dsn,
  		'Version' => $f4,
      'Description' => $f3,
  		'Date' => $f5,
      'Contract_number' => $curr_contract_num[0],
      'Email' => $f7
      // 'Task_Order_Number' => $curr_task_num[0],

  	),
  	array(
      '%s',
  		'%d',
  		'%s',
      '%s',
      '%s',
      '%s'
  	)
  );


//send Email


//
  echo "Your New DSN has been sent to your Email: ".$f7."</br></br>";
  echo "[TEST]Your New DSN is ".$new_dsn."</br></br>";
  echo "<a href='javascript:history.go(-1);'>Back</a>";

    //
 }

//call by easyTree.js
//add new node in the tree
elseif($status == 1)
{
  $f1 = (isset($_GET['value'])) ? $_GET['value'] : 0;
  $f2 = (isset($_GET['parent_id'])) ? $_GET['parent_id'] : 0;
  $f3 = (isset($_GET['level'])) ? $_GET['level'] : 0;
  $get_id = $wpdb->get_row("SHOW TABLE STATUS LIKE 'wp_trevet_relationships'");
  $next_id = $get_id->Auto_increment;

 //return the next id
  echo json_encode($next_id);

 //save option in database of wp_trevet_relationships
  if($f3==1)
  {
    $track_id = $next_id;
  }
  else
  {
    $track_id = $f2.'-'.$next_id;
  }
  $wpdb->insert(
    'wp_trevet_relationships',

    array(
      'id' => $next_id,
      'value' => $f1,
      'parent_id' => $f2,
      'track_id' => $track_id,
      'level' => $f3
    ),

    array(
      '%d',
      '%s',
      '%d',
      '%s',
      '%d'
      )
    );
}

//call by easyTree.js
//delete new node in the tree
elseif($status == 2)
{
  $title = (isset($_GET['title'])) ? $_GET['title'] : 0;
  echo json_encode($title);
  $wpdb->delete( 'wp_trevet_relationships', array( 'id' => $title ) );
  $wpdb->delete( 'wp_trevet_relationships', array( 'parent_id' => $title ) );
}

//call by CustomPageT1.php
//get new contract_numbers 's task_number
elseif($status == 3)
{
  $bigid = (isset($_GET['field1'])) ? $_GET['field1'] : 0;
  $bigid2 = $bigid.'-%';
  $task_order = $wpdb->get_results("SELECT * FROM wp_trevet_relationships WHERE level = 2 AND track_id like '$bigid2' ");
  echo json_encode($task_order);
}


?>
