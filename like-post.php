<?php

function add_ajax_url() {
    echo '<script type="text/javascript">var ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>';
}

add_action('wp_head', 'add_ajax_url');


function likeCount($id){

   $likes = get_post_meta( $id, '_likers', true );

   if(!empty($likes)){
      return count(explode(', ', $likes));
   }else{
      return '0';
   }

}

function unlikeCount($id){

   $unlikes = get_post_meta( $id, 'un_likers', true );

   if(!empty($unlikes)){
      return count(explode(', ', $unlikes));
   }else{
      return '0';
   }

}

add_action('wp_ajax_like_callback', 'like_callback');
add_action('wp_ajax_nopriv_like_callback', 'like_callback');

function like_callback() {

   $id = json_decode($_GET['data']); 
   $feedback = array("likes" => "");

   $currentvalue = get_post_meta( $id, '_likers', true );
   $likes = intval(get_post_meta( $id, '_likes_count', true ));

   $likesarray = explode(', ', $currentvalue);

   if(!empty($currentvalue)){
      $newvalue = $currentvalue .', '. $_SERVER['REMOTE_ADDR'];
   }else{
      $newvalue = $_SERVER['REMOTE_ADDR'];
   }

   if(strpos($currentvalue, $_SERVER['REMOTE_ADDR']) === false){
      $nlikes = $likes + 1;
      if(update_post_meta($id, '_likers', $newvalue, $currentvalue) && update_post_meta($id, '_likes_count', $nlikes, $likes)){
         $feedback = array("likes" => likeCount($id), "status" => true);
      }
   }else{

      $key = array_search($_SERVER['REMOTE_ADDR'], $likesarray);
      unset($likesarray[$key]);
      $nlikes = $likes - 1;

      if(update_post_meta($id, '_likers', implode(", ", $likesarray), $currentvalue) && update_post_meta($id, '_likes_count', $nlikes, $likes)){
         $feedback = array("likes" => likeCount($id), "status" => false);
      }

   }

   echo json_encode($feedback);

   die(); 

}

//unlikes

add_action('wp_ajax_unlike_callback', 'unlike_callback');
add_action('wp_ajax_nopriv_unlike_callback', 'unlike_callback');

function unlike_callback() {

   $id = json_decode($_GET['data']); 
   $feedback = array("unlikes" => "");

   $currentvalue = get_post_meta( $id, 'un_likers', true );
   $unlikes = intval(get_post_meta( $id, 'un_likes_count', true ));

   $unlikesarray = explode(', ', $currentvalue);

   if(!empty($currentvalue)){
      $newvalue = $currentvalue .', '. $_SERVER['REMOTE_ADDR'];
   }else{
      $newvalue = $_SERVER['REMOTE_ADDR'];
   }

   if(strpos($currentvalue, $_SERVER['REMOTE_ADDR']) === false){
      $unnlikes = $unlikes + 1;
      if(update_post_meta($id, 'un_likers', $newvalue, $currentvalue) && update_post_meta($id, 'un_likes_count', $unnlikes, $unlikes)){
         $feedback = array("unlikes" => unlikeCount($id), "status" => true);
      }
   }else{

      $key = array_search($_SERVER['REMOTE_ADDR'], $unlikesarray);
      unset($unlikesarray[$key]);
      $unnlikes = $unlikes - 1;

      if(update_post_meta($id, 'un_likers', implode(", ", $unlikesarray), $currentvalue) && update_post_meta($id, 'un_likes_count', $unnlikes, $unlikes)){
         $feedback = array("unlikes" => unlikeCount($id), "status" => false);
      }

   }

   echo json_encode($feedback);

   die(); 

}
?>