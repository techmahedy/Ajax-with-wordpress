<?php
/**
 * Wordpress ajax functions & definitions
 */

add_action('wp_ajax_my_ajax_action','my_ajax_function'); //my_ajax_action that is action name & need it in data body
add_action('wp_ajax_nopriv_ajax_action','my_ajax_function');

function my_ajax_function(){
   $query = new WP_Query(array(
     'posts_per_page' => 10,
     'post_type' => 'post'
   ));
   
   $html = '<ul>'; //Doing append for getting 10 post. 
   while($query->have_posts()) : $query->the_post();
     $html .= "<li>".get_the_title()."</li>"; //Doing append for getting 10 post otherwise we will get only the last post from this query
   endwhile;

   $html .= '</ul>';

   echo $html;

   wp_reset_query();
   die();
}

function my_shortcode(){
   $html = '
        <button class="my-ajax-trigger">Test</button>
        <div id="info"> </div>
        <script>
            jQuery(document).ready(fucntion($){
                $(".my-ajax-trigger").on("click",function(){

                   $.ajax({
                      url: "'.admin_url('admin-ajax.php').'",
                      type: "POST",
                      data: {
                        action: "my_ajax_action" //Should be same in add_action hook name
                      },
                      success: function(html){
                        $("#info").append(html); // for displaying data in ul 
                      }
                   });

                });
            });
        </script>
   ';
}
add_shortcode( 'ajax_btn', 'my_shortcode' );