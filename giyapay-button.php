<form action="<?php echo esc_attr($form_base_url); ?>/checkout" method="post">
    <input type="hidden" name="merchant_id" value="<?php echo esc_attr($options['merchant_id']); ?>">
    <input type="hidden" name="success_callback" value="<?php echo esc_attr($success_callback); ?>">
    <input type="hidden" name="error_callback" value="<?php echo esc_attr($error_callback); ?>">
    <input type="hidden" name="cancel_callback" value="<?php echo esc_attr($cancel_callback); ?>">
    <input type="hidden" name="amount" value="<?php echo esc_attr($final_amount); ?>">
    <input type="hidden" name="currency" value="<?php echo esc_attr($final_attributes['currency']); ?>">
    <input type="hidden" name="description" value="<?php echo esc_attr($final_attributes['description']); ?>">
    <input type="hidden" name="nonce" value="<?php echo esc_attr($nonce); ?>">
    <input type="hidden" name="timestamp" value="<?php echo esc_attr($time_now); ?>">
    <input type="hidden" name="signature" value="<?php echo esc_attr($signature); ?>">
    <input id="giyapay-button" type="image" id="image" alt="Checkout" src="https://pay.giyapay.com/images/pay-with-giyapay.png">
</form>