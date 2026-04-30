<?php
/*
Plugin Name: Payment Gateway
Description: Custom Razorpay payment integration
Version: 1.0
Author: Yash saxena
*/
if(!defined('ABSPATH')){
    exit;
}
function payment(){
    ob_start();
?>
<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) . 'style.css'; ?>">
    <form id="payment-form" method="post">
        <label for="name">Your name :</label>
        <input type="text" id="name" name="name" required>
        <br><br>
        <label for="email">Your Email :</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="phone">Your Phone :</label>
        <input type="text" id="phone" name="phone" required>
        <br><br>
        <input type="hidden" name="payment_page_id" value="<?php echo get_the_ID();?>">
        <input type="hidden" id="payment_id" name="payment_id">
        <button type="submit" id="pay_btn">Pay 500</button>
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script src="<?php echo plugin_dir_url(__FILE__) . 'Payment.js'; ?>"></script>
    </form>
    <?php
    return ob_get_clean();
    }
    add_shortcode('payment_form', 'payment');
    register_activation_hook(__FILE__,'Table_Creation');
    function Table_Creation(){
        global $wpdb;
        $Table_Name = $wpdb->prefix . 'payment_records';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "
            CREATE TABLE $Table_Name(
            ID BIGINT(20) NOT NULL AUTO_INCREMENT,
            NAME VARCHAR(255) NOT NULL,
            EMAIL VARCHAR(255) NOT NULL,
            PHONE VARCHAR(20) NOT NULL,
            PAYMENT_ID VARCHAR(255) NOT NULL,
            PAYMENT_PAGE_ID BIGINT(20) NOT NULL,
            AMOUNT INT NOT NULL,
            CREATED_AT DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY(ID)
            ) $charset_collate;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
    }

if(isset($_POST['payment_id']) && !empty($_POST['payment_id'])){
    global $wpdb;
    $table_name = $wpdb->prefix . 'payment_records';

    $wpdb->insert($table_name, array(
        'NAME' => sanitize_text_field($_POST['name']),
        'EMAIL' => sanitize_email($_POST['email']),
        'PHONE' => sanitize_text_field($_POST['phone']),
        'PAYMENT_ID' => sanitize_text_field($_POST['payment_id']),
        'PAYMENT_PAGE_ID' => intval($_POST['payment_page_id']),
        'AMOUNT' => 500
    ));?>
    <script type="text/javascript">
        window.location.href = "<?php echo home_url('/payment-success/'); ?>";
    </script>
    <?php
    exit;
}
?>