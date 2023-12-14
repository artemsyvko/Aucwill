<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/core/AdminController.php';

class Invoice extends AdminController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct(ROLE_STAFF);

        //チャットボット
        $this->header['page'] = 'invoice';
        $this->header['sub_page'] = 'invoice';
        $this->header['title'] = '請求予定';
        $this->check_login();
        $this->load->model('member_address_model');
        $this->load->model('user_model');
        $this->load->model('billing_model');
        $this->load->model('transaction_model');
        $this->check_member_address();
    }

    public function check_login(){
        if (!$this->session->userdata('is_logged')) {
            redirect('/login');
        }
    }

    public function check_member_address(){
        $member_id = $this->session->userdata('member_id');
        $member_addresses = $this->member_address_model->get_member_addresses($member_id);
        
        if (empty($member_addresses)) {
            redirect('address');
        }
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $member_id = $this->session->userdata('member_id');

        $transaction_button_data = [];

        $registered_date = $this->user_model->get_member_registered_date($member_id);
        $startDate = new DateTime($registered_date);
        $currentDate = new DateTime();

        $currentMonth = $currentDate->format('Y-m');
        $endMonth = $startDate->format('Y-m');

        $i = 0;

        while ($currentMonth >= $endMonth && $i < 24) {
            $currentDate->modify('first day of previous month');
            $currentMonth = $currentDate->format('Y-m');
            $is_paid = $this->transaction_model->is_paid_this_month($member_id, $currentMonth);

            array_push($transaction_button_data, array(
                                                        'year' => explode('-', $currentMonth)[0],
                                                        'month' => explode('-', $currentMonth)[1],
                                                        'is_paid' => $is_paid
                                                    ));
            $i++;
        }

        $this->data['transaction_button_data'] = $transaction_button_data;

        $current_month = date('Y-m', time());
        $last_month = date('Y-m', strtotime('-1 month', strtotime($current_month)));

        $billings1 = $this->billing_model->get_billings_by_month($member_id, $current_month);
        $billings2 = $this->billing_model->get_billings_by_month($member_id, $last_month);

        $this->data['current_month_billings'] = $billings1;
        $this->data['last_month_billings'] = $billings2;

        $sum1 = $this->billing_model->get_monthly_fee($member_id, $current_month);
        $sum1 = $sum1 == '' ? 0 : $sum1;
        $sum2 = $this->billing_model->get_monthly_fee($member_id, $last_month);
        $sum2 = $sum2 == '' ? 0 : $sum2;

        $this->data['current_month_fee'] = $sum1;
        $this->data['last_month_fee'] = $sum2;
        $this->data['membership_transaction'] = $this->transaction_model->get_membership_transaction($member_id);

        $this->load_view_with_menu("invoice/index");
    }

    public function get_invoice_pdf()
    {
        $month = $this->input->get('month');

        $member_id = $this->session->userdata('member_id');
        $username = $this->session->userdata('name');
        $company = $this->session->userdata('company');

        $count_shipping = $this->billing_model->count_shipping($member_id, $month);
        $count_shoot = $this->billing_model->count_shoot($member_id, $month);
        $count_measure = $this->billing_model->count_measure($member_id, $month);
        $count_call = $this->billing_model->count_call($member_id, $month);

        $monthly_fee = $this->billing_model->get_monthly_fee($member_id, $month) + MONTHLY_FEE;

        $mpdf = new \Mpdf\Mpdf();

        // Set the default font and encoding for the PDF
        $mpdf->autoLangToFont = true;
        $mpdf->autoScriptToLang = true;

        $mpdf->AddPage('P', 'A4');

        // Create HTML content
        $html = '
            <html lang="ja">
                <head>
                    <meta charset="UTF-8">
                    <title>Aucwill-'.$month.'</title>
                    <style>
                        p {
                            font-size: 12px;
                        }
                        .money {
                            font-size: 20px;
                        }
                    </style>
                </head>
                <body>
                    <hr style="width: 100%; border-top: 1px dashed #d5d5d5c7">
                    <h2 style="text-align: center;">オークウィル御請求書</h2>
                    <div style="padding: 0 20px 0 20px">
                        <table style="width: 100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <p>株式会社 '.$company.'</p>
                                        <p>'.$username.' 様</p>
                                    </td>
                                    <td style="text-align: right;">
                                        <small>'.date('Y年m月d日 H:i', time()).'</small><br>
                                        <p>'.ADMIN_NAME.'</p>
                                        <p>住所: '.ADMIN_POST_CODE.' '.ADMIN_PREFECTURE.ADMIN_ADDRESS.ADMIN_BUILDING. '</p>
                                        <p>Email: '.ADMIN_EMAIL.'</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <p>件名：オークウィル '.$month.' ご利用分</p>
                        <p>以下の通りご請求申し上げます。</p>
                        <p class="money">¥ '.($monthly_fee/10*11).'</p>
                        <table style="width: 100%" class="tbl-border-1">
                            <thead>
                                <tr>
                                    <th style="border: solid 0.0001px #514b4b85; width: 40%; padding: 10px;">件 名</th>
                                    <th style="border: solid 0.0001px #514b4b85; width: 30%; padding: 10px;">件 数</th>
                                    <th style="border: solid 0.0001px #514b4b85; width: 30%; padding: 10px;">金 額</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: solid 0.0001px #514b4b85; width: 40%; padding: 5px; text-align: center;">国内代行手数料</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">'.$count_shipping.'</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">'.($count_shipping*BASIC_FEE).'</td>
                                </tr>
                                <tr>
                                    <td style="border: solid 0.0001px #514b4b85; width: 40%; padding: 5px; text-align: center;">撮影代</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">'.$count_shoot.'</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">'.($count_shoot*SHOOT_FEE).'</td>
                                </tr>
                                <tr>
                                    <td style="border: solid 0.0001px #514b4b85; width: 40%; padding: 5px; text-align: center;">採寸</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">'.$count_measure.'</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">'.($count_measure*MEASURE_FEE).'</td>
                                </tr>
                                <tr>
                                    <td style="border: solid 0.0001px #514b4b85; width: 40%; padding: 5px; text-align: center;">通電確認</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">'.$count_call.'</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">'.($count_call*CALL_FEE).'</td>
                                </tr>
                                <tr>
                                    <td style="border: solid 0.0001px #514b4b85; width: 40%; padding: 5px; text-align: center;">月額会費</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">1</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">'.MONTHLY_FEE.'</td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 15px;" colspan="3"></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;"></td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">小 計</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">'.$monthly_fee.'</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;"></td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">消費税</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">'.($monthly_fee/10).'</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;"></td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">合 計</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">'.($monthly_fee/10*11).'</td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: solid 0.0001px #514b4b85; padding-top: 30px;" colspan="3">備 考</td>
                                </tr>	
                                <tr>
                                    <td style="width: 40%;"></td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;" colspan="2">
                                        <table style="width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: center;" colspan="2">お振込先</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left; padding-left: 20px;">銀行名</td>
                                                    <td style="text-align: right">スルガ銀行</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left; padding-left: 20px;">支店名</td>
                                                    <td style="text-align: right">Tポイント支店</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left; padding-left: 20px;">種別</td>
                                                    <td style="text-align: right">普通口座</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left; padding-left: 20px;">口座番号</td>
                                                    <td style="text-align: right">4261635</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left; padding-left: 20px;">名義</td>
                                                    <td style="text-align: right">バンドタカヒロ</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;"></td>
                                    <td style="width: 30%" colspan="2">
                                        <p style="padding-top: 15px;" colspan="2">内容をご確認の上、上記口座に5日までに お振り込みお願いいたします。</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </body>
            </html>';

        // Write HTML to the PDF
        $mpdf->WriteHTML($html);
        

        // Output the PDF
        $mpdf->Output('Aucwill-Invoice-'.$month.'.pdf', \Mpdf\Output\Destination::DOWNLOAD);
    }

    public function get_invoice_csv()
    {
        $month = $this->input->get('month');

        $member_id = $this->session->userdata('member_id');
        $username = $this->session->userdata('name');
        $company = $this->session->userdata('company');
        $monthly_fee = $this->billing_model->get_monthly_fee($member_id, $month) + MONTHLY_FEE;

        $billings = $this->billing_model->get_billings_by_month($member_id, $month);

        $data = array();

        // Push individual arrays into the $data array
        array_push($data, array('オークウィルご利用明細'));
        array_push($data, array(''));
        array_push($data, array(date('Y年m月d日 H:i', time())));
        array_push($data, array('株式会社', $company));
        array_push($data, array($username . '様'));
        array_push($data, array(''));
        array_push($data, array(ADMIN_NAME));
        array_push($data, array('住所', ADMIN_POST_CODE . ADMIN_PREFECTURE . ADMIN_ADDRESS . ADMIN_BUILDING));
        array_push($data, array('Email', ADMIN_EMAIL));
        array_push($data, array(''));
        array_push($data, array('¥ ', $monthly_fee/10*11));
        array_push($data, array(''));
        array_push($data, array('日 付', '商品管理番号', '管理番号', '明 細', '単 価'));
        foreach($billings as $billing) {
            $reference_id = $billing['prod_management_number'] == $billing['reference_id'] ? '' : 'S-'.str_pad($billing['reference_id'], 5, '0', STR_PAD_LEFT);
            array_push($data, array($billing['created_at'], 'P-'.$billing['prod_management_number'], $reference_id, $billing['fee_type'], $billing['fee_amount']));
        }
        array_push($data, array(''));
        array_push($data, array('', '', '', '小 計', $monthly_fee));
        array_push($data, array('', '', '', '消費税', $monthly_fee/10));
        array_push($data, array('', '', '', '合 計', $monthly_fee/10*11));


        // File path for CSV
        $filePath = 'aucwill-temp-invoice.csv';

        // Open the file for writing
        $file = fopen($filePath, 'w');

        // Set UTF-8 BOM (Byte Order Mark) to indicate UTF-8 encoding
        fwrite($file, "\xEF\xBB\xBF");

        // Write data to the CSV file
        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        // Close the file
        fclose($file);

        // Set headers for download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="Aucwill-'.$month.'.csv"');

        // Output the CSV file content
        readfile($filePath);
    }

    public function get_membership_invoice_pdf()
    {
        $member_id = $this->session->userdata('member_id');
        $username = $this->session->userdata('name');
        $company = $this->session->userdata('company');

        $mpdf = new \Mpdf\Mpdf();

        // Set the default font and encoding for the PDF
        $mpdf->autoLangToFont = true;
        $mpdf->autoScriptToLang = true;

        $mpdf->AddPage('P', 'A4');

        // Create HTML content
        $html = '
            <html lang="ja">
                <head>
                    <meta charset="UTF-8">
                    <title>Aucwill-Membership</title>
                    <style>
                        p {
                            font-size: 12px;
                        }
                        .money {
                            font-size: 20px;
                        }
                    </style>
                </head>
                <body>
                    <hr style="width: 100%; border-top: 1px dashed #d5d5d5c7">
                    <h2 style="text-align: center;">オークウィル御請求書</h2>
                    <div style="padding: 0 20px 0 20px">
                        <table style="width: 100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <p>株式会社 '.$company.'</p>
                                        <p>'.$username.' 様</p>
                                    </td>
                                    <td style="text-align: right;">
                                        <small>'.date('Y年m月d日 H:i', time()).'</small><br>
                                        <p>'.ADMIN_NAME.'</p>
                                        <p>住所: '.ADMIN_POST_CODE.' '.ADMIN_PREFECTURE.ADMIN_ADDRESS.ADMIN_BUILDING. '</p>
                                        <p>Email: '.ADMIN_EMAIL.'</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <p>件名：オークウィル入会金</p>
                        <p>以下の通りご請求申し上げます。</p>
                        <p class="money">¥ '.(MEMBERSHIP_FEE/10*11).'</p>
                        <table style="width: 100%" class="tbl-border-1">
                            <thead>
                                <tr>
                                    <th style="border: solid 0.0001px #514b4b85; width: 40%; padding: 10px;">件 名</th>
                                    <th style="border: solid 0.0001px #514b4b85; width: 30%; padding: 10px;">件 数</th>
                                    <th style="border: solid 0.0001px #514b4b85; width: 30%; padding: 10px;">金 額</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: solid 0.0001px #514b4b85; width: 40%; padding: 5px; text-align: center;">入会金</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">1</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">'.MEMBERSHIP_FEE.'</td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 15px;" colspan="3"></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;"></td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">小 計</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">'.MEMBERSHIP_FEE.'</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;"></td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">消費税</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">'.(MEMBERSHIP_FEE/10).'</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;"></td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">合 計</td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;">'.(MEMBERSHIP_FEE/10*11).'</td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: solid 0.0001px #514b4b85; padding-top: 30px;" colspan="3">備 考</td>
                                </tr>	
                                <tr>
                                    <td style="width: 40%;"></td>
                                    <td style="border: solid 0.0001px #514b4b85; width: 30%; padding: 5px; text-align: right; padding-right: 20px;" colspan="2">
                                        <table style="width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: center;" colspan="2">お振込先</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left; padding-left: 20px;">銀行名</td>
                                                    <td style="text-align: right">スルガ銀行</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left; padding-left: 20px;">支店名</td>
                                                    <td style="text-align: right">Tポイント支店</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left; padding-left: 20px;">種別</td>
                                                    <td style="text-align: right">普通口座</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left; padding-left: 20px;">口座番号</td>
                                                    <td style="text-align: right">4261635</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left; padding-left: 20px;">名義</td>
                                                    <td style="text-align: right">バンドタカヒロ</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;"></td>
                                    <td style="width: 30%" colspan="2">
                                        <p style="padding-top: 15px;" colspan="2">内容をご確認の上、上記口座に5日までに お振り込みお願いいたします。</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </body>
            </html>';

        // Write HTML to the PDF
        $mpdf->WriteHTML($html);
        

        // Output the PDF
        $mpdf->Output('Aucwill-Join-Invoice.pdf', \Mpdf\Output\Destination::DOWNLOAD);
    }

    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = '404エラー';

        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>
