<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('dashboard_api', 'sales_per_agent', 'get_sales_per_agent');
    }

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
        $this->User->recursive = 0;
        $this->set('users', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->set('user', $this->User->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved.'), 'default', array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved.'), 'default', array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->User->delete()) {
            $this->Session->setFlash(__('The user has been deleted.'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('The user could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) { 
                if ($this->Auth->user('role') == 'sales_executive') {
                    return $this->redirect('/users/dashboard_sales');
                } else if ($this->Auth->user('role') == 'admin') {
                    return $this->redirect('/users/dashboard');
                } else if ($this->Auth->user('role') == 'sales_manager') {
                    return $this->redirect('/users/dashboard');
                } else {
                    $this->Session->setFlash(__('Invalid username or password, try again'));
                    return $this->redirect($this->Auth->logout());
                }
            }
            $this->Session->setFlash(__('Invalid username or password, try again'));
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function login_new() {
        
    }
    
    public function dashboard(){
        $this->loadModel('Quotation');
        $users = $this->User->find('all',
            ['conditions'=>['active'=>1,
                            'role'=>'sales_executive']]); 
        
        // $approved_count = [];
        // $total_pending = [];
        // $total_earnings = [];
        // $overall = [];
        // foreach($users as $user){
        //     $total = $this->Quotation->find('all',[
        //         'conditions'=>[
        //             'Quotation.status'=>['approved','processed','moved'],
        //             'Quotation.user_id'=>$user['User']['id']
        //             ],
        //         'fields'=>['User.*', 
        //         'SUM(Quotation.grand_total)   AS total_earnings',
        //                 'Quotation.*',  
        //         'COUNT(Quotation.quote_number)   AS approved_count',
        //             ]
        //         ]);
        //     $total_pen = $this->Quotation->find('all',[
        //         'conditions'=>[
        //             'Quotation.status'=>'pending',
        //             'Quotation.user_id'=>$user['User']['id']
        //             ],
        //         'fields'=>['User.*', 
        //         'SUM(Quotation.grand_total)   AS total_pending',
        //                 'Quotation.*',
        //         'COUNT(Quotation.quote_number)   AS pending_count'
        //             ]
        //         ]);

        //     $total_earnings[] =array_push($total_earnings,$total); 
        //     $total_pending[] =array_push($total_pending,$total_pen);  
        // }
 
        $this->set(compact('users'));
        // $this->set(compact('total_earnings'));
        // $this->set(compact('total_pending'));
        // $this->set(compact('overall'));
        
        
        // ===================================================================>
        // MAE CODE
        $get_month_quotes = $this->Quotation->find('all',
            ['conditions'=>['status'=>['processed', 'approved'],
                            'AND'=>['MONTH(created)'=>date('m'),
                                    'YEAR(created)'=>date('Y')]],
             'fields'=>['id', 'created', 'SUM(grand_total) as monthly_total', 'status'],
             'recursive'=>-1]);
        $get_year_quotes = $this->Quotation->find('all',
            ['conditions'=>['status'=>['processed', 'approved'],
                            'YEAR(created)'=>date('Y')],
             'fields'=>['id', 'created', 'SUM(grand_total) as yearly_total', 'status'],
             'recursive'=>-1]);
        
        $month = $get_month_quotes[0][0]['monthly_total'];
        $year = $get_year_quotes[0][0]['yearly_total'];
        $this->set(compact('month', 'year'));
        // END OF MAE CODE
    }
    
    public function complete_profile() {
                if ($this->Auth->user('role') == 'sales_executive') {
                    return $this->redirect('/users/dashboard_sales');
                } else if ($this->Auth->user('role') == 'admin') {
                    return $this->redirect('/users/dashboard');
                } else if ($this->Auth->user('role') == 'manager') {
                    return $this->redirect('/users/dashboard');
                } else {
                    return $this->redirect($this->Auth->logout());
                }
    }
    
    public function dashboard_sales(){
        
    }

    public function dashboard_api() {
        // DO NOT DELETE
        // USED IN JECAMS ERP
        $this->autoRender = false;
        $this->loadModel('Quotation');
        $get_month_quotes = $this->Quotation->find('all',
            ['conditions'=>['status'=>['processed', 'approved'],
                            'AND'=>['MONTH(created)'=>date('m'),
                                    'YEAR(created)'=>date('Y')]],
             'fields'=>['id', 'created', 'SUM(grand_total) as monthly_total', 'status'],
             'recursive'=>-1]);
        $get_year_quotes = $this->Quotation->find('all',
            ['conditions'=>['status'=>['processed', 'approved'],
                            'YEAR(created)'=>date('Y')],
             'fields'=>['id', 'created', 'SUM(grand_total) as yearly_total', 'status'],
             'recursive'=>-1]);
        
        $month = number_format((float)$get_month_quotes[0][0]['monthly_total'], 2, '.', ',');
        $year = number_format((float)$get_year_quotes[0][0]['yearly_total'], 2, '.', ',');
        
        $users = $this->User->find('all',
            ['conditions'=>['active'=>1,
                            'role'=>'sales_executive']]); 
        return json_encode(['month'=>$month, 'year'=>$year, 'users'=>$users]);
    }
    
    public function sales_per_agent($user_id) {
        $this->autoRender = false;
        $this->loadModel('Quotation');
        
        $get_month_quotes = $this->Quotation->find('all',
            ['conditions'=>['status'=>['processed', 'approved'],
                            'user_id'=>$user_id,
                            'AND'=>['MONTH(created)'=>date('m'),
                                    'YEAR(created)'=>date('Y')]],
             'fields'=>['id', 'created', 'SUM(grand_total) as monthly_total', 'status'],
             'recursive'=>-1]);
        $get_year_quotes = $this->Quotation->find('all',
            ['conditions'=>['status'=>['processed', 'approved'],
                            'user_id'=>$user_id,
                            'YEAR(created)'=>date('Y')],
             'fields'=>['id', 'created', 'SUM(grand_total) as yearly_total', 'status'],
             'recursive'=>-1]);
        
        $month = $get_month_quotes[0][0]['monthly_total'];
        $year = $get_year_quotes[0][0]['yearly_total'];
        $this->set(compact('month', 'year'));
    }
    
    public function get_sales_per_agent() {
        $this->autoRender = false;
        $this->loadModel('Quotation');
        
        $this->User->recursive = -1;
        $users = $this->User->findAllByRole('sales_executive', ['id']);
        foreach($users as $user) {
            $user_id = $user['User']['id'];
            $get_month_quotes[$user_id] = $this->Quotation->find('all',
                ['conditions'=>['status'=>['processed', 'approved'],
                                'user_id'=>$user_id,
                                'AND'=>['MONTH(created)'=>date('m'),
                                        'YEAR(created)'=>date('Y')]],
                 'fields'=>['id', 'user_id', 'SUM(grand_total) as monthly_total'],
                 'recursive'=>-1]);
            $get_year_quotes[$user_id] = $this->Quotation->find('all',
                ['conditions'=>['status'=>['processed', 'approved'],
                                'user_id'=>$user_id,
                                'YEAR(created)'=>date('Y')],
                 'fields'=>['id', 'user_id', 'SUM(grand_total) as yearly_total'],
                 'recursive'=>-1]);
        }
        
        return json_encode(["month"=>$get_month_quotes, "year"=>$get_year_quotes]);
    }
}