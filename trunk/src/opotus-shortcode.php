<?php

function opotus_generate_dom_element($order_id, $amount) {
    $widgetPlaceholderId = "opotusWidgetPlaceholder";
?>
    <div id="<?php echo $widgetPlaceholderId; ?>"></div>
    <script type="application/javascript">
        (()=>{
            function onDone(transaction) {
                window.location.href = parseUrl("<?php echo stripslashes_deep(esc_attr(get_option('opotus_widget-callback_url'))); ?>", transaction);
            }

            function parseUrl(url, parameters) {
                const parsedUrl = new URL(url);
                const queryParams = parseQueryParams(parsedUrl.search);

                return parsedUrl.origin + parsedUrl.pathname + appendQueryParams({...queryParams, ...parameters});
            }

            function parseQueryParams(queryString) {
                if (!queryString.startsWith("?")) {
                    return {};
                }

                queryString = queryString.slice(1);
                const params = {};
                queryString.split("&").forEach(val => {
                    const valArray = val.split("=");
                    params[valArray[0]] = valArray[1];
                });

                return params;
            }

            function appendQueryParams(parameters) {
                return "?" + Object.keys(parameters).map(key => `${key}=${parameters[key]}`).join("&");
            }

            const config = {
                apiKey: "<?php echo stripslashes_deep(esc_attr(get_option('opotus_widget-api_key'))); ?>",
                secretKey: "<?php echo stripslashes_deep(esc_attr(get_option('opotus_widget-secret_key'))); ?>",
                callbackUrl: "<?php echo stripslashes_deep(esc_attr(get_option('opotus_widget-authorized_url'))); ?>",
                amount: "<?php echo $amount ?>",
                orderId: "<?php echo $order_id ?>",
                placeholderId: "<?php echo $widgetPlaceholderId ?>",
                transactionDoneCallback: onDone,
            };
            const widget = new OpotusWidget();
            widget.init(config);
        })();
    </script>
<?php
}

function opotus_shortcodes_init()
{
    function opotus_queue_js() {
        wp_enqueue_script( 'opotus-widget-npm-js', plugins_url( "/../node_modules/opotus-widget/dist/bundle.js", __FILE__ ));
    }
    add_action('wp_enqueue_scripts','opotus_queue_js');

    function opotus_payment_widget_shortcode() {
        if (empty($_GET["order_id"]) || empty($_GET["amount"])) {
            return "";
        }
        return opotus_generate_dom_element($_GET["order_id"], $_GET["amount"]);
    }
    add_shortcode('opotusdropins', 'opotus_payment_widget_shortcode');
}
add_action('init', 'opotus_shortcodes_init');