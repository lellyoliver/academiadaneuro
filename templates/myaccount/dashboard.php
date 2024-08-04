<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$user = wp_get_current_user();
$user_name = $user->first_name;
$allowed_roles_3 = ['training', 'administrator', 'coach'];
$data = get_user_meta($current_user_id, 'connected_user', true);
$billing_phone = get_user_meta($data, 'billing_phone', true);
$profissional = get_userdata($data);
?>
<h6>Olá, <?php echo esc_html($user_name); ?></h6>
   <p>A partir do painel de controle de sua conta, você pode ver suas <a href="<?php echo esc_url( wc_get_endpoint_url( 'orders' ) ); ?>">compras recentes</a>.</p>
   <?php if (array_intersect($allowed_roles_3, $user->roles)): ?>
                        <div class="mb-3"></div>
                        <span>
                            <?php if ($userExpireds[0]):
                                setlocale(LC_TIME, 'pt_BR.utf8'); // Define o local para o português do Brasil
                                $expiration_date = strtotime($userExpireds[0]->expiration_date);
                                $formatted_date = strftime('%d de %B de %Y', $expiration_date);
                                $order_data = wc_get_order($userExpireds[0]->order_id);
                                $total_price = $order_data->get_total();
                                ?>
                            <p><i class="fa-solid fa-money-check-dollar"></i>
                                <b><?php echo wc_price($total_price); ?></b>
                                <br>
                                Próximo pagamento em<br> <b><?php echo $formatted_date; ?></b><br>
                            </p>
                            <?php endif;?>
                        </span>
                        <div class="mb-3"></div>
                        <button class="btn btn-sm btn-outline-secondary" data-bs-target="#cartUserRelated"
                            data-bs-toggle="offcanvas"><i class="fa-solid fa-credit-card"></i> Renovar Plano</button>
                        <?php
                        if ($expireds[0]['status']) {
                            echo '<span data-bs-toggle="tooltip" data-bs-placement="right" title="ativo" class="color-success"><i class="fa-solid fa-circle-check"></i> Seu plano está ativo</span>';
                        } else {
                            echo '<span data-bs-toggle="tooltip" data-bs-placement="right" title="inativo" class="color-danger"><i class="fa-solid fa-triangle-exclamation"></i> Seu plano está inativo</span>';
                        }
                        ?>
                        <div class="mb-3"></div>
                    <?php endif;?>
					<?php if (array_intersect($allowed_roles_1, $current_user->roles)): ?>

								<h6 class="card-title fw-bold title-cards text-uppercase">
									<?php echo esc_html('Sua Assinatura'); ?>
								</h6>
								<div class="mb-3"></div>
								<p><b>Sua assinatura é compartilhada com seu(a) profissional: <?php echo $profissional->display_name; ?></b>
									<?php
									if ($expireds[0]['status']) {
										echo '<span data-bs-toggle="tooltip" data-bs-placement="right" title="ativo" class="color-success"><i class="fa-solid fa-circle-check"></i></span>';
									} else {
										echo '<span data-bs-toggle="tooltip" data-bs-placement="right" title="inativo" class="color-danger"><i class="fa-solid fa-triangle-exclamation"></i></span>';
									}
									?>
								</p>
								<p>Qualquer dúvida sobre seu plano converse com seu profissional!</p>
								<p><a href="https://wa.me/+55<?php echo $billing_phone; ?>" class="btn btn-sm btn-outline-secondary"
										target="_blank"><i class="fa-brands fa-whatsapp"></i> <?php echo $billing_phone; ?></a></p>
						
					<?php endif;?>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
