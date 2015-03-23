<?php
class ControllerTotalFactoringFee extends Controller {
    private $error = array();

    public function index() {
        $this->language->load('total/factoring_fee');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] === 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('factoring_fee', $this->request->post['factoring_fee']);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_none'] = $this->language->get('text_none');

        $this->data['entry_total'] = $this->language->get('entry_total');
        $this->data['entry_fee'] = $this->language->get('entry_fee');
        $this->data['entry_tax_class'] = $this->language->get('entry_tax_class');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_total'),
            'href'      => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('total/factoring_fee', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('total/factoring_fee', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['factoring_fee'])) {
            $this->data['factoring_fee'] = $this->request->post['factoring_fee'];
        } else {
            $this->data['factoring_fee'] = $this->model_setting_setting->getSetting('factoring_fee');
        }

        $default_settings = array(
            'factoring_fee_total' => 0,
            'factoring_fee_fee' => 0,
            'factoring_fee_tax_class_id' => 0,
            'factoring_fee_status' => 0,
            'factoring_fee_sort_order' => 0
        );
        $this->data['factoring_fee'] = array_merge($default_settings, $this->data['factoring_fee']);

        $this->load->model('localisation/tax_class');

        $this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

        $this->template = 'total/factoring_fee.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    private function validate() {
        $this->language->load('total/factoring_fee');

        if (!$this->user->hasPermission('modify', 'total/factoring_fee')) {
            $this->error['warning'] = $this->language->get('error_permission');
            return false;
        }

        // Check Tax and Total Sort Order
        $factoring_fee_sort_order = $this->request->post['factoring_fee']['factoring_fee_sort_order'];
        if ($this->config->get('tax_status') && $this->config->get('tax_sort_order') <= $factoring_fee_sort_order) {
            $this->error['warning'] = $this->language->get('error_factoring_fee_sort_order_tax');
            return false;
        }

        if ($this->config->get('total_status') && $this->config->get('total_sort_order') <= $factoring_fee_sort_order) {
            $this->error['warning'] = $this->language->get('error_factoring_fee_sort_order_total');
            return false;
        }

        return true;
    }
}
?>