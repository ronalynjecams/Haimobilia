<?php

App::uses('AppController', 'Controller');

/**
 * Quotations Controller
 *
 * @property Quotation $Quotation
 * @property PaginatorComponent $Paginator
 */
class QuotationsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Quotation->recursive = 0;
        $this->set('quotations', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Quotation->exists($id)) {
            throw new NotFoundException(__('Invalid quotation'));
        }
        $options = array('conditions' => array('Quotation.' . $this->Quotation->primaryKey => $id));
        $this->set('quotation', $this->Quotation->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Quotation->create();
            if ($this->Quotation->save($this->request->data)) {
                $this->Session->setFlash(__('The quotation has been saved.'), 'default', array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The quotation could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
            }
        }
        $companies = $this->Quotation->Company->find('list');
        $users = $this->Quotation->User->find('list');
        $this->set(compact('companies', 'users'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Quotation->exists($id)) {
            throw new NotFoundException(__('Invalid quotation'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Quotation->save($this->request->data)) {
                $this->Session->setFlash(__('The quotation has been saved.'), 'default', array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The quotation could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
            }
        } else {
            $options = array('conditions' => array('Quotation.' . $this->Quotation->primaryKey => $id));
            $this->request->data = $this->Quotation->find('first', $options);
        }
        $companies = $this->Quotation->Company->find('list');
        $users = $this->Quotation->User->find('list');
        $this->set(compact('companies', 'users'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Quotation->id = $id;
        if (!$this->Quotation->exists()) {
            throw new NotFoundException(__('Invalid quotation'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Quotation->delete()) {
            $this->Session->setFlash(__('The quotation has been deleted.'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('The quotation could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function create() {
        //check if user has an ongoing create quotation
        $ongoing = $this->Quotation->find('first', array(
            'conditions' => array(
                'Quotation.user_id' => $this->Auth->user('id'),
                'Quotation.status' => 'ongoing'
        )));
        
        
        if(count($ongoing)!=0){
            //meaning meron syang ongoing na ginagawang quotation
            $quote_data = $ongoing; //retrieved data from existing ongoing quotation
        }else{
            //walang existing so data magcreate na ng data 
            $terms_information = '<h3>I. PRICE</h3>
                                            <ol>
                                            <li>
                                            <p>Price quoted is based on the specifications provided by HAIMOBILIA ENTERPRISE and accepted by the client or vice-versa.</p>
                                            </li>
                                            <li>
                                            <p>Prices may vary without prior notice and shall not be considered final unless and until this Quotation Proposal&nbsp;has been signed and accepted.&nbsp;</p>
                                            </li>
                                            </ol>
                                            <h3>II. AVAILABILITY OF STOCKS</h3>
                                            <ol>
                                            <li>
                                            <p>10 days from the date of proposal, subject to a written confirmation thereafter. Stock availability may vary without prior notice.</p>
                                            </li>
                                            </ol>
                                            <h3>III. PAYMENT</h3>
                                            <ol>
                                            <li>
                                            <p>A<strong> FIFTY PERCENT (50%)</strong> downpayment shall be required unless HAIMOBILIA ENTERPRISE and the Client shall otherwise agree.</p>
                                            </li>
                                            <li>
                                            <p><strong>Cash / Dated Check </strong>&nbsp; on delivery shall be required unless HAIMOBILIA ENTERPRISE and the Client shall otherwise agree.</p>
                                            </li>
                                            <li>
                                            <p>The balance of the quoted and agreed price shall be paid upon completion and full delivery of the project.</p>
                                            </li>
                                            </ol>
                                            <h3>IV. DELIVERY</h3>
                                            <ol>
                                            <li>
                                            <p>For standard items, delivery shall be made within a period of 5-7 working days upon receipt of purchase order,</p>
                                            <p>down payment, and complete specifications. Specifications may include size, materials, colors, texture</p>
                                            <p>and others that must be approved by the client.</p>
                                            </li>
                                            <li>
                                            <p>For Indent Items, delivery shall be made within a period of 45-60 working days upon receipt of purchase order,</p>
                                            <p>down payment, and complete specifications.</p>
                                            <p>Specifications may include size, materials, colors, texture and others that must be approved by the client.</p>
                                            </li>
                                            </ol>
                                            <h3>VIII. PENALTY</h3> 
                                            <ol>
                                            <li>
                                            <p>A Penalty of&nbsp;<strong>One Percent (1%) monthly</strong>&nbsp;on all unpaid items shall be applied if Client fails to settle the obligation on the due date.&nbsp;</p>
                                            </li>
                                            <li>
                                            <p>When the due date falls on a holiday or weekend, it shall be considered due on the next business day for purposes of ascertain the date when payment and penalties may be demanded.</p>
                                            </li>
                                            <li>
                                            <p>In case of return of items without the fault of HAIMOBILIA ENTERPRISE&nbsp;a penalty of THIRTY PERCENT (30%) on all items returned after delivery/ installation shall be imposed.</p>
                                            </li>
                                            <li>
                                            <p>All items delivered shall remain properties of HAIMOBILIA ENTERPRISE&nbsp;until fully paid by client.</p>
                                            </li>
                                            <li>
                                            <p>A change of mind on the part of the Client shall not entitle latter to an exchange or refund under Republic Act 7394, otherwise known as "The Consumer Act of the Philippines."</p>
                                            </li>
                                            </ol>';
            
            
            
            // $terms_information = '<h3>I. PRICE</h3>
            //                                 <ol>
            //                                 <li>
            //                                 <p>Price quoted is based on the specifications provided by HAIMOBILIA ENTERPRISE and accepted by the client and vice-versa.</p>
            //                                 </li>
            //                                 <li>
            //                                 <p>Prices may vary without prior notice and shall not be considered final unless and until this Quotation Proposal&nbsp;has been signed and accepted.&nbsp;</p>
            //                                 </li>
            //                                 </ol>
            //                                 <h3>II. AVAILABILITY OF STOCKS</h3>
            //                                 <ol>
            //                                 <li>
            //                                 <p>10 days from the date of proposal, subject to a written confirmation thereafter. Stock availability may vary without prior notice.</p>
            //                                 </li>
            //                                 </ol>
            //                                 <h3>III. PAYMENT</h3>
            //                                 <ol>
            //                                 <li>
            //                                 <p>A&nbsp;<strong>FIFTY PERCENT (50%)</strong>&nbsp;downpayment shall be required unless HAIMOBILIA ENTERPRISE and the Client shall otherwise agree.</p>
            //                                 </li>
            //                                 <li>
            //                                 <p>The balance of the quoted and agreed price shall be paid upon completion and full delivery of the project.</p>
            //                                 </li>
            //                                 </ol>
            //                                 <h3>IV. DELIVERY</h3>
            //                                 <ol>
            //                                 <li>
            //                                 <p>For standard items, delivery shall be made within a period of 3-7 working days upon receipt of purchase order,</p>
            //                                 <p>down payment, and complete specifications. Specifications may include size, materials, colors, texture</p>
            //                                 <p>and others that must be approved by the client.</p>
            //                                 </li>
            //                                 <li>
            //                                 <p>For Indent Items, delivery shall be made within a period of 45-60 working days upon receipt of purchase order,</p>
            //                                 <p>down payment, and complete specifications.</p>
            //                                 <p>Specifications may include size, materials, colors, texture and others that must be approved by the client.</p>
            //                                 </li>
            //                                 </ol>
            //                                 <h3>VIII. PENALTY</h3>
            //                                 <p>&nbsp;</p>
            //                                 <ol>
            //                                 <li>
            //                                 <p>A Penalty of&nbsp;<strong>One Percent (1%) daily</strong>&nbsp;on all unpaid items shall be applied if Client fails to settle the obligation on the due date.&nbsp;</p>
            //                                 </li>
            //                                 <li>
            //                                 <p>When the due date falls on a holiday or weekend, it shall be considered due on the next business day for purposes of ascertain the date when payment and penalties may be demanded.</p>
            //                                 </li>
            //                                 <li>
            //                                 <p>In case of return of items without the fault of HAIMOBILIA ENTERPRISE&nbsp;a penalty of THIRTY PERCENT (30%) on all items returned after delivery/ installation shall be imposed.</p>
            //                                 </li>
            //                                 <li>
            //                                 <p>All items delivered shall remain properties of HAIMOBILIA ENTERPRISE&nbsp;until fully paid by client.</p>
            //                                 </li>
            //                                 <li>
            //                                 <p>A change of mind on the part of the Client shall not entitle latter to an exchange or refund under Republic Act 7394, otherwise known as "The Consumer Act of the Philippines."</p>
            //                                 </li>
            //                                 </ol>';
            // $terms_information = ' <h3>I. PRICE</h3> <ol><li><p>All prices are quoted in Philippine Pesos are inclusive of VAT, delivered and installed at site within Metro Manila. </p></li> <li><p>Price quoted is based on the specifications provided by JECAMS INC. and accepted by the client and vice-versa. Changes in design or specifications after approval of proposal may be subject to price adjustment as the parties may agree.</p></li> <li><p>Prices may vary without prior notice and shall not be considered final unless and until this Quotation Proposal has been signed and accepted.</p></li> </ol> <h3>II. AVAILABILITY OF STOCKS</h3> <ol> <li><p>10 days from the date of proposal, subject to a written confirmation thereafter. Stock availability may vary without prior notice.</p></li> </ol> <h3>III. PAYMENT</h3> <ol> <li><p>A <strong>FIFTY PERCENT (50%)</strong> downpayment shall be required unless JECAMS, INC. and the Client shall otherwise agree.</p></li> <li><p>The balance of the quoted and agreed price shall be paid upon completion and full delivery of the project, on fitout projects, the balance shall be paid through progress billing.</p></li> <li><p>In case of replacements or non-acceptance of some items due to defect or failure to abide by specifications, only that portion pertaining to the value of such items to be replaced or unaccepted shall be left unpaid before delivery, but the entire balance for the items delivered and accepted must be paid in full upon completion and acceptance.</p></li> <li><p>Any payment made through bank is acceptable. However, in case of check payment subject to clearing, actual payment shall be considered made only upon clearing of such check and not on the date of deposit. In cases of bank transfers, payment shall; be considered upon actual crediting of the payment to JECAMS account.</p></li> <li><p>Provincial clients are encouraged to pay through bank and a copy of the deposit slip must be faxed or e-mailed to JECAMS, INC. prior to delivery/installation. All checks should be payable to JECAMS INC. only and any payment made to other entities or individuals whether employee or agent shall not be recognized.</p></li> </ol><h3>IV. DELIVERY</h3> <ol> <li><p>For Standard items, delivery shall be made within a period of 10-20 working days upon receipt of purchase order, down payment, and complete specifications.</p></li> <li><p>For Indent Items, delivery shall be made within a period of 45-60 working days upon receipt of purchase order, down payment, and complete specifications.</p></li> <li><p>Delivery in provincial areas such as in the Visayas and Mindanao, a forwarder suggested and chosen by the Client shall make the actual delivery. It is understood that the forwarder has the responsibility over the items upon JECAMS’ delivery of such items in good order condition.</p></li> <li><p>Delivery and installation of panels, partitions, workstations, furniture and supplies shall be scheduled upon site visit and upon the instructions of the Client. However, it is understood that the site shall be clean, ready and clear of any obstruction or debris to avoid delay, losses or damage to the item(s).</p></li> <li><p>In case of delay in the installation due to the Client’s fault, JECAMS INC. may charge the client accordingly, which shall be that amount corresponding to the manpower expense incurred due to the delay, lost income or damage incurred.  Elevator access, electricity/power supply must be arranged by the Client prior to delivery and installation. Damaged/missing items should be reported immediately.</p></li> <li><p>Delay due to fortuitous even or force majeure shall not make liable JECAMS, INC. for any damages. Likewise, if the delay in the installation was caused by a fortuitous event or force majeure, Client shall not be answerable to JECAMS, INC. for damages.</p></li> </ol><h3>V. WARRANTY AND AFTER SALES SUPPORT</h3> <ol> <li><p>A Standard <strong>One (1) Year Manufacturer’s Warranty</strong> against factory defect from date of delivery in parts and services shall apply. To ascertain the actual date of delivery, that appearing in the Delivery Receipt shall prevail.</p></li> <li><p>Further, the warranty does not include upgrades and relocation, damage to items caused by an accident, improper use or abuse of the items, alterations, scratches, dents or repairs done by a person other than JECAMS, INC. Service Agents, usage of component parts not supplied by JECAMS INC, poor operating environment, fire and other natural calamities. Fabrics, leatherette, mesh, and the like are not included in the warranty.</p></li> </ol><h3>VI. INCLUSIONS</h3> <ol> <li><p>Only the specific product details, layout, and drawing hardcopies are included in this proposal and warranty.</p></li> </ol> </li> <h3>VII. LIMITATIONS</h3> <ol> <li><p>Items not mentioned in the proposed deliverables, cost breakdown, and other conditions shall not form part of this proposal. Fees related to bank charges, bonds, failed pick up or delivery, re-configuration or re-consignment shall require review of the cost implication and shall necessitate a written request, prior to approval. The charges or expenses mentioned in the preceding sentence shall be considered for the account of the Client in the absence of any specific agreement between the Parties.</p></li> </ol><h3>VIII. PENALTY</h3> <ol> <li><p>A Penalty of <strong>One Percent (1%) daily</strong> on all unpaid items shall be applied if Client fails to settle the obligation on the due date. For purposes of ascertaining when the due date is, it shall be the date when payment should have been made based on the completion and delivery as agreed upon by the Parties.</p></li> <li><p>When the due date falls on a holiday or weekend, it shall be considered due on the next business day for purposes of ascertain the date when payment and penalties may be demanded.</p></li> <li><p>In case of return of items without the fault of JECAMS, INC. a penalty of THIRTY PERCENT (30%) on all items returned after delivery/ installation shall be imposed.</p></li> <li><p>In case of cancellation of order seven (7) days after the issuance and receipt by JECAMS, INC. of the Purchase Order, a penalty of THIRTY PERCENT (30%) on all items shall be imposed.</p></li> <li><p>All items delivered shall remain properties of JECAMS INC until fully paid by client.</p></li> <li><p>A change of mind on the part of the Client shall not entitle latter to an exchange or refund under Republic Act 7394, otherwise known as "The Consumer Act of the Philippines."</p></li> </ol><h3>IX. NON - DISCLOSURE</h3> <ol> <li><p>Any information contained in the proposal shall be treated as confidential and shall not be disclosed to anyone except to the agents, employees or representatives of the Client duly authorized. Likewise, JECAMS, INC. shall keep confidential all the specifications and details pertaining to the Client or the items purchased or ordered. Any breach of this Confidentiality Clause shall be a valid ground for the rescission of this Agreement between the Parties and may even expose the violating party to liability.</p></li> <li><p>Should you have favourably considered our proposal, please sign on the Conforme Portion below to signify your intention of availing our products and services.</p></li> </ol><br> ';
            
            // $terms_information = ' '
            //         . '<h3>I. PRICE</h3> '
            //         . '<ol><li><p>All prices are quoted in Philippine Pesos are inclusive of VAT, delivered and installed at site within Metro Manila. </p></li> '
            //         . '<li><p>Price quoted is based on the specifications provided by JECAMS INC. and accepted by the client and vice-versa. Changes in design or specifications after approval of proposal may be subject to price adjustment as the parties may agree.</p></li> '
            //         . '<li><p>Prices may vary without prior notice and shall not be considered final unless and until this Quotation Proposal has been signed and accepted.</p></li> '
            //         . '</ol> '
            //         . '<h3>II. AVAILABILITY OF STOCKS</h3> '
            //         . '<ol> <li><p>10 days from the date of proposal, subject to a written confirmation thereafter. Stock availability may vary without prior notice.</p></li> '
            //         . '</ol> '
            //         . '<h3>III. PAYMENT</h3> <ol> <li><p>A <strong>FIFTY PERCENT (50%)</strong> downpayment shall be required unless JECAMS, INC. and the Client shall otherwise agree.</p></li> '
            //         . '<li><p>The balance of the quoted and agreed price shall be paid upon completion and full delivery of the project, on fitout projects, the balance shall be paid through progress billing.</p></li> '
            //         . '<li><p>In case of replacements or non-acceptance of some items due to defect or failure to abide by specifications, only that portion pertaining to the value of such items to be replaced or unaccepted shall be left unpaid before delivery, but the entire balance for the items delivered and accepted must be paid in full upon completion and acceptance.</p></li> '
            //         . '<li><p>Any payment made through bank is acceptable. However, in case of check payment subject to clearing, actual payment shall be considered made only upon clearing of such check and not on the date of deposit. In cases of bank transfers, payment shall; be considered upon actual crediting of the payment to JECAMS account.</p></li> '
            //         . '<li><p>Provincial clients are encouraged to pay through bank and a copy of the deposit slip must be faxed or e-mailed to JECAMS, INC. prior to delivery/installation. All checks should be payable to JECAMS INC. only and any payment made to other entities or individuals whether employee or agent shall not be recognized.</p></li> '
            //         . '</ol>'
            //         . '<h3>IV. DELIVERY</h3> <ol> <li><p>For Standard items, delivery shall be made within a period of 10-20 working days upon receipt of purchase order, down payment, and complete specifications.</p></li> '
            //         . '<li><p>For Indent Items, delivery shall be made within a period of 45-60 working days upon receipt of purchase order, down payment, and complete specifications.</p></li> '
            //         . '<li><p>Delivery in provincial areas such as in the Visayas and Mindanao, a forwarder suggested and chosen by the Client shall make the actual delivery. It is understood that the forwarder has the responsibility over the items upon JECAMS’ delivery of such items in good order condition.</p></li> '
            //         . '<li><p>Delivery and installation of panels, partitions, workstations, furniture and supplies shall be scheduled upon site visit and upon the instructions of the Client. However, it is understood that the site shall be clean, ready and clear of any obstruction or debris to avoid delay, losses or damage to the item(s).</p></li> '
            //         . '<li><p>In case of delay in the installation due to the Client’s fault, JECAMS INC. may charge the client accordingly, which shall be that amount corresponding to the manpower expense incurred due to the delay, lost income or damage incurred.  Elevator access, electricity/power supply must be arranged by the Client prior to delivery and installation. Damaged/missing items should be reported immediately.</p></li> '
            //         . '<li><p>Delay due to fortuitous even or force majeure shall not make liable JECAMS, INC. for any damages. Likewise, if the delay in the installation was caused by a fortuitous event or force majeure, Client shall not be answerable to JECAMS, INC. for damages.</p></li> '
            //         . '</ol>'
            //         . '<h3>V. WARRANTY AND AFTER SALES SUPPORT</h3> '
            //         . '<ol> <li><p>A Standard <strong>One (1) Year Manufacturer’s Warranty</strong> against factory defect from date of delivery in parts and services shall apply. To ascertain the actual date of delivery, that appearing in the Delivery Receipt shall prevail.</p></li> '
            //         . '<li><p>Further, the warranty does not include upgrades and relocation, damage to items caused by an accident, improper use or abuse of the items, alterations, scratches, dents or repairs done by a person other than JECAMS, INC. Service Agents, usage of component parts not supplied by JECAMS INC, poor operating environment, fire and other natural calamities. Fabrics, leatherette, mesh, and the like are not included in the warranty.</p></li> '
            //         . '</ol>'
            //         . '<h3>VI. INCLUSIONS</h3> '
            //         . '<ol> <li><p>Only the specific product details, layout, and drawing hardcopies are included in this proposal and warranty.</p></li> </ol> </li> '
            //         . '<h3>VII. LIMITATIONS</h3> <ol> '
            //         . '<li><p>Items not mentioned in the proposed deliverables, cost breakdown, and other conditions shall not form part of this proposal. Fees related to bank charges, bonds, failed pick up or delivery, re-configuration or re-consignment shall require review of the cost implication and shall necessitate a written request, prior to approval. The charges or expenses mentioned in the preceding sentence shall be considered for the account of the Client in the absence of any specific agreement between the Parties.</p></li> '
            //         . '</ol>'
            //         . '<h3>VIII. PENALTY</h3> '
            //         . '<ol> <li><p>A Penalty of <strong>One Percent (1%) daily</strong> on all unpaid items shall be applied if Client fails to settle the obligation on the due date. For purposes of ascertaining when the due date is, it shall be the date when payment should have been made based on the completion and delivery as agreed upon by the Parties.</p></li> '
            //         . '<li><p>When the due date falls on a holiday or weekend, it shall be considered due on the next business day for purposes of ascertain the date when payment and penalties may be demanded.</p></li> '
            //         . '<li><p>In case of return of items without the fault of JECAMS, INC. a penalty of THIRTY PERCENT (30%) on all items returned after delivery/ installation shall be imposed.</p></li> '
            //         . '<li><p>In case of cancellation of order seven (7) days after the issuance and receipt by JECAMS, INC. of the Purchase Order, a penalty of THIRTY PERCENT (30%) on all items shall be imposed.</p></li> '
            //         . '<li><p>All items delivered shall remain properties of JECAMS INC until fully paid by client.</p></li> <li><p>A change of mind on the part of the Client shall not entitle latter to an exchange or refund under Republic Act 7394, otherwise known as "The Consumer Act of the Philippines."</p></li> '
            //         . '</ol>'
            //         . '<h3>IX. NON - DISCLOSURE</h3> '
            //         . '<ol> <li><p>Any information contained in the proposal shall be treated as confidential and shall not be disclosed to anyone except to the agents, employees or representatives of the Client duly authorized. Likewise, JECAMS, INC. shall keep confidential all the specifications and details pertaining to the Client or the items purchased or ordered. Any breach of this Confidentiality Clause shall be a valid ground for the rescission of this Agreement between the Parties and may even expose the violating party to liability.</p></li> '
            //         . '<li><p>Should you have favourably considered our proposal, please sign on the Conforme Portion below to signify your intention of availing our products and services.</p></li> '
            //         . '</ol><br> ';
            $dateToday = date("Hymds");
            $milliseconds = round(microtime(true) * 1000);
            $newstring = substr($milliseconds, -3);
            $quote_number = $newstring . '' . $dateToday;
             
            $quote_exist = $this->Quotation->find('count', array(
                'conditions' => array(
                    'Quotation.quote_number' => $quote_number
            )));

            if ($quote_exist == 0) {
                $quote_no = $quote_number;
            } else {
                $news = substr($milliseconds, -4);
                $quote_no = $news . '' . $dateToday;
            }
            $this->Quotation->create();
            $this->Quotation->set(array(
                'quote_number' => $quote_no,
                'user_id' => $this->Auth->user('id'),
                'status' => 'ongoing',
                'terms' => $terms_information, 
            ));
            $this->Quotation->save();
            $id = $this->Quotation->getLastInsertID(); 
            $quote_data = $this->Quotation->find('first', array(
                'conditions' => array('Quotation.user_id' => $this->Auth->user('id'), 'Quotation.status' => 'ongoing')
            )); 
        }
        
        $this->set(compact('quote_data'));
         
        
        $this->loadModel('Company');
            $companies = $this->Company->find('all', [
                'conditions' => [
                    'Company.type' => 'clients',
                    'Company.user_id' => $this->Auth->user('id')
                ]
            ]);
            
        $this->loadModel('QuotationProduct');
        $quote_prods = $this->QuotationProduct->findAllByQuotationId($quote_data['Quotation']['id']);
       
        $this->loadModel('Product');
        $product_lists = $this->Product->find('all');
        
        $this->set(compact('companies', 'quote_prods', 'product_lists' ));
        

    }

    public function saveCreateQuotation() {
        $this->autoRender = false;
        $data = $this->request->data;
        $id = $data['id'];
        $Qfield = $data['Qfield'];
        $value = $data['value'];

        if($Qfield != 'terms'){  
        
            if($Qfield == 'company_id'){ 
                $this->loadModel('Company');
                
                // $this->Company->recursive=-1;
                $address = $this->Company->find('first',[
                    'conditions'=>['Company.id' =>$value],
                    'fields'=>['Company.address']
                    ]); 
                $shipping_address = $address['Company']['address'];
                $billing_address = $address['Company']['address'];
                
                        $this->Quotation->id = $id;
                        $this->Quotation->set(array(
                            $Qfield => $value,
                            'shipping_address' => $shipping_address,
                            'billing_address' => $billing_address 
                        ));
                        if ($this->Quotation->save()) {
                            echo json_encode($data); 
                        } else {
                            echo json_encode('invalid dataa');
                        }
            }else{ 
               

                    $this->Quotation->id = $id;
                    $this->Quotation->set(array(
                        $Qfield => $value, 
                    ));
                    if ($this->Quotation->save()) {
                        echo json_encode($data); 
                    } else {
                        echo json_encode('invalid dataq');
                    }
            }
        }else{
            
            $this->Quotation->id = $id;
            $this->Quotation->set(array(
                $Qfield => $value,
                'status' => 'pending', 
                'shipping_address' => $data['shipping_address'],
                'billing_address' => $data['billing_address']
            ));
            if ($this->Quotation->save()) {
                echo json_encode($data); 
            } else {
                echo json_encode('invalid data');
            }
        }
        exit;
    }
    
    public function saveProductQuotation() {
        $this->loadModel('QuotationProduct');
        $this->autoRender = false;
        $data = $this->request->data;
        $product_id = $data['product_id'];
        $qty = $data['qty'];
        $list_price = $data['list_price'];
        $sale_price = $data['sale_price'];
        $description = $data['description'];
        $quotation_id = $data['quotation_id'];

        $tol_price = $list_price * $qty;

        $this->QuotationProduct->create();
        $this->QuotationProduct->set([
            "quotation_id" => $quotation_id,
            "product_id" => $product_id,
            "qty" => $qty,
            "list_price" => $list_price,
            "description" => $description,
            "total_price" => $tol_price,
            "user_id" => $this->Auth->user('id'),
        ]);
        if ($this->QuotationProduct->save()) { 
            //recompute quotation total
        //     $total = $this->QuotationProduct->find('all', array(
        //         array('fields' => array('sum(QuotationProduct.total_price) AS sub_total'),
        //         'conditions'=>array('QuotationProduct.quotation_id'=>$quotation_id))));
                 
        // $this->loadModel('QuotationProduct');
            $this->QuotationProduct->recursive =-1;
            $total = $this->QuotationProduct->find('first', array( 'fields' => array('sum(QuotationProduct.total_price) AS sub_total'),
                'conditions'=>array('QuotationProduct.quotation_id'=>$quotation_id)));
                
            $quotedata = $this->Quotation->findById($quotation_id);
            $delivery_amount = $quotedata['Quotation']['delivery_amount'];
            $installation_amount = $quotedata['Quotation']['installation_amount'];
            $discount = $quotedata['Quotation']['discount'];
            
            $grand_total = ($total[0]['sub_total'] - $discount)+$delivery_amount+$installation_amount;
            
            $this->Quotation->id = $quotation_id;
            $this->Quotation->set([
                'sub_total' => $total[0]['sub_total'],
                'grand_total' =>$grand_total
                ]);
            if($this->Quotation->save()){
                echo json_encode($data); 
            }
        }
        exit;
    }
    
    public function delete_product(){
        $this->loadModel('QuotationProduct');
        $this->autoRender = false;
        $data = $this->request->data;
        
        $quotation_product_id = $data['quotation_product_id'];
        $quotation_id = $data['quotation_id'];
         
        if($this->QuotationProduct->delete($quotation_product_id)){ 
            
            $this->QuotationProduct->recursive =-1;
            $total = $this->QuotationProduct->find('first', array( 'fields' => array('sum(QuotationProduct.total_price) AS sub_total'),
                'conditions'=>array('QuotationProduct.quotation_id'=>$quotation_id)));
                
            $quotedata = $this->Quotation->findById($quotation_id);
            $delivery_amount = $quotedata['Quotation']['delivery_amount'];
            $installation_amount = $quotedata['Quotation']['installation_amount'];
            $discount = $quotedata['Quotation']['discount'];
            
            $grand_total = ($total[0]['sub_total'] - $discount)+$delivery_amount+$installation_amount;
            
            $this->Quotation->id = $quotation_id;
            $this->Quotation->set([
                'sub_total' => $total[0]['sub_total'],
                'grand_total' =>$grand_total
                ]);
            if($this->Quotation->save()){ 
                echo json_encode($data);
                // return json_encode($data);
            }
            
            
            
            
        }
        
    }


    public function all_list() {
        $status = $this->params['url']['status'];
        $role = $this->Auth->user('role');
        $user_id = $this->Auth->user('id');
        
        $this->loadModel('Collection');
        
        if($role!="sales_executive") {
            $quotations = $this->Quotation->find('all', ['conditions'=>
                ['status'=>$status]]);
        }
        else {
            $quotations = $this->Quotation->find('all', ['conditions'=>
                ['Quotation.status'=>$status,
                 'Quotation.user_id'=>$user_id]]);
        }
        
        $cols_obj = [];
        foreach($quotations as $quotation_obj) {
            $quotation = $quotation_obj['Quotation'];
            $quote_id = $quotation['id'];
            
            $this->Collection->recursive = -1;
            $cols_obj[$quote_id] = $this->Collection->find('all',
                ['conditions'=>['quotation_id'=>$quote_id,
                                'status'=>'verified'],
                                'fields'=>['paid_amount', 'ewt_amount', 'other_amount']]);
        }
        $this->set(compact('status','quotations', 'cols_obj'));
    }
    
    public function saveComputeQuotationProcess(){
        $this->loadModel('QuotationProduct');
        $this->autoRender = false;
        $data = $this->request->data;
        
        $quotation_id = $data['quotation_id'];
        $value = $data['value'];
        $Qfield = $data['Qfield'];
         
        $quote_data = $this->Quotation->findById($quotation_id);
        
             
                 
            $prod_total = $this->QuotationProduct->find('first', array( 'fields' => array('sum(QuotationProduct.total_price) AS sub_total'),
                'conditions'=>array('QuotationProduct.quotation_id'=>$quotation_id)));
                
        if($Qfield == 'discount'){
            $discount = $value; 
            $delivery_amount = $quote_data['Quotation']['delivery_amount'];
            $installation_amount = $quote_data['Quotation']['installation_amount'];
            
            $sub_total = $prod_total[0]['sub_total'];
            
            $grand_total = ($sub_total - $discount) + ($delivery_amount + $installation_amount); 
            //get subtotal , delivery_amount, installation_amount. then compute grand total 
        }else if($Qfield == 'delivery_amount'){
            $discount = $quote_data['Quotation']['discount'];
            $delivery_amount = $value; 
            $installation_amount = $quote_data['Quotation']['installation_amount'];
            
            $sub_total = $prod_total[0]['sub_total'];
            
            $grand_total = ($sub_total - $discount) + ($delivery_amount + $installation_amount); 
            //get subtotal , delivery_amount, installation_amount. then compute grand total 
        }else if($Qfield == 'installation_amount'){
            $discount = $quote_data['Quotation']['discount'];
            $delivery_amount = $quote_data['Quotation']['delivery_amount'];
            $installation_amount =  $value; 
            
            $sub_total = $prod_total[0]['sub_total'];
            
            $grand_total = ($sub_total - $discount) + ($delivery_amount + $installation_amount); 
            //get subtotal , delivery_amount, installation_amount. then compute grand total 
        }
        
        $this->Quotation->id = $quotation_id;
        $this->Quotation->set([
            'discount' => $discount,
            'sub_total' => $sub_total,
            'delivery_amount' => $delivery_amount,
            'installation_amount' => $installation_amount, 
            'grand_total' => $grand_total, 
            ]);
        if($this->Quotation->save()){
            echo json_encode($data); 
        }
    }
    
    public function action() {
        $this->autoRender = false;
        $quote_id = $this->request->data['id'];
        $action = $this->request->data['action'];
        
        $DS_Quotation = $this->Quotation->getDataSource();
        $this->Quotation->id = $quote_id;
        $this->Quotation->set(['status'=>$action]);
        if($this->Quotation->save()) {
            $DS_Quotation->commit();
        }
        else {
            $DS_Quotation->rollback();
        }
        
        return json_encode($quote_id);
        exit;
    }
    
    

    public function update() {
        $id = $this->params['url']['id']; 
        $quote_data = $this->Quotation->findById($id);
        $this->set(compact('quote_data'));
        
        
        
        $this->loadModel('Company');
            $companies = $this->Company->find('all', [
                'conditions' => [
                    'Company.type' => 'clients',
                    'Company.user_id' => $this->Auth->user('id')
                ]
            ]);
            
        $this->loadModel('QuotationProduct');
        $quote_prods = $this->QuotationProduct->findAllByQuotationId($quote_data['Quotation']['id']);
       
        $this->loadModel('Product');
        $product_lists = $this->Product->find('all');
        
        $this->set(compact('companies', 'quote_prods', 'product_lists' ));
    }
}
