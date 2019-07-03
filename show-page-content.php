<?php
/**
 * Wordpress ajax functions & definitions
 */

add_action('wp_ajax_my_ajax_action','my_ajax_function'); //my_ajax_action that is action name & need it in data body
add_action('wp_ajax_nopriv_ajax_action','my_ajax_function');

function my_ajax_function(){
   $query = new WP_Query(array(
     'posts_per_page' => 1,
     'p' => $_POST['page_id_get'],
     'post_type' => 'page'
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
        <button data-id="2" class="my-ajax-trigger">Load page content</button>
        <div id="info"> </div>
        <script>
            jQuery(document).ready(fucntion($){
                $(".my-ajax-trigger").on("click",function(){
                   
                    var page_id = $(this).attr("data-id");

                   $.ajax({
                      url: "'.admin_url('admin-ajax.php').'",
                      type: "POST",
                      data: {
                        action: "my_ajax_action",
                        page_id_get: page_id 
                      },
                      beforeSend: function(){
                        $("#info").empty(); 
                        $("#info").append("Loading ...."); 
                      },
                      success: function(html){
                        $("#info").empty(); 
                        $("#info").append(html); 
                      }
                   });

                });
            });
        </script>
   ';
}
add_shortcode( 'ajax_btn', 'my_shortcode' );