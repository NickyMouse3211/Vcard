<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function auth(){
	$CI = &get_instance();
	$CI->load->library( 'session' );

	$ex = array('login');

	$user_data 		= $CI->session->userdata('user_data');

    $status_link    = @$CI->input->post('status_link');

	if ( ! empty( $user_data ) AND ( ( in_array ( $CI->uri->segment(1), $ex) AND $CI->uri->segment(2) != "out") OR $CI->uri->segment(1) == "" ) )
	{
		redirect( base_url('dashboard') );
	} 
	else if ( empty($user_data) AND ! in_array( $CI->uri->segment(1), $ex ) ) 
	{
		if ( $status_link == 'ajax' )
		{
			echo 'out';
			die();
		}
		else
		{
			redirect(base_url('login'));
		}
	}
}

function csrf_init(){
    $CI =& get_instance();  

    $csrf   = strEncrypt('csrf');
    $value  = strEncrypt(date('YmdHis'));

    $CI->session->unset_userdata($csrf);    
    $CI->session->set_userdata([$csrf => $value]);
}

function strEncrypt($str, $forDB = FALSE){
    $CI =& get_instance();  
    $key    = $CI->config->item('encryption_key');

    $str    = ($forDB) ? 'md5(concat(\'' . $key . '\',' . $str . '))' : md5($key . $str);   
    return $str;
}

function csrf_get_token(){
    $CI =& get_instance();
    $csrf   = strEncrypt('csrf');
    $data   = @$CI->session->userdata($csrf);

    $data   = ($data != '') ? $data : '-';

    return $data;
}

function display($var, $exit = null)
{
    echo '<pre>';print_r($var);echo '</pre>';
    if ( $exit )
    {
        exit();
    }
}

function sidebar_menu( $menu, $url )
{
    foreach ( $menu as $key => $value ) 
    {
        echo 
            '<li ' . 
            /*
                Jika nama controller dari menu helper sama dengan controller
            */
            ( $value['controller'] == $url 
                ? 'class="start active open"' 
                : ''
            ).'>

            <a ' .
            /*
                Mempunyai sub menu atau tidak
                untuk link href
            */
            (is_array($value['link']) 
                ? 'href="javascript:;"' 
                : 'class="ajaxify" href="'.base_url($value['link']).'"') . 
            '>

            <i class="icon-'.$value['icon'].'"></i>

            <span class="title">'.$value['name'].'</span>' .

            /*
                Mempunyai sedang aktif
            */
            ($key == 0 
                ? '<span class="selected"></span>' 
                : ''
            ) .

            /*
                Mempunyai sub menu atau tidak
                untuk menampilkan arrow
            */
            (is_array($value['link']) 
                ? '<span class="arrow ' .
                    ( $value['controller'] == $url 
                    ? 'open'
                    : '')
                . '"></span>'
                : ''
            ) . '</a>';
            
            sub_menu( $value, $url, '2' );

        echo '</li>';
    }
}

function sub_menu( $value, $url, $segment ){

    /*
        Mempunyai sub menu atau tidak
        untuk menampilkan sub link
    */

    if ( is_array($value['link']) )
    {
        echo '<ul class="sub-menu">';

        $CI =& get_instance();

        /*
            Menampilkan sub menu
        */

        foreach ( $value['link'] as $kSub => $kValue ) 
        {
            $sub_url = $CI->uri->segment($segment);

            /*
                Jika controller parent sama dengan uri sebelumnya
                dan controller sekarang sama dengan uri sekarang
            */

            echo '<li ' .
                ($kValue['controller'] == $sub_url && $value['controller'] == $url 
                    ? 'class="active"' 
                    : ''
                ) . '>

                <a ' .

                /*
                    Jika mempunyai sub, maka href=javascript (tidak ada link)
                    jika tidak, maka href berisi link
                */

                (is_array($kValue['link']) 
                    ? 'href="javascript:;"' 
                    : 'class="ajaxify" href="'.base_url($kValue['link']).'"'
                ) . 

                '>
                    <i class="icon-'.$kValue['icon'].'"></i>
                    ' . $kValue['name'] .

                /*
                    Jika mempunyai sub dan controller parent sama dengan uri sekarang
                    maka arrow open (sub menu sedang aktif)
                    selain itu, hanya menampilkan arrow (mempunyai sub menu tapi tidak aktif)
                */

                (is_array($kValue['link']) && $kValue['controller'] == $sub_url  
                    ? '<span class="arrow open"></span>' 
                    : 
                        (is_array($kValue['link'] ) 
                            ? '<span class="arrow"></span>'
                            : ''
                        )
                ) . '
                    </a>';
                
                /*
                    cek lagi gan sub menu level selanjutnya
                */
                    
                sub_menu( $kValue, $sub_url, $segment+1 );

             echo '</li>';
        }
        echo '</ul>';
    }
}

function generateSalt($param, $param1, $param2){
    $a     = md5($param, '3ustasCartainkid');
    $b     = md5($param1, $a);
    $c     = md5($param2, $b);
    $hasil = md5(md5($a.$b.$c, 'IrfanIsmaSomantri'));
    return $hasil;
}

function generatePass($param, $param1){
    $hasil = md5(md5($param, $param1));
    return $hasil;
}

function md5_mod($str){

    $str = md5(md5($str).'prb_vcard');
    return $str;
}

function bulan($bulan)
{
    $aBulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    
    return $aBulan[$bulan];
}

function tgl_format($tgl)
{
    $tanggal    = date('d', strtotime($tgl));
    $bulan      = bulan( date('n', strtotime($tgl))-1 );   
    $tahun      = date('Y', strtotime($tgl));
    return $tanggal.' '.$bulan.' '.$tahun;
}

function religion_to_index($index)
{
    $religion = [
    'Islam'     => '1',
    'Protestan' => '2',
    'Katolik'   => '3',
    'Hindu'     => '4',
    'Budha'     => '5',
    'Konghucu' => '6'
    ];

    return $religion[$index];
}

function role($index)
{
    $CI     = &get_instance();
    $role   = $CI->m_global->get_data_all('role');
    $data[] ='';

    foreach ($role as $key) {
        $data[$key->role_id] = $key->role_nama;
    }
    

    return $data[$index];
}