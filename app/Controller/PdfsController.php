<?php 
App::uses('AppController', 'Controller'); 
class PdfsController extends AppController { 
    public $components = array('Paginator', 'Mpdf.Mpdf');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('sales_api', 'earnings_api');
    }
    
    public function print_quote() {
        $this->Mpdf->init();

        $quotation_id = $this->params['url']['id'];

        $this->loadModel('Quotation');
        $this->Quotation->recursive = 2;
        $quotation = $this->Quotation->findById($quotation_id);
        $this->set(compact('quotation'));

        // pr($quotation); exit;

        $this->Mpdf->SetHTMLHeader('<div style="padding-top:-15px; right:500px; font-size:10px; " align="right">' . date("F d, Y h:i A") . '</div>');
        
        $this->Mpdf->SetHTMLFooter(' <table style="width: 100%;padding-bottom:-15px;  ">
        <tr>
            <td style="text-align: left;width:70%;font-size:10px;">
                Q ' . $quotation['Quotation']['quote_number'] . '</td>
            <td style="text-align: right;width: 30%;font-size:10px;">{PAGENO} / {nbpg}</td> 
        </tr>
    </table> '); 

        $terms_info = '<p style="margin-top: -5px;"><font size="6">' . $quotation['Quotation']['terms'] . '</font></p>';

        $terms = $terms_info;

        $this->set(compact('terms'));
 

        /////get sales agent who created the quotation
        $prepared_by = $quotation['User']['fullname'];
        $agent_signature = $quotation['User']['signature'];
        $this->set(compact('prepared_by'));
        $this->set(compact('agent_signature'));
 


        $client_name = strtoupper($quotation['Company']['name']);
        $contact_person = strtoupper($quotation['Company']['contact_person']);
        $this->set(compact('contact_person'));
        $contact_number = strtoupper($quotation['Company']['contact_number']);
        $email = strtoupper($quotation['Company']['email']);
        $address = strtoupper($quotation['Company']['address']);
 

        ////// PRODUCT DETAILS START //////

        $this->loadModel('QuotationProduct');
        $this->QuotationProduct->recursive = 2;
        $quote_products = $this->QuotationProduct->find('all', array(
            'conditions' => array('QuotationProduct.quotation_id' => $quotation_id)
        ));
        // pr($quote_products);
        // exit;

        $cnt = 1;
        $sub_total = 0;
        $product_details = [];
        foreach ($quote_products as $quote_prod) { 

            $product_details[] = '<tr>
                <td width="15" align="left">' . $cnt . '</td>
                <td width="140" align="center"><b>' . $quote_prod['Product']['name'] . '</b></td>
                <td width="120" align="center"><img class="img-responsive" src="../product_uploads/' . $quote_prod['Product']['image'] . '" width="100" height="100"></td>
                <td width="200">' . $quote_prod['QuotationProduct']['description'] . '</td>
                <td width="20">' . abs($quote_prod['QuotationProduct']['qty']) . '</td>
                <td width="100" align="right">&#8369;  ' . number_format($quote_prod['QuotationProduct']['list_price'], 2) . '</td> 
                <td width="120" align="right">&#8369;  ' . number_format($quote_prod['QuotationProduct']['total_price'], 2) . '</td></tr>';


            $cnt++;
            $sub_total = $sub_total + $quote_prod['QuotationProduct']['list_price'];
        }


        if ($quotation['Quotation']['discount'] != 0) {
            $discount = '&#8369;  ' . number_format($quotation['Quotation']['discount'], 2);
            $dis = '
                  <tr align="right">
                    <td style="width:50%" align="right"><b>Discount:</b> </td>
                    <td  style="text-align:right">' . $discount . ' </td>
                  </tr>';
        } else {
            $discount = "";
            $dis = "";
        }
        if ($quotation['Quotation']['installation_amount'] != 0) {
            $installation_charge = '&#8369;  ' . number_format($quotation['Quotation']['installation_amount'], 2);
            $install = '
                 <tr align="right">
                    <td align="right" ><b>Installation charge:</b></td>
                    <td style="text-align:right"> ' . $installation_charge . '</td>
                  </tr>';
        } else {
            $installation_charge = "";
            $install = "";
        }

        if ($quotation['Quotation']['delivery_amount'] != 0) {
            $delivery_charge = '&#8369;  ' . number_format($quotation['Quotation']['delivery_amount'], 2);
            $del = '
                <tr  align="right">
                    <td style="width:50%" align="right"><b>Delivery charge:</b> </td>
                    <td  style="text-align:right">' . $delivery_charge . '</td>
                  </tr>';
        } else {
            $delivery_charge = "";
            $del = "";
        }

        if ($quotation['Quotation']['installation_amount'] != 0 || $quotation['Quotation']['delivery_amount'] != 0 || $quotation['Quotation']['discount'] != 0) {
            $sub = '
                <tr  align="right">
                    <td  align="right"><b>Sub total:</b></td>
                    <td style="text-align:right; padding-right:0px" >&#8369;  ' . number_format($quotation['Quotation']['sub_total'], 2) . '<br/> <br/> 
                 </td> 
                 </tr>';
        } else {
            $sub = "";
        }



        ////// PRODUCT DETAILS END //////

        $this->Mpdf->WriteHTML(' <div style=" top: 35px; left:18px;  font-size:10px; ">
        <table style="width: 100%; border:1px ">
        
            <tr>
                <td colspan="2" align="right">
                   <h3>QUOTATION</h3>
                </td> 
            </tr>
            <tr>
                <td style="text-align: left;width:35%; font-size:13px;padding-right:20px;">
                <font style="font-size:12px;">
                    <p style="margin-top: -5px;">HAIMOBILIA ENTERPRISE</p>
                    <p style="margin-top: -5px;">Address : No. 64 C. Raymundo Ave.  Brgy. Sagad, Pasig City</p>
                    <p style="margin-top: -5px;">Tel: (02) 633.2996 / 903.6586</p>
                    <p style="margin-top: -5px;">Email Add : haimobilia@gmail.com</p>
                    <p style="margin-top: -5px;">www.furniturehai.com</p>
                    </font>
                </td> 
                <td style="text-align: right;width:25%; font-size:10px;">
                    <img src="../hai/haimobilia_logo.JPG"  width="15%" >  
                </td> 
            </tr>
        </table>
        <table border="0">
        <tr>
    
            <td width="350" align="left" style="padding-left:10px;padding-right:10px;padding-bottom:-50px;">
                <font style="font-size:12px;">To:</font>
                <font style="font-size:10px;">
                <p style="margin-top: 2px;"><b>' . strtoupper($client_name) . '</b></p>
                <p style="margin-top: -5px;">Contact person: ' . ucwords($contact_person) . '</p>
                <p style="margin-top: -5px;">Phone: ' . $contact_number . '</p>
                <p style="margin-top: -5px;">Email: ' . $email . '</p>
                <p style="margin-top: -5px;">Address: ' . ucwords($address) . '</p>
                </font> 
            </td> 
            <td width="300" align="left" style="padding-left:10px;padding-right:10px;padding-bottom:-50px;">
                <font style="font-size:11px;">
                <p style="margin-top: -5px;"><b>Quotation No.:</b> ' . $quotation['Quotation']['quote_number'] . '</p>  
                <p><b>Date Created:</b> ' . date('F d, Y', strtotime($quotation['Quotation']['created'])) . '</p>
                <p><b>Valid Till:</b> ' . date('F d, Y', strtotime($quotation['Quotation']['validity_date'])) . '</p>
                <p><b>Bill To:</b> ' . $quotation['Quotation']['billing_address']. '</p>
                <p><b>Ship To:</b> ' . $quotation['Quotation']['shipping_address']. '</p>
                 </font>  
            </td>
        </tr>   
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p> 
     <p style="margin-top: -5px;padding-left:10px;">Thank You for your inquiry. We are pleased to quote you the following : </p>
    
    <p>&nbsp;</p>
    <p>&nbsp;</p> 
    <table border="0" cellpadding="0" cellspacing="0"  style="border-collapse:collapse;font-size:12px; " align="center">
        <tr>
            <td align="left"  style="font-size:12px;"><b>#</b><br/><br/> <br/></td> 
            <td align="center" style="font-size:12px;"><b>Code</b> <br/><br/><br/> </td>
            <td align="center" style="font-size:12px;"><b>Product</b> <br/><br/><br/> </td>
            <td align="left"  style="font-size:12px;"><b>Description</b><br/><br/><br/> </td>
            <td align="center"  style="font-size:12px;"><b>Qty</b><br/> <br/><br/></td>
            <td align="right"  style="font-size:12px;"><b>List Price</b><br/> <br/><br/></td>
            <td   align="right"  style="font-size:12px; "> <b>Total</b><br/> <br/><br/></td>
        </tr>
        ' . implode($product_details) . '
            
     <tr>
            <td colspan="3" >  
            </td> 
            <td colspan="4" align="right">
                <table style="font-size:12px;width:250" align="right">
                    ' . $sub . '
                    ' . $install . '
                    ' . $del . '
                    ' . $dis . '
                      <tr>
                        <td style="width:50%" align="right"><b>Grand Total:</b><br/> <br/></td>
                        <td  style="text-align:right">&#8369;  ' . number_format($quotation['Quotation']['grand_total'], 2) . ' </td>
                      </tr>
                    </table>
                </td> 
        </tr>
    </table> 
    </table> 
    </div>
        ');

        $this->Mpdf->AddPage('P', // L - landscape, P - portrait 
                '', '', '', '', 5, // margin_left
                5, // margin right
                15, // margin top
                30, // margin bottom
                10, // margin header
                10);
        $this->layout = 'pdf';
        $this->render('print_quote');
        $this->Mpdf->setFilename('quotation.pdf');

    }
    
    
    
    // ======================================================================
    //  PRINT DELIVERY REPORT
    // ======================================================================

    public function print_dr() {
        $dr_id = $this->params['url']['id'];
        
        $this->loadModel('DeliveryReceipt');
        $this->loadModel('User');
        $this->loadModel('Company');
        
        $drs = $this->DeliveryReceipt->findById($dr_id);
        $dr = $drs['DeliveryReceipt'];
        $quotation = $drs['Quotation'];
        $user = $drs['User'];
        $sales_agent = $drs['User']['fullname'];
        $this->set(compact('DeliveryReceipt'));
        $this->set(compact('user'));
        $this->set(compact('quotation'));

        $drno = $dr['dr_number'];
        $quotation_id = $quotation['id'];
        $client_id = $quotation['company_id'];
        $client_obj = $this->Company->findById($client_id);
        $client = $client_obj['Company'];
        $this->set(compact('client'));
        $client_name = strtoupper($client['name']);
        $contact_person = strtoupper($client['contact_person']);
        $this->set(compact('contact_person'));
        $contact_number = strtoupper($client['contact_number']);
        $email = strtoupper($client['email']);
        $address = strtoupper($client['address']);
        
        $prepared_by = $user['fullname'];
        $agent_signature = $user['signature'];
        $this->set(compact('prepared_by'));
        $this->set(compact('agent_signature'));
        
        $this->loadModel('QuotationProduct');
        $this->QuotationProduct->recursive = 2;
        $quote_products = $this->QuotationProduct->find('all', array(
            'conditions' => array('QuotationProduct.quotation_id' => $quotation_id)
        ));
        
        $cnt = 1;
        $product_details = [];
        foreach ($quote_products as $quote_prod) {
            $product_details[] = '<tr>
                <td width="15" align="left">' . $cnt . '</td>
                <td width="140" align="center"><b>' . $quote_prod['Product']['name'] . '</b></td>
                <td width="120" align="center"><img class="img-responsive" src="../product_uploads/' . $quote_prod['Product']['image'] . '" width="100" height="100"></td>
                <td width="400">' . $quote_prod['QuotationProduct']['description'] . '</td>
                <td width="20">' . abs($quote_prod['QuotationProduct']['qty']) . '</td></tr>';
            $cnt++;
        }
        
        // ==============================
        // ALL MPDF RELATED CODES
        // ==============================
        $this->Mpdf->init();
        $this->Mpdf->SetHTMLHeader('<div style="padding-top:-15px; right:500px; font-size:10px; " align="right">' . date("F d, Y h:i A") . '</div>');
        $this->Mpdf->SetHTMLFooter('<table style="width: 100%;padding-bottom:-15px;  ">
            <tr>
                <td style="text-align: left;width:70%;font-size:10px;">
                    DR #. ' . $drno . '</td>
                <td style="text-align: right;width: 30%;font-size:10px;">{PAGENO} / {nbpg}</td> 
            </tr>
        </table>');
        
        $this->Mpdf->WriteHTML('
        <div style=" top: 35px; left:18px;  font-size:10px; ">
            <table style="width: 100%; border:1px ">
                <tr>
                    <td colspan="2" align="right">
                       <h3>Delivery Receipt</h3>
                    </td> 
                </tr>
                <tr>
                    <td style="text-align: left;width:35%; font-size:13px;padding-right:20px;">
                    <font style="font-size:12px;">
                        <p style="margin-top: -5px;">HAIMOBILIA ENTERPRISE</p>
                        <p style="margin-top: -5px;">Address : No. 64 C. Raymundo Ave.  Brgy. Sagad, Pasig City</p>
                        <p style="margin-top: -5px;">Tel: (02) 633.2996 / 903.6586</p>
                        <p style="margin-top: -5px;">Email Add : haimobilia@gmail.com</p>
                        <p style="margin-top: -5px;">www.furniturehai.com</p>
                        </font>
                    </td> 
                    <td style="text-align: right;width:25%; font-size:10px;">
                        <img src="../hai/haimobilia_logo.JPG"  width="15%" >  
                    </td> 
                </tr>
            </table>
            
            <table border="0">
                <tr>
                    <td width="320" align="left" style="padding-left:10px;padding-right:10px;padding-bottom:-50px;"> 
                        <font style="font-size:12px;">From:</font>
                        <font style="font-size:10px;"> 
                        <p class="marginedQuoteHeaderFirst"><b>HAIMOBILIA ENTERPRISE</b></p>
                        <p style="margin-top: -5px;">' . $my_team['Team']['location'] . '</p> 
                            ' . $other_team_locations . '
                        <p style="margin-top: -5px;">' . $my_team_telephone . '</p> 
                        <p style="margin-top: -5px;"><b>Sales Executive: </b>' . $sales_agent . '</p> 
                        <p style="margin-top: -5px;"><b>Prepared By: </b>' . $prepared_by . '</p> 
                        </font><br/><br/><br/> 
                    </td>
            
                    <td width="240" align="left" style="padding-left:10px;padding-right:10px;padding-bottom:-50px;">
                        <font style="font-size:12px;">To:</font>
                        <font style="font-size:10px;">
                        <p style="margin-top: 2px;"><b>' . $client_name . '</b></p>
                        <p style="margin-top: -5px;">Contact person:' . ucwords($contact_person) . '</p>
                        <p style="margin-top: -5px;">Phone:' . $contact_number . '</p>
                        <p style="margin-top: -5px;">Email:' . $email . '</p>
                        <p style="margin-top: -5px;">Address:' . ucwords($address) . '</p>
                        </font> 
                    </td> 
                    <td width="200" align="left" style="padding-left:10px;padding-right:10px;padding-bottom:-50px;">
                        <font style="font-size:11px;">
                        <p style="margin-top: -5px;"><b>DR #.:</b>'.$drno.'</p>  
                        <p><b>Date Created:</b> ' . date('F d, Y', strtotime($dr['created'])) . '</p>
                        </font>  
                    </td>
                </tr>
            </table>
            
            <br/><br/><br/><br/>
            
            <table border="0" cellpadding="0" cellspacing="0"  style="border-collapse:collapse;font-size:12px; " align="center">
                <tr>
                    <td align="left" style="font-size:12px;"><b>#</b><br/><br/> <br/></td> 
                    <td align="center" style="font-size:12px;"><b>Code</b> <br/><br/><br/> </td>
                    <td align="center" style="font-size:12px;"><b>Product</b> <br/><br/><br/> </td>
                    <td align="left" style="font-size:12px;"><b>Description</b><br/><br/><br/> </td>
                    <td align="center" style="font-size:12px;"><b>Qty</b><br/> <br/><br/></td>
                </tr>
                '.implode($product_details).'
            </table>
        </div>
        ');
        $this->layout = 'pdf';
        $this->render('print_dr');
        $this->Mpdf->setFilename('dr.pdf');
    }
    
    
    // ======================================================================
    //  PRINT JOB ORDER
    // ======================================================================
    
    public function print_jo() {
        $this->Mpdf->init();

        $quotation_id = $this->params['url']['id'];

        $this->loadModel('Quotation');
        $this->Quotation->recursive = 2;
        $quotation = $this->Quotation->findById($quotation_id);
        $this->set(compact('quotation'));
        // pr($quotation); exit;

        $this->Mpdf->SetHTMLHeader('<div style="padding-top:-15px; right:500px; font-size:10px; " align="right">' . date("F d, Y h:i A") . '</div>');
           $this->Mpdf->SetHTMLFooter(' <table style="width: 100%;padding-bottom:-15px;  ">
        <tr>
            <td style="text-align: left;width:70%;font-size:10px;">&nbsp;</td>
            <td style="text-align: right;width: 30%;font-size:10px;">{PAGENO} / {nbpg}</td> 
        </tr>
    </table> '); 
        
 
 

        /////get sales agent who created the quotation
        $prepared_by = $quotation['User']['fullname']; 


        $client_name = strtoupper($quotation['Company']['name']);
        $contact_person = strtoupper($quotation['Company']['contact_person']);
        $this->set(compact('contact_person'));
        $contact_number = strtoupper($quotation['Company']['contact_number']);
        $email = strtoupper($quotation['Company']['email']);
        $address = strtoupper($quotation['Company']['address']);
 

        ////// PRODUCT DETAILS START //////

        $this->loadModel('QuotationProduct');
        $this->QuotationProduct->recursive = 2;
        $quote_products = $this->QuotationProduct->find('all', array(
            'conditions' => array('QuotationProduct.quotation_id' => $quotation_id)
        ));
        // pr($quote_products);
        // exit;

        $cnt = 1;
        $sub_total = 0;
        $product_details = [];
        foreach ($quote_products as $quote_prod) { 

            $product_details[] = '<tr>
                <td width="15" align="left">' . $cnt . '</td>
                <td width="200" align="center"><b>' . $quote_prod['Product']['name'] . '</b></td>
                <td width="120" align="center"><img class="img-responsive" src="../product_uploads/' . $quote_prod['Product']['image'] . '" width="100" height="100"></td>
                <td width="300">' . $quote_prod['QuotationProduct']['description'] . '</td>
                <td width="20">' . abs($quote_prod['QuotationProduct']['qty']) . '</td> ';


            $cnt++;
            $sub_total = $sub_total + $quote_prod['QuotationProduct']['list_price'];
        }
 


        ////// PRODUCT DETAILS END //////

        $this->Mpdf->WriteHTML(' <div style=" top: 35px; left:18px;  font-size:10px; ">
        <table style="width: 100%; border:1px ">
        
            <tr>
                <td colspan="2" align="right">
                   <h3>Job Order</h3>
                </td> 
            </tr>
            <tr>
                <td style="text-align: left;width:35%; font-size:13px;padding-right:20px;">
                <font style="font-size:12px;">
                    <p style="margin-top: -5px;">HAIMOBILIA ENTERPRISE</p> 
                        <p style="margin-top: -5px;">Tel: (02) 633.2996 / 903.6586</p>
                    <p style="margin-top: -5px;">Email Add : haimobilia@gmail.com</p>
                    <p style="margin-top: -5px;">www.furniturehai.com</p>
                    <p style="margin-top: -5px;">JO-'.substr($quotation['Quotation']['quote_number'], -4).'</p>
                    <p style="margin-top: -5px;">'.$quotation['User']['fullname'].'</p>
                    </font>
                </td> 
                <td style="text-align: right;width:25%; font-size:10px;">
                    <img src="../hai/haimobilia_logo.JPG"  width="15%" >  
                </td> 
            </tr>
        </table>
 
    <p>&nbsp;</p>
    <p>&nbsp;</p>  
    
    <p>&nbsp;</p>
    <p>&nbsp;</p> 
    <table border="0" cellpadding="0" cellspacing="0"  style="border-collapse:collapse;font-size:12px; " align="center">
        <tr>
            <td align="left"  style="font-size:12px;"><b>#</b><br/><br/> <br/></td> 
            <td align="center" style="font-size:12px;"><b>Code</b> <br/><br/><br/> </td>
            <td align="center" style="font-size:12px;"><b>Product</b> <br/><br/><br/> </td>
            <td align="left"  style="font-size:12px;"><b>Description</b><br/><br/><br/> </td>
            <td align="center"  style="font-size:12px;"><b>Qty</b><br/> <br/><br/></td> 
        </tr>
        ' . implode($product_details) . '
            
    
    </table> 
    </table> 
    </div>
        ');

      
        $this->layout = 'pdf';
        $this->render('print_jo');
        $this->Mpdf->setFilename('hai-jo.pdf');

    }

     // ======================================================================
    //  PRINT EARNINGS
    // ======================================================================
    
    public function earnings() {
        $this->Mpdf->init();
        $this->loadModel('Quotation');
        $this->loadModel('User');

        $user_id = $this->params['url']['id'];
            $me = $this->User->findById($user_id);
        // $this->Quotation->recursive = 2;

        $pending_quotations = $this->Quotation->find('all',[
                'conditions'=>[
                        'Quotation.user_id'=> $user_id,
                        'Quotation.status'=>'pending'
                ]
        ]);
        $this->set(compact('pending_quotations'));

        $approved_quotations = $this->Quotation->find('all',[
                'conditions'=>[
                        'Quotation.user_id'=> $user_id,
                        'Quotation.status'=> ['moved','approved', 'processed']
                ]
        ]);
        $this->set(compact('approved_quotations'));



        ////// PENDING DETAILS start //////
        $pending_details = [];
        $cntp = 1;
        $sub_total = 0;
        foreach ($pending_quotations as $pending) { 
            // pr($pending);

            $pending_details[] = '<tr>
                <td width="15" align="left">' . $cntp . '</td>
                <td width="150" align="center">' .  date('F d, Y', strtotime($pending['Quotation']['created'])) . '</td>
                <td width="400" align="center"> ' . $pending['Company']['name'] . ' </td> 
                <td width="200" align="right">&#8369;  ' . number_format($pending['Quotation']['grand_total'],2) . '</td></tr> ';


            $cntp++;
            $sub_total = $sub_total + $pending['Quotation']['grand_total'];
        }
 

        ////// PENDING DETAILS END //////

        ////// approved DETAILS start //////
        $approved_details = [];
        $cnta = 1;
        $sub_totala = 0;
        foreach ($approved_quotations as $approved) { 
            // pr($pending);

            $approved_details[] = '<tr>
                <td width="15" align="left">' . $cnta . '</td>
                <td width="150" align="center">' .  date('F d, Y', strtotime($approved['Quotation']['created'])) . '</td>
                <td width="400" align="center"> ' . $approved['Company']['name'] . ' </td> 
                <td width="200" align="right">&#8369;  ' . number_format($approved['Quotation']['grand_total'],2) . '</td></tr> ';


            $cnta++;
            $sub_totala = $sub_totala + $approved['Quotation']['grand_total'];
        }
 

        ////// approved DETAILS END //////

        $this->Mpdf->WriteHTML(' <div style=" top: 35px; left:18px;  font-size:10px; ">
        <table style="width: 100%;">
        
            <tr>
                <td colspan="2" align="right">
                   <h3>Earnings</h3>
                </td> 
            </tr>
            <tr>
                <td style="text-align: left;width:35%; font-size:13px;padding-right:20px;">
                <font style="font-size:12px;">
                    <p style="margin-top: -5px;">HAIMOBILIA ENTERPRISE</p> 
                        <p style="margin-top: -5px;">Tel: (02) 633.2996 / 903.6586</p>
                    <p style="margin-top: -5px;">Email Add : haimobilia@gmail.com</p>
                    <p style="margin-top: -5px;">www.furniturehai.com</p> 
                    <p style="margin-top: -5px;">'.$me['User']['fullname'].'</p>
                    </font>
                </td> 
                <td style="text-align: right;width:25%; font-size:10px;">
                    <img src="../hai/haimobilia_logo.JPG"  width="10%" >  
                </td> 
            </tr>
        </table>
  
    <h2 align="center">List of Pending Quotations</h2>
    <table border="1" cellpadding="1" cellspacing="0"  style="border-collapse:collapse;font-size:12px; " align="center">
        <tr>
            <td align="left"  style="font-size:12px;"><b>#</b><br/><br/> <br/></td> 

            <td align="center" style="font-size:12px;"><b>Date Created</b> <br/><br/><br/> </td>
            <td align="center" style="font-size:12px;"><b>Company Name</b> <br/><br/><br/> </td>
            <td align="right"  style="font-size:12px;"><b>Contract Amount</b><br/><br/><br/> </td> 
        </tr>
        ' . implode($pending_details) . '
            
        <tr>
        <td colspan="3" align="right"><b>Grand Total: </b> &nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="right"><b>&#8369;  '.number_format($sub_total,2).'</b></td>
        </tr>
    </table>  
  <p>&nbsp;</p>
  <p>&nbsp;</p>
    <h2 align="center">List of Approved Quotations</h2>
    <table border="1" cellpadding="1" cellspacing="0"  style="border-collapse:collapse;font-size:12px; " align="center">
        <tr>
            <td align="left"  style="font-size:12px;"><b>#</b><br/><br/> <br/></td> 

            <td align="center" style="font-size:12px;"><b>Date Created</b> <br/><br/><br/> </td>
            <td align="center" style="font-size:12px;"><b>Company Name</b> <br/><br/><br/> </td>
            <td align="right"  style="font-size:12px;"><b>Contract Amount</b><br/><br/><br/> </td> 
        </tr>
        ' . implode($approved_details) . '
            
        <tr>
        <td colspan="3" align="right"><b>Grand Total: </b> &nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="right"><b>&#8369;  '.number_format($sub_totala,2).'</b></td>
        </tr>
    </table>  
    </div>
        ');
 
      
        $this->layout = 'pdf';
        $this->render('earnings');
        $this->Mpdf->setFilename('hai-earnings.pdf');

    }
    
    public function sales($timeline=NULL) {
        if($this->Auth->user('role')=='admin') {
            $this->autoRender = false;
            $this->loadModel('Quotation');
            $this->loadModel('Collection');
            
            $table_body = '';
        
            $current_year = date("Y");
            $grand_total = 0.000000;
            $col_total = 0.000000;
            $year_contract_total = 0.000000;
            $year_contract_total_c = 0.000000;
            $year_paid_total = 0.000000;
            $quotations = [];
            $quotations_c = [];
            
            if($timeline == 'month') {
                $current_mo = date("m");
                $full_mo = date("F");
                $tbody = 'No Sales Report';
                $options = ['conditions'=>['Quotation.status'=>['processed', 'approved'],
                                           'AND'=> ['YEAR(Quotation.created)' => date('Y'),
                                                    'MONTH(Quotation.created)' => $current_mo]],
                            'fields'=>['Quotation.id', 'Quotation.created',
                                       'Quotation.grand_total', 'Quotation.status',
                                       'Quotation.company_id', 'Quotation.user_id',
                                       'Company.id', 'Company.name', 'User.id',
                                       'User.fullname', 'Quotation.quote_number'],
                            'order'=>'Quotation.created DESC',
                            'recursive'=>2];
            
                $current_mo = date("m");
                $full_mo = date("F");
                $tbody = 'No Sales Report';
                
                $title = '
                <div align="center" style="font-family:Arial; ">
                    <font style="font-size:16px;font-weight:bold;color:#1a1a1a">Monthly Sales Report<font><br/>
                    <font style="font-size:11px;">('.$full_mo.' '.$current_year.')</p>
                </div>';
                
                $quotations = $this->Quotation->find('all', $options);
                    
                $count_monthly_quotation = 0;
                foreach($quotations as $quotation_obj) {
                    $count_monthly_quotation++;
                    
                    $quotation = $quotation_obj['Quotation'];
                    $company = [];
                    $agent = [];
                    if(!empty($quotation_obj['Company'])) {
                        $company = $quotation_obj['Company'];
                    }
                    if(!empty($quotation_obj['User'])) {
                        $agent = $quotation_obj['User'];
                    }
                    
                    $quotation_id = $quotation['id'];
                    if($quotation['created']!="") {
                        $date_created = date("M. d, Y (h:i A)", strtotime($quotation['created']));
                    }
                    else {
                        $date_created = "<font style='color:red'>Not Specified</font>";
                    }
                    
                    if($quotation['quote_number']!="") {
                        $quote_number = $quotation['quote_number'];
                    }
                    else {
                        $quote_number = "<font style='color:red'>Unknown</font>";
                    }
                    
                    $company_name = "<font style='color:red'>Not Specified</font>";
                    
                    if(!empty($company)) {
                        if($company['name']!="") {
                            $company_name = $company['name'];
                        }
                    }
                    
                    if(!empty($agent)) {
                        $full_name = $agent['fullname'];
        
                        if($full_name=="") {
                            $full_name = "<font style='color:red'>Unknown</font>";
                        }
                    }
                    else {
                        $full_name = "<font style='color:red'>Unknown</font>";
                    }
                    
                    $contract_amount = number_format((float)$quotation['grand_total'],2,'.',',');
                    $grand_total += $quotation['grand_total'];
                    $date_created = date("F d, Y", strtotime($quotation['created']));
                    
                    $colls[$quotation_id] = $this->Collection->find('all',
                        ['conditions'=>['Collection.quotation_id'=>$quotation_id,
                                        'Collection.status'=>'verified'],
                                        'fields'=>['Collection.paid_amount'],
                                        'recursive'=>-1]);
                    $collected_amount = 0.00;
                    foreach($colls[$quotation_id] as $col_obj) {
                        $col = $col_obj['Collection'];
                        $collected_amount += $col['paid_amount'];
                    }
                    
                    if($collected_amount >= floatval($quotation['grand_total'])) {
                        $contract_amount_txt = '<td style="background-color: rgba(152,251,152, 0.3);text-align:center">CLEARED</td>';
                    }
                    else {
                        $contract_amount_txt = '<td align="right">&#8369;  '.$contract_amount.'</td>';
                    }
                    
                    $col_total += $collected_amount;
                    $tbody .= '
                        <tr>
                            <td>'.$count_monthly_quotation.'</td>
                            <td>'.$date_created.'</td>
                            <td>'.$quote_number.'</td>
                            <td>'.$company_name.'</td>
                            <td>'.$full_name.'</td>
                            '.$contract_amount_txt.'
                            <td>'.$date_created.'</td>
                            <td align="right">&#8369;  '.number_format((float)$collected_amount,2,'.',',').'</td>
                        </tr>
                    ';
                }
                
                $table = '
                    <table border="1" width="100%"  style="border-collapse:collapse;font-size:10px;border-color:#1a1a1a" align="center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date Created</th>
                                <th>Quotation #</th>
                                <th>Company Name</th>
                                <th>Agent Name</th>
                                <th>Contract Amount</th>
                                <th>Date Created</th>
                                <th>Collected Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        '.$tbody.'
                        <tr>
                            <td colspan="5" align="right"
                                style="font-weight:bold">Grand Total:</td>
                            <td align="right">&#8369;  '.number_format((float)$grand_total,2,'.',',').'</td>
                            <td colspan="2" align="right">&#8369;  '.number_format((float)$col_total,2,'.',',').'</td>
                        </tr>
                        </tbody>
                    </table>
                ';
            
            }
            elseif($timeline == "year") {
                $title = '<div align="center" style="font-family:Arial; ">
                    <font style="font-size:16px;font-weight:bold;color:#1a1a1a">'.date("Y").' Sales Report<font><br/>
                    <font style="font-size:11px;">Monthly Summary</p>
                </div>';
                            
                for($m=1;$m<=12;$m++) {
                    $month_txt = date('F', mktime(0, 0, 0, $m, 1));
                    
                    $options = ['conditions'=>['status'=> ['processed', 'approved'],
                                               'AND'=> ['YEAR(created)' => date('Y'),
                                                        'MONTH(created)' => $m],
                                              ],
                                'fields'=>['id', 'created', 'grand_total', 'status'],
                                'order'=>'created DESC',
                                'recursive'=>-1];
                    
                    $options_cancelled = ['conditions' => ['status'=>'cancelled'],
                                                           'AND'=> ['YEAR(.created)' => date('Y'),
                                                                    'MONTH(created)' => $m],
                                          'fields'=>['id', 'created', 'grand_total', 'status'],
                                          'order'=>'created DESC',
                                          'recursive'=>-1];
                    $quotations[$m] = $this->Quotation->find('all', $options);
                    $quotations_c[$m] = $this->Quotation->find('all', $options_cancelled);                             
                
                    $collections = [];
                    $tot_grand_total = [];
                    $tot_grand_total_c = [];
                    $grand_total = 0.000000;
                    $grand_total_c = 0.000000;
                    $total_paid_amount = 0.000000;
    
                    $tot_grand_total[$m] = 0;
                    $tot_grand_total_c[$m] = 0;
                    
                    foreach($quotations[$m] as $quotation_obj) {
                        $quotation = $quotation_obj['Quotation'];
                        $quotation_id = $quotation['id'];
                        $grand_total += $quotation['grand_total'];
        
                        $tot_grand_total[$m] = $grand_total;
                        
                        $collections[$quotation_id] = $this->Collection->find('all',
                            ['conditions'=> ['quotation_id'=>$quotation_id],
                             'fields'=> ['id', 'paid_amount'],
                             'recursive'=> -1]);
                                            
                        foreach($collections[$quotation_id] as $collection_obj) {
                            $collection = $collection_obj['Collection'];
                            $total_paid_amount += $collection['paid_amount'];
                        }
                    }
                    
                    foreach($quotations_c[$m] as $quotation_obj_c) {
                        $quotation_c = $quotation_obj_c['Quotation'];
                        $quotation_id_c = $quotation_c['id'];
                        $grand_total_c += $quotation_c['grand_total'];
        
                        $tot_grand_total_c[$m] = $grand_total_c;
                    }
                    
                    $year_contract_total += $tot_grand_total[$m];
                    $year_contract_total_c += $tot_grand_total_c[$m];
                    $year_paid_total += $total_paid_amount;
                    
                    $table_body .= '
                        <tr>
                            <td width="25%" style="padding-left:70px;font-weight:bold;">'.$month_txt.'</td>
                            <td width="25%" style="padding-right:50px;" align="right">&#8369;  '.number_format((float)$tot_grand_total[$m],2,'.',',').'</td>
                            <td width="25%" style="padding-right:70px;" align="right">&#8369;  '.number_format((float)$total_paid_amount,2,'.',',').'</td>';
                            
                            if($tot_grand_total_c[$m]!=0) {
                                $table_body .= '<td width="25%" style="padding-right:70px;" align="right">&#8369;  '.number_format((float)$tot_grand_total_c[$m],2,'.',',').'</td>';
                            }
                            else {
                                $table_body .= '<td width="25%" style="padding-right:70px;" align="right">&#8369; 0.00</td>';
                            }
                    $table_body .= '</tr>';
                }
    
                if(!empty($quotations)) {
                    $grand_total_foot = '<tr>
                                <td width="25%" style="padding-left:70px;font-weight:bold;">Grand Total</td>
                                <td width="25%" style="padding-right:50px;" align="right">&#8369;  '.number_format((float)$year_contract_total,2,'.',',').'</td>
                                <td width="25%" style="padding-right:70px;font-weight:bold;" align="right">&#8369;  '.number_format((float)$year_paid_total,2,'.',',').'</td>
                                <td width="25%" style="padding-right:70px;font-weight:bold;" align="right">&#8369;  '.number_format((float)$year_contract_total_c,2,'.',',').'</td>
                            </tr>';
                }
                else { $grand_total_foot = '<tr><td colspan="4" style="padding-left:500px;">No Data</td></tr>'; }
                
                $table = '
                    <table width="100%" border="1" cellpadding="1" style="border-collapse:collapse;font-size:10px;border-color:#1a1a1a" align="center">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Contract Amount</th>
                                <th>Collected Amount</th>
                                <th>Cancelled Quotations</th>
                            </tr>
                        </thead>
                        <tbody>
                            '.$table_body.'
                        
                            '.$grand_total_foot.'
                        </tbody>
                    </table>
                    ';
            }
            else {
                $title = '';
            }
            
            // ==============================
            // ALL MPDF RELATED CODES
            // ==============================
            $html = '
                <table style="font-family:Arial; font-size:10px;width:100%;" align="center">
                    <tr>
                        <td width="45%" align="left">
                            <font style="font-weight:bold">Main Office:</font><br/>
                            64 C. Raymundo Ave.Bgy. Sagad, Pasig City<br/><br/>
                        </td>
                        <td width="55%" style="padding-left:35%">
                            <font style="font-weight:bold;">Landline:</font><br/>
                            (02) 633.2996 | 903.6586 <br/>
                            (02) 903-6586 | (02) 633-2996 <br/>
                            (02) 404-8898 | (02) 985-4689 <br/>
                            (02) 985-4694 | (02) 404-8707 <br/>
                            0935-3524137 | 0938-6128244 <br/>
                            0917-6471846 | 0946-6009583 <br/>
                            0926-9729701 | 0956-9734868 <br/>
                            0932-1425722<br/>
                            <font style="font-weight:bold;">Email:</font><br/>
                            haimobilia@gmail.com<br/><br/>
                            <font style="font-weight:bold;">Website:</font><br/>
                            www.furniturehai.com
                        </td>
                    </tr>
                </table>
                
                <br/>
                
                <div align="center" style="font-family:Arial; ">
                    <font style="font-size:11px;">'.$title.'</p>
                </div>
                <br/>
                ';
                
            $html .= $table;
    
            $this->Mpdf->init();
            
            $this->Mpdf->SetHTMLHeader('<img src="/hai/haimobilia_logo.JPG" width="35" height="35">
                <div style="font-family:Arial; padding-top:-15px;padding-right:20px; font-size:10px; " align="right">' . date("F d, Y") . '</div><hr/>');
            $this->Mpdf->SetHTMLFooter('<hr/><table style="width: 100%;padding-bottom:-15px;">
                                        <tr>
                                            <td style="text-align: left;width:70%;font-size:10px;">{PAGENO} / {nbpg} </td>
                                            <td style="text-align: right;width: 30%;font-size:10px;">w w w . f u r n i t u r e h a i . c o m</td> 
                                        </tr>
                                    </table> ');
            $this->Mpdf->AddPage('P', 
                    '', '', '', '', 8,
                    8, // margin right
                    25, // margin top
                    30, // margin bottom
                    10, // margin header
                    10);
    
            $this->Mpdf->WriteHTML($html);
            $this->layout = 'pdf';
            $this->render('sales');
            $this->Mpdf->setFilename('sales.pdf');
        }
        else {
            $warning = 'This area is restricted. Please contact System Administrator.';
            $this->set(compact('warning'));
        }
    }
    
    public function sales_api($timeline=NULL) {
        // DO NOT DELETE
        // USED IN JECAMS ERP
        $this->autoRender = false;
        $this->loadModel('Quotation');
        $this->loadModel('Collection');
        
        $table_body = '';
    
        $current_year = date("Y");
        $grand_total = 0.000000;
        $col_total = 0.000000;
        $year_contract_total = 0.000000;
        $year_contract_total_c = 0.000000;
        $year_paid_total = 0.000000;
        $quotations = [];
        $quotations_c = [];
            
        if($timeline == 'month') {
            $current_mo = date("m");
            $full_mo = date("F");
            $tbody = 'No Sales Report';
            $options = ['conditions'=>['Quotation.status'=>['processed', 'approved'],
                                       'AND'=> ['YEAR(Quotation.created)' => date('Y'),
                                                'MONTH(Quotation.created)' => $current_mo]],
                        'fields'=>['Quotation.id', 'Quotation.created',
                                   'Quotation.grand_total', 'Quotation.status',
                                   'Quotation.company_id', 'Quotation.user_id',
                                   'Company.id', 'Company.name', 'User.id',
                                   'User.fullname', 'Quotation.quote_number'],
                        'order'=>'Quotation.created DESC',
                        'recursive'=>2];
        
            $current_mo = date("m");
            $full_mo = date("F");
            $tbody = 'No Sales Report';
            
            $title = '
            <div align="center" style="font-family:Arial; ">
                <font style="font-size:16px;font-weight:bold;color:#1a1a1a">Monthly Sales Report<font><br/>
                <font style="font-size:11px;">('.$full_mo.' '.$current_year.')</p>
            </div>';
            
            $quotations = $this->Quotation->find('all', $options);
                
            $count_monthly_quotation = 0;
            foreach($quotations as $quotation_obj) {
                $count_monthly_quotation++;
                
                $quotation = $quotation_obj['Quotation'];
                $company = [];
                $agent = [];
                if(!empty($quotation_obj['Company'])) {
                    $company = $quotation_obj['Company'];
                }
                if(!empty($quotation_obj['User'])) {
                    $agent = $quotation_obj['User'];
                }
                
                $quotation_id = $quotation['id'];
                if($quotation['created']!="") {
                    $date_created = date("M. d, Y (h:i A)", strtotime($quotation['created']));
                }
                else {
                    $date_created = "<font style='color:red'>Not Specified</font>";
                }
                
                if($quotation['quote_number']!="") {
                    $quote_number = $quotation['quote_number'];
                }
                else {
                    $quote_number = "<font style='color:red'>Unknown</font>";
                }
                
                $company_name = "<font style='color:red'>Not Specified</font>";
                
                if(!empty($company)) {
                    if($company['name']!="") {
                        $company_name = $company['name'];
                    }
                }
                
                if(!empty($agent)) {
                    $full_name = $agent['fullname'];
    
                    if($full_name=="") {
                        $full_name = "<font style='color:red'>Unknown</font>";
                    }
                }
                else {
                    $full_name = "<font style='color:red'>Unknown</font>";
                }
                
                $contract_amount = number_format((float)$quotation['grand_total'],2,'.',',');
                $grand_total += $quotation['grand_total'];
                $date_created = date("F d, Y", strtotime($quotation['created']));
                
                $colls[$quotation_id] = $this->Collection->find('all',
                    ['conditions'=>['Collection.quotation_id'=>$quotation_id,
                                    'Collection.status'=>'verified'],
                                    'fields'=>['Collection.paid_amount'],
                                    'recursive'=>-1]);
                $collected_amount = 0.00;
                foreach($colls[$quotation_id] as $col_obj) {
                    $col = $col_obj['Collection'];
                    $collected_amount += $col['paid_amount'];
                }
                
                if($collected_amount >= floatval($quotation['grand_total'])) {
                    $contract_amount_txt = '<td style="background-color: rgba(152,251,152, 0.3);text-align:center">CLEARED</td>';
                }
                else {
                    $contract_amount_txt = '<td align="right">&#8369;  '.$contract_amount.'</td>';
                }
                
                $col_total += $collected_amount;
                $tbody .= '
                    <tr>
                        <td>'.$count_monthly_quotation.'</td>
                        <td>'.$date_created.'</td>
                        <td>'.$quote_number.'</td>
                        <td>'.$company_name.'</td>
                        <td>'.$full_name.'</td>
                        '.$contract_amount_txt.'
                        <td>'.$date_created.'</td>
                        <td align="right">&#8369;  '.number_format((float)$collected_amount,2,'.',',').'</td>
                    </tr>
                ';
            }
            
            $table = '
                <table border="1" cellpadding="1" style="border-collapse:collapse;font-size:10px;border-color:#1a1a1a" align="center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date Created</th>
                            <th>Quotation #</th>
                            <th>Company Name</th>
                            <th>Agent Name</th>
                            <th>Contract Amount</th>
                            <th>Date Created</th>
                            <th>Collected Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    '.$tbody.'
                    <tr>
                        <td colspan="5" align="right"
                            style="font-weight:bold">Grand Total:</td>
                        <td align="right">&#8369;  '.number_format((float)$grand_total,2,'.',',').'</td>
                        <td colspan="2" align="right">&#8369;  '.number_format((float)$col_total,2,'.',',').'</td>
                    </tr>
                    </tbody>
                </table>
            ';
        
        }
        elseif($timeline == "year") {
            $title = '<div align="center" style="font-family:Arial; ">
                <font style="font-size:16px;font-weight:bold;color:#1a1a1a">'.date('Y').' Sales Report<font><br/>
                <font style="font-size:11px;">Monthly Summary</p>
            </div>';
                        
            for($m=1;$m<=12;$m++) {
                $month_txt = date('F', mktime(0, 0, 0, $m, 1));
                
                $options = ['conditions'=>['status'=> ['processed', 'approved'],
                                           'AND'=> ['YEAR(created)' => date('Y'),
                                                    'MONTH(created)' => $m],
                                          ],
                            'fields'=>['id', 'created', 'grand_total', 'status'],
                            'order'=>'created DESC',
                            'recursive'=>-1];
                
                $options_cancelled = ['conditions' => ['status'=>'cancelled'],
                                                       'AND'=> ['YEAR(.created)' => date('Y'),
                                                                'MONTH(created)' => $m],
                                      'fields'=>['id', 'created', 'grand_total', 'status'],
                                      'order'=>'created DESC',
                                      'recursive'=>-1];
                $quotations[$m] = $this->Quotation->find('all', $options);
                $quotations_c[$m] = $this->Quotation->find('all', $options_cancelled);                             
            
                $collections = [];
                $tot_grand_total = [];
                $tot_grand_total_c = [];
                $grand_total = 0.000000;
                $grand_total_c = 0.000000;
                $total_paid_amount = 0.000000;

                $tot_grand_total[$m] = 0;
                $tot_grand_total_c[$m] = 0;
                
                foreach($quotations[$m] as $quotation_obj) {
                    $quotation = $quotation_obj['Quotation'];
                    $quotation_id = $quotation['id'];
                    $grand_total += $quotation['grand_total'];
    
                    $tot_grand_total[$m] = $grand_total;
                    
                    $collections[$quotation_id] = $this->Collection->find('all',
                        ['conditions'=> ['quotation_id'=>$quotation_id],
                         'fields'=> ['id', 'paid_amount'],
                         'recursive'=> -1]);
                                        
                    foreach($collections[$quotation_id] as $collection_obj) {
                        $collection = $collection_obj['Collection'];
                        $total_paid_amount += $collection['paid_amount'];
                    }
                }
                
                foreach($quotations_c[$m] as $quotation_obj_c) {
                    $quotation_c = $quotation_obj_c['Quotation'];
                    $quotation_id_c = $quotation_c['id'];
                    $grand_total_c += $quotation_c['grand_total'];
    
                    $tot_grand_total_c[$m] = $grand_total_c;
                }
                
                $year_contract_total += $tot_grand_total[$m];
                $year_contract_total_c += $tot_grand_total_c[$m];
                $year_paid_total += $total_paid_amount;
                
                $table_body .= '
                    <tr>
                        <td width="25%" style="padding-left:50px;font-weight:bold;">'.$month_txt.'</td>
                        <td width="25%" style="padding-right:50px;" align="right">&#8369;  '.number_format((float)$tot_grand_total[$m],2,'.',',').'</td>
                        <td width="25%" style="padding-right:70px;" align="right">&#8369;  '.number_format((float)$total_paid_amount,2,'.',',').'</td>';
                        
                        if($tot_grand_total_c[$m]!=0) {
                            $table_body .= '<td width="25%" style="padding-right:70px;" align="right">&#8369;  '.number_format((float)$tot_grand_total_c[$m],2,'.',',').'</td>';
                        }
                        else {
                            $table_body .= '<td width="25%" style="padding-right:70px;" align="right">&#8369; 0.00</td>';
                        }
                $table_body .= '</tr>';
            }

            if(!empty($quotations)) {
                $grand_total_foot = '<tr>
                            <td width="25%" style="padding-left:50px;font-weight:bold;">Grand Total</td>
                            <td width="25%" style="padding-right:50px;" align="right">&#8369;  '.number_format((float)$year_contract_total,2,'.',',').'</td>
                            <td width="25%" style="padding-right:70px;font-weight:bold;" align="right">&#8369;  '.number_format((float)$year_paid_total,2,'.',',').'</td>
                            <td width="25%" style="padding-right:70px;font-weight:bold;" align="right">&#8369;  '.number_format((float)$year_contract_total_c,2,'.',',').'</td>
                        </tr>';
            }
            else { $grand_total_foot = '<tr><td colspan="4" style="padding-left:500px;">No Data</td></tr>'; }
            
            $table = '
                <table border="1" width="100%" style="border-collapse:collapse;font-size:10px;border-color:#1a1a1a" align="center">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Contract Amount</th>
                            <th>Collected Amount</th>
                            <th>Cancelled Quotations</th>
                        </tr>
                    </thead>
                    <tbody>
                        '.$table_body.'
                    
                        '.$grand_total_foot.'
                    </tbody>
                </table>
                ';
        }
        else {
            $title = '';
        }
        
        // ==============================
        // ALL MPDF RELATED CODES
        // ==============================
        $html = '
            <table style="font-family:Arial; font-size:10px;width:100%;" align="center">
                <tr>
                    <td width="45%" align="left">
                        <font style="font-weight:bold">Main Office:</font><br/>
                        64 C. Raymundo Ave.Bgy. Sagad, Pasig City<br/><br/>
                    </td>
                    <td width="55%" style="padding-left:35%">
                        <font style="font-weight:bold;">Landline:</font><br/>
                        (02) 633.2996 | 903.6586 <br/>
                        (02) 903-6586 | (02) 633-2996 <br/>
                        (02) 404-8898 | (02) 985-4689 <br/>
                        (02) 985-4694 | (02) 404-8707 <br/>
                        0935-3524137 | 0938-6128244 <br/>
                        0917-6471846 | 0946-6009583 <br/>
                        0926-9729701 | 0956-9734868 <br/>
                        0932-1425722<br/>
                        <font style="font-weight:bold;">Email:</font><br/>
                        haimobilia@gmail.com<br/><br/>
                        <font style="font-weight:bold;">Website:</font><br/>
                        www.furniturehai.com
                    </td>
                </tr>
            </table>
            
            <br/><br/>
            
            <div align="center" style="font-family:Arial; ">
                <font style="font-size:11px;">'.$title.'</p>
            </div>
            
            <br/>
            ';
            
        $html .= $table;
        
        $header = '<img src="http://haimo.co//hai/haimobilia_logo.JPG" width="35" height="35">
            <div style="font-family:Arial; padding-top:-15px;padding-right:20px; font-size:10px; " align="right">' . date("F d, Y") . '</div><hr/>';
        $footer = '<hr/><table style="width: 100%;padding-bottom:-15px;">
                                    <tr>
                                        <td style="text-align: left;width:70%;font-size:10px;">{PAGENO} / {nbpg} </td>
                                        <td style="text-align: right;width: 30%;font-size:10px;">w w w . f u r n i t u r e h a i . c o m</td> 
                                    </tr>
                                </table> ';
        return json_encode(['html'=>$html,'header'=>$header, 'footer'=>$footer]);
    }
    
    
    public function earnings_api($user_id=NULL) {
        $this->autoRender = false;
        $this->loadModel('Quotation');
        $this->loadModel('User');

        $me = $this->User->findById($user_id);
        $pending_quotations = $this->Quotation->find('all',[
                'conditions'=>[
                        'Quotation.user_id'=> $user_id,
                        'Quotation.status'=>'pending'
                ]
        ]);

        $approved_quotations = $this->Quotation->find('all',[
                'conditions'=>[
                        'Quotation.user_id'=> $user_id,
                        'Quotation.status'=> ['moved','approved', 'processed']
                ]
        ]);

        ////// PENDING DETAILS start //////
        $pending_details = [];
        $cntp = 1;
        $sub_total = 0;
        foreach ($pending_quotations as $pending) { 
            $pending_details[] = '<tr>
                <td width="15" align="left">' . $cntp . '</td>
                <td width="150" align="center">' .  date('F d, Y', strtotime($pending['Quotation']['created'])) . '</td>
                <td width="400" align="center"> ' . $pending['Company']['name'] . ' </td> 
                <td width="200" align="right">&#8369;  ' . number_format($pending['Quotation']['grand_total'],2) . '</td></tr> ';
            $cntp++;
            $sub_total = $sub_total + $pending['Quotation']['grand_total'];
        }
        ////// PENDING DETAILS END //////

        ////// approved DETAILS start //////
        $approved_details = [];
        $cnta = 1;
        $sub_totala = 0;
        foreach ($approved_quotations as $approved) { 
            $approved_details[] = '<tr>
                <td width="15" align="left">' . $cnta . '</td>
                <td width="150" align="center">' .  date('F d, Y', strtotime($approved['Quotation']['created'])) . '</td>
                <td width="400" align="center"> ' . $approved['Company']['name'] . ' </td> 
                <td width="200" align="right">&#8369;  ' . number_format($approved['Quotation']['grand_total'],2) . '</td></tr> ';
            $cnta++;
            $sub_totala = $sub_totala + $approved['Quotation']['grand_total'];
        }
        ////// approved DETAILS END //////

        $html = ' <div style=" top: 35px; left:18px;  font-size:10px; ">
        <table style="width: 100%; border:1px ">
        
            <tr>
                <td colspan="2" align="right">
                   <h3>Earnings</h3>
                </td> 
            </tr>
            <tr>
                <td style="text-align: left;width:35%; font-size:13px;padding-right:20px;">
                <font style="font-size:12px;">
                    <p style="margin-top: -5px;">HAIMOBILIA ENTERPRISE</p> 
                        <p style="margin-top: -5px;">Tel: (02) 633.2996 / 903.6586</p>
                    <p style="margin-top: -5px;">Email Add : haimobilia@gmail.com</p>
                    <p style="margin-top: -5px;">www.furniturehai.com</p> 
                    <p style="margin-top: -5px;">'.$me['User']['fullname'].'</p>
                    </font>
                </td> 
                <td style="text-align: right;width:25%; font-size:10px;">
                    <img src="http://haimo.co//hai/haimobilia_logo.JPG"  width="10%" >  
                </td> 
            </tr>
        </table>
        
        <h2 align="center">List of Pending Quotations</h2>
        <table border="1" cellpadding="1" cellspacing="0"  style="border-collapse:collapse;font-size:12px; " align="center">
            <tr>
                <td align="left"  style="font-size:12px;"><b>#</b><br/><br/> <br/></td> 
            
                <td align="center" style="font-size:12px;"><b>Date Created</b> <br/><br/><br/> </td>
                <td align="center" style="font-size:12px;"><b>Company Name</b> <br/><br/><br/> </td>
                <td align="right"  style="font-size:12px;"><b>Contract Amount</b><br/><br/><br/> </td> 
            </tr>
            ' . implode($pending_details) . '
            
            <tr>
                <td colspan="3" align="right"><b>Grand Total: </b> &nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td align="right"><b>&#8369;  '.number_format($sub_total,2).'</b></td>
            </tr>
        </table>  
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <h2 align="center">List of Approved Quotations</h2>
        <table border="1" cellpadding="1" cellspacing="0"  style="border-collapse:collapse;font-size:12px; " align="center">
            <tr>
                <td align="left"  style="font-size:12px;"><b>#</b><br/><br/> <br/></td> 
            
                <td align="center" style="font-size:12px;"><b>Date Created</b> <br/><br/><br/> </td>
                <td align="center" style="font-size:12px;"><b>Company Name</b> <br/><br/><br/> </td>
                <td align="right"  style="font-size:12px;"><b>Contract Amount</b><br/><br/><br/> </td> 
            </tr>
            ' . implode($approved_details) . '
            
            <tr>
                <td colspan="3" align="right"><b>Grand Total: </b> &nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td align="right"><b>&#8369;  '.number_format($sub_totala,2).'</b></td>
            </tr>
        </table>  
        </div>
        ';
        
        return $html;
    }
}