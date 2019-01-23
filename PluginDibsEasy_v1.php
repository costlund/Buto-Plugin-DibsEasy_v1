<?php
/**
 * https://tech.dibspayment.com/easy/integration-guide
 */
class PluginDibsEasy_v1{
  public $dibs_ip = '91.102.27.1';
  /**
   * Include javascript direct on page (not via ajax).
   */
  public function widget_js($data){
    $settings = $this->getSettings();
    $element = new PluginWfYml(__DIR__.'/element/js.yml');
    $element->setByTag($settings->get('data'), 'rs', true);
    wfDocument::renderElement($element->get());
  }
  /**
   * Widget with all data exept 2 keys.
   */
  public function widget_checkout($data){
    $data = new PluginWfArray($data);
    $data->set('data/checkout/url', str_replace('[url]', wfServer::calcUrl(false), $data->get('data/checkout/url')));
    $this->sessionSetCheckoutData($data->get('data'));
    $element = new PluginWfYml(__DIR__.'/element/checkout.yml');
    $element->setByTag($data->get('data/account'), 'rs', true);
    wfDocument::renderElement($element->get());
  }
  public function widget_get_payment($data){
    $data = new PluginWfArray($data);
    wfHelp::dump($this->getPayment($data->get('data')), true);
  }
  /**
   * Get payment from DIBS.
   * @param array $data
   * @return array
   */
  public function getPayment($data = array()){
    $data = new PluginWfArray($data);
    $url = 'https://api.dibspayment.eu/v1/payments/';
    if($data->get('test')){
      $url = 'https://test.api.dibspayment.eu/v1/payments/';
    }
    $url .= $data->get('paymentID');
    $ch=curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', 'Accept: application/json', 'Authorization: '.$data->get('secret-key')));
    $result=curl_exec($ch);
    $result = json_decode($result, true);
    return $result;
  }
  /**
   * Page loaded via ajax return paymentId in json.
   */
  public function page_createpayment(){
    $paymentId = $this->createPay();
    exit($paymentId);
  }
  /**
   * Should return { "paymentId": "string" }
   */
  public function createPay(){
    $data = $this->sessionGetCheckoutData();
    $http_header = array('Content-Type: application/json','Accept: application/json','Authorization: '.$data->get('account/secret-key'));
    $data = json_encode($data->get());
    $settings = $this->getSettings();
    $url = 'https://api.dibspayment.eu/v1/payments';
    if($settings->get('data/test')){
      $url = 'https://test.api.dibspayment.eu/v1/payments';
    }
    /**
     * CURL
     */
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header
    );
    $result = curl_exec($ch);
    return $result;
  }
  private function getSettings(){
    return wfPlugin::getPluginSettings('dibs/easy_v1', true);
  }
  private function sessionSetCheckoutData($data){
    $_SESSION['plugin']['dibs']['easy_v1']['checkout']['data'] = $data;
  }
  private function sessionGetCheckoutData(){
    if(!isset($_SESSION['plugin']['dibs']['easy_v1']['checkout']['data'])){
      return null;
    }
    $data = $_SESSION['plugin']['dibs']['easy_v1']['checkout']['data'];
    //unset($_SESSION['plugin']['dibs']['easy_v1']['checkout']['data']);
    return new PluginWfArray($data);
  }
}
