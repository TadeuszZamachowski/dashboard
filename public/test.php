<?php

$db = new PDO('mysql:host=localhost;dbname=byronba3_wpdb', 'user_1', 'password');

$sql = 'select p.ID as order_id, p.post_date, max( CASE WHEN pm.meta_key = \'_billing_email\' and p.ID = pm.post_id THEN pm.meta_value END ) as billing_email, max( CASE WHEN pm.meta_key = \'_billing_first_name\' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_first_name, max( CASE WHEN pm.meta_key = \'_billing_last_name\' and p.ID = pm.post_id THEN pm.meta_value END ) as _billing_last_name, max( CASE WHEN im.meta_key = \'Start Date and Time\' and oi.order_item_id = im.order_item_id THEN im.meta_value END ) as start_date_and_time, oi.order_item_name as name from wp_posts p join wp_postmeta pm on p.ID = pm.post_id join wp_woocommerce_order_items oi on p.ID = oi.order_id join wp_woocommerce_order_itemmeta im on oi.order_item_id = im.order_item_id where post_type = :shop_order and post_status != \'wc-completed\' group by p.ID order BY p.post_date DESC;';
$select = $db->prepare($sql);
$shop_order = 'shop_order';
$select->bindParam(':shop_order', $shop_order, PDO::PARAM_INT);
$select->execute();
$result = $select->fetchAll(PDO::FETCH_ASSOC);

//foreach()