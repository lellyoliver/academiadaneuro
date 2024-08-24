<?php
echo '<table class="table-responsive"><tbody>';
if (!empty($orders)) {
    foreach ($orders as $order) {
        $order_id = $order->get_id();
        $items = $order->get_items();

        foreach ($items as $item) {
            $product_name = $item->get_name();
            echo '<tr><td>' . $product_name . '<button class="btn btn-sm btn-primary ms-2 refund-button" data-order-id="' . $order_id . '">Reembolso</button></td></tr>';
        }
    }
}else{
    echo '<tr><td class="text-center">Não nenhuma ordem para reembolso.</td></tr>';
}
echo '</tbody></table>';
