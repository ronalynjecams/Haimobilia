<?php
App::uses('AppController', 'Controller');
/**
 * Collections Controller
 *
 * @property Collection $Collection
 * @property PaginatorComponent $Paginator
 */
class CollectionsController extends AppController {

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
		$this->Collection->recursive = 0;
		$this->set('collections', $this->Paginator->paginate());
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Collection->create();
			if ($this->Collection->save($this->request->data)) {
				$this->Session->setFlash(__('The collection has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The collection could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$quotations = $this->Collection->Quotation->find('list');
		$banks = $this->Collection->Bank->find('list');
		$this->set(compact('quotations', 'banks'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Collection->exists($id)) {
			throw new NotFoundException(__('Invalid collection'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Collection->save($this->request->data)) {
				$this->Session->setFlash(__('The collection has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The collection could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Collection.' . $this->Collection->primaryKey => $id));
			$this->request->data = $this->Collection->find('first', $options);
		}
		$quotations = $this->Collection->Quotation->find('list');
		$banks = $this->Collection->Bank->find('list');
		$this->set(compact('quotations', 'banks'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Collection->id = $id;
		if (!$this->Collection->exists()) {
			throw new NotFoundException(__('Invalid collection'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Collection->delete()) {
			$this->Session->setFlash(__('The collection has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The collection could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	public function all_list() {
		$this->loadModel('Quotation');
		$this->loadModel('Company');
		
		$status = $this->params['url']['status'];
		$undefined = "";
		
		$quotations = $this->Quotation->Collection->find('all',
		['conditions'=>['Collection.status'=>'verified'],
		 'fields' => ['DISTINCT Quotation.id', 'Quotation.grand_total']
		]);
		
		$col_pending = [];
		$col_accom = [];
		foreach($quotations as $quote_obj) {
			$quote = $quote_obj['Quotation'];
			$quote_grand_total = $quote['grand_total'];
			$quote_id = $quote['id'];
			
			$get_collections = $this->Collection->find('all',
				['conditions'=>['Collection.quotation_id'=>$quote_id],
								'fields'=>
								['Collection.id',
								 'Collection.paid_amount']]);
			$col_paid_amount = 0.000000;
			foreach($get_collections as $ret_col) {
				$col = $ret_col['Collection'];
				$col_id = $col['id'];
				$col_paid_amount += $col['paid_amount'];

				if($quote_grand_total!=$col_paid_amount) {
					$col_pending[] = $col_id;
				}
				else {
					$col_accom[] = $col_id;
				}
			}
		}
		
		if($status == "pending") {
			$cols = $this->Collection->find('all', ['conditions'=>
				['Collection.id'=>$col_pending]]);
		}
		elseif($status == "accomplished") {
			$cols = $this->Collection->find('all', ['conditions'=>
				['Collection.id'=>$col_accom]]);
		}
		else {
			$undefined = "Invalid Status.";
		}
		
		$clients = [];
		foreach($cols as $col_obj) {
			$quote_ent = $col_obj['Quotation'];
			$quote_id = $quote_ent['id'];
			$cli_id = $quote_ent['company_id'];
			
			$this->Company->recursive = -1;
			$clients[$quote_id] = $this->Company->findById($cli_id,
				'Company.name');
		}
		
		$this->set(compact('status', 'undefined', 'cols', 'clients'));
	}
	
	public function view() {
		$quote_id = $this->params['url']['id'];
		
		$this->loadModel('Quotation');
		$this->loadModel('QuotationProduct');
		$this->loadModel('DeliveryReceipt');
		
		$quotes_obj = $this->Quotation->findById($quote_id);
		$quote_prods = $this->QuotationProduct->find('all',
			['conditions'=>['quotation_id'=>$quote_id]]);
		$drs_obj = $this->DeliveryReceipt->findById($quote_id);
		
		$this->set(compact('quotes_obj', 'drs_obj', 'quote_prods'));
		
	}
	
	public function update(){
		$id = $this->params['url']['id'];
		$this->loadModel('Quotation');
		$this->loadModel('Bank');
		
		
		$quote_data = $this->Quotation->findById($id); 
		
		
		$collection_data = $this->Collection->findAllByQuotationId($id); 
		
		$banks = $this->Bank->find('all');
		
		
		
		
		$this->set(compact('quote_data', 'collection_data', 'banks'));
		 
	}
	
	public function processpayment(){
		
		$data = $this->request->data;
		$this->autoRender = false;
		
		$paid_amount = $data['paid_amount'];
        $ewt_amount = $data['ewt_amount'];
        $other_amount = $data['other_amount'];
        $cheque_date = $data['cheque_date'];
        $cheque_number = $data['cheque_number'];  
        $bank_id = $data['bank_id']; 
        $type = $data['type'];
        $quotation_id = $data['quotation_id'];
        
        $this->Collection->recursive = 0;
        $check_payment = $this->Collection->findAllByQuotationId($quotation_id);
        $date = date('Y-m-d h:m:i');
        
        if(count($check_payment) == 0){
        	$status = 'newest';
        } else{
        	$status = 'unverified';
        }
        
        if($type == 'cash'){
        	$this->Collection->create();
        	$this->Collection->set(array('quotation_id' => $quotation_id, 'type' => $type, 'paid_amount' => $paid_amount, 'ewt_amount', $ewt_amount, 'other_amount' => $other_amount, 'status' => $status, 'created' => $date, 'modified' => $date));
        }
        
        if($type == 'cheque'){
        	$this->Collection->create();
        	$this->Collection->set(array('quotation_id' => $quotation_id, 'type' => $type, 'paid_amount' => $paid_amount, 'cheque_date', $cheque_date, 'cheque_number' => $cheque_number, 'bank_id' => $bank_id, 'status' => $status, 'created' => $date, 'modified' => $date));
        }
        if($type == 'online'){
        	$this->Collection->create();
        	$this->Collection->set(array('quotation_id' => $quotation_id, 'type' => $type, 'paid_amount' => $paid_amount, 'ewt_amount', $ewt_amount, 'other_amount' => $other_amount, 'bank_id' => $bank_id, 'status' => $status, 'created' => $date, 'modified' => $date));
        }
        
        if ($this->Collection->save()){
            if($this->Auth->user('role') == 'sales_executive'){
                $quotation_status = 'moved';
            }else{
                $quotation_status = 'processed';
            }
            
        	if($status == 'newest'){
        		$this->loadModel('Quotation');
        		$this->Quotation->id=$quotation_id;
        		$this->Quotation->set(array(
        			'status'=>$quotation_status));
        		if($this->Quotation->save()){
    				return 'success';
        		}else{
        			return 'error';
        		}

        	}else{                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
    			return 'success';
        	}
    	} else{
    		return 'error';	
    	}
	}
	
	public function action() {
        $this->autoRender = false;
        $col_id = $this->request->data['id'];
        $action = $this->request->data['action'];
        
        $DS_Collection = $this->Collection->getDataSource();
        $this->Collection->id = $col_id;
        $this->Collection->set(['status'=>$action]);
        if($this->Collection->save()) {
        		$this->loadModel('Quotation');
        		$this->Quotation->id=$quotation_id;
        		$this->Quotation->set(array(
        			'status'=>$quotation_status));
        		if($this->Quotation->save()){
            $DS_Collection->commit();
        }
        else {
            $DS_Collection->rollback();
        }
        
        return json_encode($quote_id);
        exit;
    }
}