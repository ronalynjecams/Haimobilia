<?php

App::uses('AppController', 'Controller');

/**
 * QuotationProducts Controller
 *
 * @property QuotationProduct $QuotationProduct
 * @property PaginatorComponent $Paginator
 */
class QuotationProductsController extends AppController {

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
        $this->QuotationProduct->recursive = 0;
        $this->set('quotationProducts', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->QuotationProduct->exists($id)) {
            throw new NotFoundException(__('Invalid quotation product'));
        }
        $options = array('conditions' => array('QuotationProduct.' . $this->QuotationProduct->primaryKey => $id));
        $this->set('quotationProduct', $this->QuotationProduct->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->QuotationProduct->create();
            if ($this->QuotationProduct->save($this->request->data)) {
                $this->Session->setFlash(__('The quotation product has been saved.'), 'default', array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The quotation product could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
            }
        }
        $quotations = $this->QuotationProduct->Quotation->find('list');
        $products = $this->QuotationProduct->Product->find('list');
        $users = $this->QuotationProduct->User->find('list');
        $this->set(compact('quotations', 'products', 'users'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->QuotationProduct->exists($id)) {
            throw new NotFoundException(__('Invalid quotation product'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->QuotationProduct->save($this->request->data)) {
                $this->Session->setFlash(__('The quotation product has been saved.'), 'default', array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The quotation product could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
            }
        } else {
            $options = array('conditions' => array('QuotationProduct.' . $this->QuotationProduct->primaryKey => $id));
            $this->request->data = $this->QuotationProduct->find('first', $options);
        }
        $quotations = $this->QuotationProduct->Quotation->find('list');
        $products = $this->QuotationProduct->Product->find('list');
        $users = $this->QuotationProduct->User->find('list');
        $this->set(compact('quotations', 'products', 'users'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->QuotationProduct->id = $id;
        if (!$this->QuotationProduct->exists()) {
            throw new NotFoundException(__('Invalid quotation product'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->QuotationProduct->delete()) {
            $this->Session->setFlash(__('The quotation product has been deleted.'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('The quotation product could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
