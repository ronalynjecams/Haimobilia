<?php
App::uses('AppController', 'Controller');
/**
 * DeliveryReceipts Controller
 *
 * @property DeliveryReceipt $DeliveryReceipt
 * @property PaginatorComponent $Paginator
 */
class DeliveryReceiptsController extends AppController {

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
		$this->DeliveryReceipt->recursive = 0;
		$this->set('deliveryReceipts', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->DeliveryReceipt->exists($id)) {
			throw new NotFoundException(__('Invalid delivery receipt'));
		}
		$options = array('conditions' => array('DeliveryReceipt.' . $this->DeliveryReceipt->primaryKey => $id));
		$this->set('deliveryReceipt', $this->DeliveryReceipt->find('first', $options));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->DeliveryReceipt->exists($id)) {
			throw new NotFoundException(__('Invalid delivery receipt'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->DeliveryReceipt->save($this->request->data)) {
				$this->Session->setFlash(__('The delivery receipt has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The delivery receipt could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('DeliveryReceipt.' . $this->DeliveryReceipt->primaryKey => $id));
			$this->request->data = $this->DeliveryReceipt->find('first', $options);
		}
		$quotations = $this->DeliveryReceipt->Quotation->find('list');
		$users = $this->DeliveryReceipt->User->find('list');
		$this->set(compact('quotations', 'users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->DeliveryReceipt->id = $id;
		if (!$this->DeliveryReceipt->exists()) {
			throw new NotFoundException(__('Invalid delivery receipt'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DeliveryReceipt->delete()) {
			$this->Session->setFlash(__('The delivery receipt has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The delivery receipt could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	public function add() {
		$this->loadModel('Quotation');
		$this->loadModel('DeliveryReceipt');
		$this->DeliveryReceipt->recursive = -1;
		$delivery_receipts = $this->DeliveryReceipt->find('all',
			['conditions'=>['DeliveryReceipt.status'=>'delivered'],
			'fields'=>['quotation_id']]);
		
		$quotation_ids = [];
		foreach($delivery_receipts as $delivery_receipt) {
			$del_rec = $delivery_receipt['DeliveryReceipt'];
			$quotation_ids[] = $del_rec['quotation_id'];
		}
			
		$quotations = $this->Quotation->find('all', ['conditions'=>
			['NOT'=>['Quotation.id'=>$quotation_ids]]]);
		$this->set(compact('quotations'));
	}
	
	public function create() {
		$this->autoRender = false;
		$data = $this->request->data;
		$quotation_id = $data['quotation'];
		$date = $data['date'];
		$type = $data['type'];
		$amount = $data['amount'];
		$booking_code_tmp = $data['booking_code'];
		$userin = $this->Auth->user('id');
		$time = date("YmdHmi");
		$dr_number = 'Haimo-'.$time;
		
		$delivery_receipts_set = ['quotation_id'=>$quotation_id,
								  'dr_number'=>$dr_number,
								  'delivery_date'=>$date,
								  'user_id'=>$userin,
								  'status'=>'pending',
								  'dr_type'=>$type,
								  'amount'=>$amount,
								  'booking_code'=>$booking_code_tmp];
		
		$DS_DeliveryReceipts = $this->DeliveryReceipt->getDataSource();
		$DS_DeliveryReceipts->begin();
		
		$this->DeliveryReceipt->create();
		$this->DeliveryReceipt->set($delivery_receipts_set);
		
		if($this->DeliveryReceipt->save()) {
			echo json_encode("DeliveryReceipt saved");
			$DS_DeliveryReceipts->commit();
		}
		else {
			return json_encode();
			exit;
		}
		
		return json_encode($dr_number);
		exit;
	}
	
	public function all_list() {
		$this->loadModel('Quotation');
		
		$status = $this->params['url']['status'];
		$drs = $this->DeliveryReceipt->find('all',
			['conditions'=>['DeliveryReceipt.status'=>$status]]);
		
		$companies = [];
		foreach($drs as $dr_obj) {
			$dr = $dr_obj['DeliveryReceipt'];
			$dr_quotation_id = $dr['quotation_id'];
			
			$companies[$dr_quotation_id] = $this->Quotation->findById($dr_quotation_id);
		}	
		
		$this->set(compact('status', 'drs', 'companies'));
	}
	
	public function action() {
        $this->autoRender = false;
        $id = $this->request->data['id'];
        $action = $this->request->data['action'];
        
        $DS_DeliveryReceipt= $this->DeliveryReceipt->getDataSource();
        $this->DeliveryReceipt->id = $id;
        $this->DeliveryReceipt->set(['status'=>$action]);
        if($this->DeliveryReceipt->save()) {
            $DS_DeliveryReceipt->commit();
        }
        else {
            $DS_DeliveryReceipt->rollback();
        }
        
        return json_encode($quote_id);
        exit;
    }
        public function update_booking_process(){
        
        $this->autoRender = false;
        $this->response->type('json');
        $dd = $this->request->data;
        $id = $dd['dr_id'];
        $booking_code = $dd['ubooking_code']; 
        $amouont = $dd['uamount']; 
        $dr_type = $dd['utype']; 
         
        $this->DeliveryReceipt->id = $id;
        $this->DeliveryReceipt->set(array(
            'booking_code'=>$booking_code,
            'amount'=>$amouont,
            'dr_type'=>$dr_type,
            ));
        if($this->DeliveryReceipt->save()) { 
            return json_encode($id);
        } 
        exit;
    }


    public function get_info() {
        $this->autoRender = false;
        $this->response->type('json');
        if ($this->request->is('ajax')) {
            $id = $this->request->query['id'];
            $this->DeliveryReceipt->recursive = -1;
            $lead = $this->DeliveryReceipt->findById($id);
            return (json_encode($lead['DeliveryReceipt']));
            exit;
        }
    }
}
