<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vcard extends CI_Controller {

    private $title                        = 'Vcard';
    private $prefix                       = 'Vcard';
    private $table_db                     = 'vcard';
    private $table_prefix                 = 'vcard.';
    private $pref                         = 'vcard_';
    
    private $table_db_resume              = 'resume';
    private $table_prefix_resume          = 'resume.';
    private $pref_resume                  = 'resume_';
    
    private $table_db_skill               = 'skill';
    private $table_prefix_skill           = 'skill.';
    private $pref_skill                   = 'skill_';
    
    private $table_db_group_skill         = 'group_skill';
    private $table_prefix_group_skill     = 'group_skill.';
    private $pref_group_skill             = 'group_skill_';
    
    private $table_db_portfolio           = 'portfolio';
    private $table_prefix_portfolio       = 'portfolio.';
    private $pref_portfolio               = 'portfolio_';
    
    private $table_db_group_portfolio     = 'group_portfolio';
    private $table_prefix_group_portfolio = 'group_portfolio.';
    private $pref_group_portfolio         = 'group_portfolio_';
    
    private $table_db_contact             = 'contact';
    private $table_prefix_contact         = 'contact.';
    private $pref_contact                 = 'contact_';
    
    private $table_db_map                 = 'map';
    private $table_prefix_map             = 'map.';
    private $pref_map                     = 'map_';

	public function index($param='')
	{
        $data = null;
        $where_vcard['vcard_link'] = $param;

        if ($param=='') {
            $where_vcard['vcard_link'] = 'Bayu_Ady_Nugraha';
        }
        //-----------------------------------Profile----------------------------------------//
        $vcard_profile   = $this->m_global->get_data_all($this->table_db, null, $where_vcard);
        $data['profile'] = @$vcard_profile[0];
        //-----------------------------------Resume---Employment----------------------------//
        $where_resume_employment[strEncrypt('resume_vcard_id', TRUE)] = strEncrypt(@$data['profile']->vcard_id);
        $where_resume_employment['resume_type']                       = 'employment';
        $vcard_resume_employment                                      = $this->m_global->get_data_all($this->table_db_resume, null, $where_resume_employment, '*', null, array($this->pref_resume.'period','desc'));
        $data['resume_employment']                                    = @$vcard_resume_employment;
        //-----------------------------------Resume---Education------------------------------//
        $where_resume_education[strEncrypt('resume_vcard_id', TRUE)] = strEncrypt(@$data['profile']->vcard_id);
        $where_resume_education['resume_type']                       = 'education';
        $vcard_resume_education                                      = $this->m_global->get_data_all($this->table_db_resume, null, $where_resume_education, '*', null, array($this->pref_resume.'period','desc'));
        $data['resume_education']                                    = @$vcard_resume_education;
        //-----------------------------------Resume---Skill----------------------------------//
        $where_skill[strEncrypt('skill_vcard_id', TRUE)] = strEncrypt(@$data['profile']->vcard_id);
        $join_skill = array(
                            array(
                                    'table' => 'group_skill',
                                    'on'    => 'group_skill_id=skill_group_skill_id'
                                ),
                            );
        $vcard_skill = $this->m_global->get_data_all($this->table_db_skill, $join_skill, $where_skill,'group_skill_name,skill_name,skill_range');
        $data['skill'] = array();
        foreach ($vcard_skill as $key => $value) {
            $data['skill'][str_replace(' ','_',$value->group_skill_name)][] = array(
                                                                                        'name' => $value->skill_name,
                                                                                        'range'=> $value->skill_range
                                                                                    );
        }

        //-----------------------------------------------portfolio-----------------------------------------//

        $where_portfolio[strEncrypt('portfolio_vcard_id', TRUE)] = strEncrypt(@$data['profile']->vcard_id);
        $join_portfolio = array(
                            array(
                                    'table' => 'group_portfolio',
                                    'on'    => 'group_portfolio_id=portfolio_group_portfolio_id'
                                ),
                            );
        $vcard_portfolio = $this->m_global->get_data_all($this->table_db_portfolio, $join_portfolio, $where_portfolio);
        $data['portfolio']      = array();
        $data['portfolio_list'] = array();
        foreach ($vcard_portfolio as $key => $value) {
            $data['portfolio'][] = array(
                                            'class'      => 'portfolio-'.$value->group_portfolio_id,
                                            'href'       => 'portfolio/'.$value->portfolio_link,
                                            'href_title' => $value->portfolio_link_title,
                                            'href_class' => $value->portfolio_class,
                                            'src'        => 'portfolio/tumb/'.$value->portfolio_tumb_img,
                                            'alt'        => $value->portfolio_tumb_alt,
                                            'title'      => $value->portfolio_title,
                                            'categorie'  => $value->group_portfolio_name,
                                        );
            $data['portfolio_list']['portfolio-'.$value->group_portfolio_id] =  $value->group_portfolio_name;
        }

        //-----------------------------------------------contact-----------------------------------------//
        
        $where_contact[strEncrypt('contact_vcard_id', TRUE)] = strEncrypt(@$data['profile']->vcard_id);
        $vcard_contact = $this->m_global->get_data_all($this->table_db_contact, null, $where_contact);
        $data['contact'] = $vcard_contact;

        //-----------------------------------------------map-----------------------------------------//
        
        $where_map[strEncrypt('map_vcard_id', TRUE)] = strEncrypt(@$data['profile']->vcard_id);
        $vcard_map = $this->m_global->get_data_all($this->table_db_map, null, $where_map);
        $data['map'] = $vcard_map[0];
		$this->template->display(strtolower(__CLASS__),$data);
	}

}
