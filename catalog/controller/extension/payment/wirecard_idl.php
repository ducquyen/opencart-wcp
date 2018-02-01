<?php
/**
 * Shop System Plugins - Terms of Use
 *
 * The plugins offered are provided free of charge by Wirecard Central Eastern
 * Europe GmbH
 * (abbreviated to Wirecard CEE) and are explicitly not part of the Wirecard
 * CEE range of products and services.
 *
 * They have been tested and approved for full functionality in the standard
 * configuration
 * (status on delivery) of the corresponding shop system. They are under
 * General Public License Version 2 (GPLv2) and can be used, developed and
 * passed on to third parties under the same terms.
 *
 * However, Wirecard CEE does not provide any guarantee or accept any liability
 * for any errors occurring when used in an enhanced, customized shop system
 * configuration.
 *
 * Operation in an enhanced, customized configuration is at your own risk and
 * requires a comprehensive test phase by the user of the plugin.
 *
 * Customers use the plugins at their own risk. Wirecard CEE does not guarantee
 * their full functionality neither does Wirecard CEE assume liability for any
 * disadvantages related to the use of the plugins. Additionally, Wirecard CEE
 * does not guarantee the full functionality for customized shop systems or
 * installed plugins of other vendors of plugins within the same shop system.
 *
 * Customers are responsible for testing the plugin's functionality before
 * starting productive operation.
 *
 * By installing the plugin into the shop system the customer agrees to these
 * terms of use. Please do not use the plugin if you do not agree to these
 * terms of use!
 */

// Load main controller
$dir = dirname(__FILE__);
require_once($dir . '/wirecard.php');

class ControllerExtensionPaymentWirecardIdl extends ControllerExtensionPaymentWirecard
{
    public $payment_type_prefix = '_idl';
    public $payment_type = WirecardCEE_QPay_PaymentType::IDL;

	public function index() {
		$prefix = 'wirecard'.$this->payment_type_prefix;

		// Load required files
		$this->load->model('checkout/order');
		$this->load->model('extension/payment/wirecard');

		$this->load->language('extension/payment/wirecard');
		$this->load->language('extension/payment/'.$prefix);

		// additional Data
		$data['button_confirm'] = $this->language->get('button_confirm');
		$data['window_name']    = $this->model_extension_payment_wirecard->get_window_name();

		$template                          = 'wirecard_idl';
		$data['text_title']                = $this->language->get('text_title');
		$data['text_financialinstitution'] = $this->language->get('text_financialinstitution');
		$data['select_financialinstitution'] = WirecardCEE_QPay_PaymentType::getFinancialInstitutions('IDL');

		$data['error_init'] = $this->language->get('error_init');

		$data['wcp_ratepay'] = $this->loadRatePay($prefix);

		// Set Action URI
		$data['action'] = $this->url->link('extension/payment/'.$prefix.'/init', '', 'SSL');

		// Template Output
		if (file_exists(DIR_TEMPLATE.$this->config->get('config_template').'/template/extension/payment/'.$template)) {
			$this->template = $this->config->get('config_template').'/template/extension/payment/'.$template;
		} else {
			$this->template = 'extension/payment/'.$template;
		}

		return $this->load->view($this->template, $data);
	}
}
