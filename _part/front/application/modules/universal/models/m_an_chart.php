<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_an_chart extends CI_Model {

	public function __construct(){
        parent::__construct();
    }

    public function employee_status(){
    	$employee_status = [];
        $join = [['table' => 'main_employees b', 'on' => 'a.id = b.user_id']];
    	//get data from database
        $active     = $this->m_global->get_data_all('main_users a', $join,['a.isactive' => '1'],'a.isactive');
        $inactive   = $this->m_global->get_data_all('main_users a', $join,['a.isactive' => '0'],'a.isactive');
        $left       = $this->m_global->get_data_all('main_users a', $join,['a.isactive' => '3'],'a.isactive');
        $resigned   = $this->m_global->get_data_all('main_users a', $join,['a.isactive' => '99'],'a.isactive');
		$suspended  = $this->m_global->get_data_all('main_users a', $join,['a.isactive' => '4'],'a.isactive');
        // main result
        $employee_status = [
                ['status' => 'Active' , 'value' => count($active)],
                ['status' => 'InActive' , 'value' => count($inactive)],
                ['status' => 'Left' , 'value' => count($left)],
                ['status' => 'Deleted' , 'value' => count($resigned)],
                ['status' => 'Suspended' , 'value' => count($suspended)]
        ];
        return $employee_status;
    }

    public function employee_department()
    {
        $employee_department = [];
        //get data from database
        $department     = $this->db->query('select DISTINCT a.department_id, b.deptcode from main_employees a join main_departments b where a.department_id = b.id')->result();
        for ($i=0; $i < count($department) ; $i++) { 
            $employee[$i] = $this->m_global->get_data_all('main_employees', null, ['department_id' => $department[$i]->department_id],'id');
        }
        // main result
        for ($i=0; $i < count($department); $i++) { 
            $employee_department[$i] = ['data' => $department[$i]->deptcode, 'value' => count($employee[$i])];
        }
        return $employee_department;
    }

    public function requisitions_initialized(){
        $requisitions_initialized = [];
        //get data from database
        $new        = $this->m_global->get_data_all('main_requisition', null,['req_status' => 'Initiated'],'req_status');
        $approved   = $this->m_global->get_data_all('main_requisition', null,['req_status' => 'Approved'],'req_status');
        $rejected   = $this->m_global->get_data_all('main_requisition', null,['req_status' => 'Rejected'],'req_status');
        $closed     = $this->m_global->get_data_all('main_requisition', null,['req_status' => 'Closed'],'req_status');
        $on_hold    = $this->m_global->get_data_all('main_requisition', null,['req_status' => 'On hold'],'req_status');
        $complete   = $this->m_global->get_data_all('main_requisition', null,['req_status' => 'Complete'],'req_status');
        $in_process = $this->m_global->get_data_all('main_requisition', null,['req_status' => 'In process'],'req_status');
        // main result
        $requisitions_initialized = [
                ['data' => 'New' , 'value' => count($new)],
                ['data' => 'Approved' , 'value' => count($approved)],
                ['data' => 'Rejected' , 'value' => count($rejected)],
                ['data' => 'Closed' , 'value' => count($closed)],
                ['data' => 'On Hold' , 'value' => count($on_hold)],
                ['data' => 'Complete' , 'value' => count($complete)],
                ['data' => 'In Process' , 'value' => count($in_process)],
        ];
        return $requisitions_initialized;
    }

    public function employee_leave()
    {
        $employee_leave = [];

        $month = date('m');
        $year = date('Y');
        $date = date("t",mktime(0,0,0,$month,1,$year));
        for ($i=0; $i < $date; $i++) {
            $tgl = $i+1;
            $data[$i] = $this->m_global->get_data_all('main_leaverequest', null, ['leavestatus' => 'Approved','DATE(from_date)' => $year.'-'.$month.'-'.$tgl]); 
            $employee_leave[$i] = ['data' => $i+1, 'value' => count($data[$i])];
        }
        
        return $employee_leave;
    }

    public function activity_log()
    {
        $activity_log = [];

        $month = date('m');
        $year = date('Y');
        $date = date("t",mktime(0,0,0,$month,1,$year));
        for ($i=0; $i < $date; $i++) {
            $tgl        = $i+1;
            $act_date   = $year.'-'.$month.'-'.$tgl;
            $add[$i]    = $this->m_global->get_data_all('main_logmanager', null, ['user_action' => '1','DATE(last_modifieddate)' => $act_date]); 
            $edit[$i]   = $this->m_global->get_data_all('main_logmanager', null, ['user_action' => '2','DATE(last_modifieddate)' => $act_date]); 
            $delete[$i] = $this->m_global->get_data_all('main_logmanager', null, ['user_action' => '3','DATE(last_modifieddate)' => $act_date]); 
            $activity_log[$i] = ['date' => $i+1, 'add' => count($add[$i]), 'edit' => count($edit[$i]), 'delete' => count($delete[$i])];
            
        }
        
        return $activity_log;
    }

    public function login_log()
    {
        $login_log = [];

        $month = date('m');
        $year = date('Y');
        $date = date("t",mktime(0,0,0,$month,1,$year));
        for ($i=0; $i < $date; $i++) {
            $tgl = $i+1;
            $data[$i] = $this->m_global->get_data_all('main_userloginlog', null, ['DATE(logindatetime)' => $year.'-'.$month.'-'.$tgl]); 
            $login_log[$i] = ['data' => $i+1, 'value' => count($data[$i])];
        }
        
        return $login_log;
    }

    public function attrition_report()
    {
        $attrition_report = [];

        $year = date('Y')-4;
        for ($i=0; $i < 5; $i++) {
            $act_year = $year + $i;
            $data[$i] = $this->m_global->get_data_all('main_leaverequest', null, ['leavestatus' => 'Approved','YEAR(from_date)' => $act_year]); 
            $attrition_report[$i] = ['data' => $act_year, 'value' => count($data[$i])];
        }
        
        return $attrition_report;
    }

}

/* End of file m_hr_roles_provilages.php */
/* Location: ./application/modules/hr_roles_provilages/models/m_hr_roles_provilages.php */