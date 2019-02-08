/* Add Javascript to WordPress */
/* Place in functions.php */


/* Add Javascript to WordPress Head All Pages and Posts */
function wpb_hook_javascript() {
    ?>
        <script>
          // your javscript code goes
        </script>
    <?php
}
add_action('wp_head', 'wpb_hook_javascript');


/* Add Javascript to WordPress Post Head */
function wpb_hook_javascript() {
  if (is_single ('16')) { 
    ?>
        <script type="text/javascript">
          // your javscript code goes here
        </script>
    <?php
  }
}
add_action('wp_head', 'wpb_hook_javascript');

/* Add Javascript to WordPress Page Head */
function wpb_hook_javascript() {
  if (is_page ('10')) { 
    ?>
        <script type="text/javascript">
          // your javscript code goes here
        </script>
    <?php
  }
}
add_action('wp_head', 'wpb_hook_javascript');

/* Add Javascript to WordPress Page Footer */

function wpb_hook_javascript_footer() {
    ?>
        <script>
          // your javscript code goes
        </script>
    <?php
}
add_action('wp_footer', 'wpb_hook_javascript_footer');
