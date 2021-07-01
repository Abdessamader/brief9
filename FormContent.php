<?php

/**
 * Plugin Name: Contact_Form
 * Description: Form Example process submit description
 * Version: 1.0.0
 **/

function app_output_buffer()
{
    ob_start();
} // soi_output_buffer
add_action('init', 'app_output_buffer');




wp_register_style('prefix_bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
wp_enqueue_style('prefix_bootstrap');

function contact_form()
{


    $content = "";

    if (isset($_COOKIE["message"])) {
        $content = '<div class="alert alert-success">' . $_COOKIE["message"] . '</div>';
        setcookie(
            "message",
            "",
            time() -2000
        );
    }
    $content .= '<div class="container md-4 w-75">';
    $content .= '<form method="POST" class="d-flex flex-column">';
    $content .= '<label class="mt-4">Name</label>';
    $content .= '<input name="name" type="text" placeholder="name" >';
    $content .= '<label class="mt-4" >Email</label>';
    $content .= '<input name="email" placeholder="email" type = "email"> ';
    $content .= '<label class="mt-4">Comment</label>';
    $content .= '<textarea name="subject" rows="6" cols="30" placeholder="write your subject"> </textarea>';
    $content .= '<button  type="submit"  name="submit" class=" btn btn-outline-dark m-auto mt-4"> submit</button>';
    $content .= '</form> </div>';

    return $content;
}

add_shortcode('form_example', 'contact_form');

global $wpdb;


add_action("admin_menu", "dash");

function dash()
{
    add_menu_page('dash', 'Get MSG', 'manage_options', 'my-menu', 'getData', 'dashicons-align-center', 1);
}

function getData()
{
    require_once 'dashboard.php';
}

function create_table()
{

    $query = "CREATE TABLE contact_form (
      id INT(25) AUTO_INCREMENT PRIMARY KEY ,
      name VARCHAR(50) ,
      email VARCHAR(50),
      subject VARCHAR(50)
    )";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    maybe_create_table('contact_form', $query); // this predefined function  creates a table if it does'nt exists
}


function send()
{
    global $wpdb;

    $wpdb->insert(
        'contact_form',
        array(
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'subject' => $_POST['subject']
        )
    );
    setcookie(
        "message",
        "form successfully sent",
        time() +2000
    );
    wp_redirect($_SERVER['REQUEST_URI']);
    exit();
}
if (isset($_POST['submit'])) {

    add_action("init", 'send');
}

/**
 * Fires after WordPress has finished loading but before any headers are sent.
 *
 */
function action_init(): void
{
}

register_activation_hook(__FILE__, 'create_table');
