<?php

App::uses('AppController', 'Controller');

/**
 * Companies Controller
 *
 * @property Company $Company
 * @property PaginatorComponent $Paginator
 */
class CompaniesController extends AppController {

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
        $this->Company->recursive = 0;
        $this->set('companies', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Company->exists($id)) {
            throw new NotFoundException(__('Invalid company'));
        }
        $options = array('conditions' => array('Company.' . $this->Company->primaryKey => $id));
        $this->set('company', $this->Company->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
//    public function add() {
//        $this->autoRender = false;
//        $this->response->type('json'); 
//        if ($this->request->is(array('post', 'put'))) { 
//            $this->Company->create();
//            if ($this->Company->save($this->request->data)) {
//                return (json_encode($this->request->data));
//            }
//        } else {
//            return (json_encode($this->request->data));
//        }
//        exit;
        
         
        
        /////////////
//        $this->autoRender = false;
//        $this->response->type('json');
//        if ($this->request->is(array('post', 'put'))) {
////            pr($this->request->data);
//            $this->Company->create();
//            if ($this->Company->save($this->request->data)) {
////                $this->Session->setFlash(__('The company has been saved.'), 'default', array('class' => 'alert alert-success'));
////                return $this->redirect(array('action' => 'all_list?type=' . $this->request->data['Company']['type'] . ''));
////                echo '<script>window.history.back();</script>';
//                return (json_encode($this->request->data));
//            } else {
//                
//                return (json_encode($this->request->data));
////                $this->Session->setFlash(__('The company could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
//            }
//        }
//        $users = $this->Company->User->find('list');
//        $this->set(compact('users'));
//    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    
    
    
    public function add(){
      
        $this->autoRender = false;
        $this->response->type('json');
        $dd = $this->request->data; 

        if ($this->request->is(array('post', 'put'))) {
//            pr($dd);
            $this->Company->create();
            if ($this->Company->save($this->request->data)) {
                return (json_encode($this->request->data));
            } else {
                
//                return (json_encode($this->request->data));
            }
        } else {
//            return (json_encode($this->request->data));
        }
        exit;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function edit($id = null) {
        
        
        
        if (!$this->Company->exists($id)) {
            throw new NotFoundException(__('Invalid company'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Company->save($this->request->data)) {
//                $this->Session->setFlash(__('The company has been saved.'), 'default', array('class' => 'alert alert-success'));
//                return $this->redirect(array('action' => 'index'));
                
                return (json_encode($this->request->data));
            } else {
                return (json_encode($this->request->data));
//                $this->Session->setFlash(__('The company could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
            }
        } else {
            $options = array('conditions' => array('Company.' . $this->Company->primaryKey => $id));
            $this->request->data = $this->Company->find('first', $options);
        }
        $users = $this->Company->User->find('list');
        $this->set(compact('users'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Company->id = $id;
        if (!$this->Company->exists()) {
            throw new NotFoundException(__('Invalid company'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Company->delete()) {
            $this->Session->setFlash(__('The company has been deleted.'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('The company could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function all_list() {
        $type = $this->params['url']['type'];

        if ($this->Auth->user('role') == 'admin') {
            $companies = $this->Company->findAllByType($this->params['url']['type']);
        } else {
            $companies = $this->Company->find('all', [
                'conditions' => [
                    'Company.type' => $type,
                    'Company.user_id' => $this->Auth->user('id')
                ]
            ]);
        }
 
        $this->set(compact('companies'));
    }

    public function get_company_info() {

        $this->autoRender = false;
        $this->response->type('json');
        if ($this->request->is('ajax')) {
            $id = $this->request->query['id'];
            $this->Company->recursive = -1;
            $lead = $this->Company->findById($id);
            return (json_encode($lead['Company']));
            exit;
        }
    }
    
    public function update_company_process(){ 
        $this->autoRender = false;
        $this->response->type('json');
        $dd = $this->request->data;
        $id = $dd['id'];

        if ($this->request->is(array('post', 'put'))) {
            if ($this->Company->save($this->request->data)) {
                return (json_encode($this->request->data));
            } else {
                return (json_encode($this->request->data));
            }
        } else {
            return (json_encode($this->request->data));
        }
        exit;
    }

}
