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
		$quotations = $this->Quotation->find('all');
		
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
}
