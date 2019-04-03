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
    
    public function saveQuotationProduct(){
        $this->loadModel('Quotation');
        
        $this->autoRender = false;
        $data = $this->request->data;
        $quotation_product_id = $data['quotation_product_id'];
        $Qfield = $data['Qfield'];
        $value = $data['value'];
         
         $qp = $this->QuotationProduct->findById($quotation_product_id);
         if($Qfield == 'qty'){
             
             $qp_val = $qp['QuotationProduct']['list_price'];
             $new_total = $value * $qp_val;
             
         }else  if($Qfield == 'list_price'){
             
             $qp_val_price = $qp['QuotationProduct']['qty'];
             $new_total = $value * $qp_val_price;
             
         }else if($Qfield == 'description'){
             
             $new_total = $qp['QuotationProduct']['total_price'];
             
         }
         
         
         
        
        $this->QuotationProduct->id = $quotation_product_id;
        $this->QuotationProduct->set(array(
            $Qfield => $value , 
            'total_price' =>$new_total
        ));
        if ($this->QuotationProduct->save()) { 
            
            
             if($Qfield != 'description'){
                    $prod_total = $this->QuotationProduct->find('first', array( 'fields' => array('sum(QuotationProduct.total_price) AS sub_total'),
                    'conditions'=>array('QuotationProduct.quotation_id'=>$qp['QuotationProduct']['quotation_id'])));
                
                    $quote_data = $this->Quotation->findById($qp['QuotationProduct']['quotation_id']);
                 
                    $discount = $quote_data['Quotation']['discount']; 
                    $delivery_amount = $quote_data['Quotation']['delivery_amount'];
                    $installation_amount = $quote_data['Quotation']['installation_amount'];
                    
                    $sub_total = $prod_total[0]['sub_total'];
                    
                    $grand_total = ($sub_total + $delivery_amount + $installation_amount ) - $discount; 
                    
                    
                        $this->Quotation->id = $qp['QuotationProduct']['quotation_id'];
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
             }else{
                 echo json_encode($data); 
             }
        } else {
            echo json_encode('invalid data');
        }
        exit;
    }

}
