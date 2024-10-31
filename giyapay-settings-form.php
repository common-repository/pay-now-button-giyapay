<form method="post" action="<?php echo esc_attr($_SERVER["REQUEST_URI"]); ?>">
    <div class="settings-container">
        <h1 id="giyapay-settings-title">GiyaPay Pay Now Button Settings</h1>
        <div class="giyapay-settings-section">
            <div class="giyapay-settings-section-title">About the Plugin</div>
            <div class="giyapay-settings-section-content">
                <p>Simplify your payment solutions in one simple step. <a href="https://www.wrike.com/form/eyJhY2NvdW50SWQiOjQ1ODAyMTIsInRhc2tGb3JtSWQiOjcyMjc2NH0JNDgxNTAwNDgyNDUyMgliZGUyNDI5MjM5NzM1MDM4NmIzZjE5MmQwNjRkYmMwNmZkZjBkYjVhOWNlNGFhYjJkNjIwMDEwNDFjZWRiMWUx" target="_blank"><strong>Sign up with GiyaPay now!</strong></a></p>
            </div>
        </div>
        <div class="giyapay-settings-section">
            <div class="giyapay-settings-section-title">Account Settings</div>
            <div class="giyapay-settings-section-content">
                <div class="giyapay-settings-field">
                    <div class="giyapay-settings-field-label">
                        <label for="merchant_id">Merchant ID</label>
                    </div>
                    <input type="text" name="merchant_id" value="<?php echo esc_attr($value['merchant_id']) ?>" />
                </div>
                <div class="giyapay-settings-field">
                    <div class="giyapay-settings-field-label">
                        <label for="api_key">API Key</label>
                    </div>
                    <input class="giyapay-long-field" type="text" name="api_key" value="<?php echo esc_attr($value['api_key'])  ?>" />
                    <div class="giyapay-break"></div>
                    <span class="giyapay-field-help-text">This is also called your secret key</span>
                </div>
            </div>
        </div>
        <div class="giyapay-settings-section">
            <div class="giyapay-settings-section-title">Callback Settings</div>
            <div class="giyapay-settings-section-content">
                <p>Callbacks are basically URLs where your customers will be redirected after transacting with GiyaPay's hosted checkout. Depending on the payment status or user interaction, they will be redirected to the callback URLs specified below.</p>
                <p><strong>NOTE: Omitting the full URL path will identify URLs within your current WordPress website. (ex. /success goes to <a href="<?php echo get_bloginfo('url') . '/success'; ?>"><?php echo get_bloginfo('url') . '/success'; ?></a> after a successful payment)</strong></p>
                <div class="giyapay-settings-field">
                    <div class="giyapay-settings-field-label">
                        <label for="success_callback">Success Callback</label>
                    </div>
                    <input class="giyapay-long-field" type="text" name="success_callback" value="<?php echo esc_attr($value['success_callback']) ?>"/>
                    <div class="giyapay-break"></div>
                    <span class="giyapay-field-help-text">This is where your customers will be redirected after a successful payment transaction</span>
                </div>
                <div class="giyapay-settings-field">
                    <div class="giyapay-settings-field-label">
                        <label for="error_callback">Error Callback</label>
                    </div>
                    <input class="giyapay-long-field" type="text" name="error_callback" value="<?php echo esc_attr($value['error_callback']) ?>"/>
                    <div class="giyapay-break"></div>
                    <span class="giyapay-field-help-text">This is where your customers will be redirected after a failed payment transaction</span>
                </div>
                <div class="giyapay-settings-field">
                    <div class="giyapay-settings-field-label">
                        <label for="cancel_callback">Cancel Callback</label>
                    </div>
                    <input class="giyapay-long-field" type="text" name="cancel_callback" value="<?php echo esc_attr($value['cancel_callback']) ?>"/>
                    <div class="giyapay-break"></div>
                    <span class="giyapay-field-help-text">This is where your customers will be redirected after they cancel a payment transaction</span>
                </div>
            </div>
        </div>
        <div class="giyapay-settings-section">
            <div class="giyapay-settings-section-title">Plugin Settings</div>
            <div class="giyapay-settings-section-content">
                <div class="giyapay-settings-field giyapay-settings-field-radio">
                    <div class="giyapay-settings-field-radio-label">Mode</div>
                    <div class="giyapay-radio-item">
                        <input type="radio" name="plugin_mode" value="sandbox" <?php echo esc_attr($value['plugin_mode'] === GIYAPAY_PLUGIN_MODE_SANDBOX ? 'checked' : ''); ?> />
                        <label for="plugin_mode">Sandbox</label>
                    </div>
                    <div class="giyapay-radio-item">
                        <input type="radio" name="plugin_mode" value="production" <?php echo esc_attr($value['plugin_mode'] === GIYAPAY_PLUGIN_MODE_PRODUCTION ? 'checked' : ''); ?> />
                        <label for="plugin_mode">Production</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="submit">Save Changes</button>
    <input type="hidden" name="update" />
    <?php wp_nonce_field('giyapay_settings_form_post'); ?>
</form>
