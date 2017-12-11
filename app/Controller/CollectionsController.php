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
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Collection->exists($id)) {
			throw new NotFoundException(__('Invalid collection'));
		}
		$options = array('conditions' => array('Collection.' . $this->Collection->primaryKey => $id));
		$this->set('collection', $this->Collection->find('first', $options));
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
		// $this->loadModel('Quotation');
		// $status = $this->params['url']['status'];
		// if($status == "pending") {
		// 	$collections = $this->Quotation->find('all',
		// 		['conditions'=>['NOT'=>['Quotation.collection_date'=>null]]]);
		// }
		// else {
		// 	$collections = $this->Quotation->find('all',
		// 		['conditions'=>['Quotation.collection_date'=>null]]);
		// }
		
		// $this->set(compact('status', 'collections'));
		
		
	// 	$status = $this->params['url']['status'];
		
	// 	$collections = $this->Collection->find('all');

	// 	$quotes = [];
	// 	$undefined = '';
	// 	foreach($collections as $collection_obj) {
	// 		$collection = $collection_obj['Collection'];
	// 		$col_quote_id = $collection['quotation_id'];
			
	// 		if($status=="pending") {
	// 			$quotes[$col_quote_id] = $this->Quotation->find('all',
	// 				['conditions'=>['collection_date']]);
	// 		}
	// 		else if($status=="accomplished") {
				
	// 		}
	// 		else {
	// 			$undefined = "Undefined Status";
	// 		}
	// 	}
		
	// 	$this->set(compact('status', 'collections', 'undefined'));
	}
}