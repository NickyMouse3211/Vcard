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

function strEncryptcode($str, $forDB = FALSE, $editID = null){
    $CI =& get_instance();  
    $key    = $CI->config->item('encryption_key');
    $code = $CI->session->userdata('user_code').$CI->session->userdata('user_data')->vcard_id;
    if ($editID != null) {
    $code = $CI->session->userdata('user_code').$editID;
    }

    if (is_string($editID)) {
        $str    = ($forDB) ? 'md5(concat(\'' . $key . $CI->session->userdata('user_code') . '\','.$editID.',' . $str. '))': md5($key . $code . $str);  
    }else{
        $str    = ($forDB) ? 'md5(concat(\'' . $key . $code . '\',' . $str. '))' : md5($key . $code . $str);  
    }
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
function generateRandomString($length = 10) {
    $characters = 'BAYUADYNUGRAHAbayuadynugraha08970454527bayuadynugrahayahoocombayuadynugraha3211gmailcom0607199702061996';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function cekCode($email_login)
{
    $CI      = &get_instance();
    $cekcode = @$CI->m_global->get_data_all('code', NULL, ['code_email' => $email_login])[0];
    return $cekcode->code_string;
}
function changecode($email)
{
    $CI      = &get_instance();
    $rand    = generateRandomString();
    $cekcode = $CI->m_global->get_data_all('code', NULL, ['code_email' => $email])[0];
    $decrypt = chiper($cekcode->code_key,'decrypt',$cekcode->code_string);

    $newkey = chiper($decrypt,'encrypt',$rand);
    $newpass= strEncrypt($decrypt.$rand);
    $saverand= $CI->m_global->update('code',array('code_string' => $rand, 'code_key' => $newkey), array('code_email' => $email));
    $savevcard= $CI->m_global->update('vcard',array('vcard_password' => $newpass), array('vcard_email' => $email));
    return $cekcode->code_string;
}
function chiper($text,$type = 'encrypt',$customKey=''){
    $cipher = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $kunci  = "BAYUADYNUGRAHAbayuadynugraha08970454527bayuadynugrahayahoocombayuadynugraha3211gmailcom0607199702061996";
    $string = $text;
    if ($customKey != '') {
       $kunci = $customKey;
    }
    if ($type == 'decrypt' ) {
        return $cipher->decrypt($string, $kunci);
    }else{
        return $cipher->encrypt($string, $kunci);
    }
}

function colour($tint) {

    $frag = range(0,255);

    $red = "";
    $green = "";
    $blue = "";

    for (;;) {

        $red = $frag[mt_rand(0, count($frag)-1)];
        $green = $frag[mt_rand(0, count($frag)-1)];
        $blue = $frag[mt_rand(0, count($frag)-1)];

        switch ($tint) {
            case 'light':
                if (($red + $green + $blue / 3) >= 200) break 2;
                break;
            case 'dark' :
            default:
                if (($red + $green + $blue / 3) <= 50) break 2;
                break;
        }
    }
    return sprintf("#%02s%02s%02s", dechex($red), dechex($green),dechex($blue));
}

function color_inverse($color){
    $color = str_replace('#', '', $color);
    if (strlen($color) != 6){ return '000000'; }
    $rgb = '';
    for ($x=0;$x<3;$x++){
        $c = 255 - hexdec(substr($color,(2*$x),2));
        $c = ($c < 0) ? 0 : dechex($c);
        $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
    }
    return '#'.$rgb;
}

function newcode($id,$email,$password,$action = 'create')
{
    $CI      = &get_instance();
    $rand    = generateRandomString();

    $newkey = chiper($password,'encrypt',$rand);
    $newpass= strEncrypt($password.$rand);
    $data['code_string']   = $rand;
    $data['code_email']    = $email;
    $data['code_key']      = $newkey;
    
    $saverand = false;
    if ($action == 'create') {
        $data['code_vcard_id'] = $id;
        $saverand = $CI->m_global->insert('code', $data);
    }elseif ($action == 'edit') {
        $saverand = $CI->m_global->update('code', $data, array(strEncryptcode('code_vcard_id', TRUE) => $id));
    }
    if ($saverand) {
        $savevcard= $CI->m_global->update('vcard', array('vcard_password' => $newpass), array('vcard_email' => $email));

        if ($savevcard) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function decode_base64 ($code, $folder ,$username) {
    list($type, $code) = explode(';', $code);
    list(, $code)      = explode(',', $code);
    $code = base64_decode($code);

    file_put_contents('../public/images/'.$folder.'/'.$username.'.jpg', $code);
}

function TID($id){
    $CI      = &get_instance();
    $cekcode = @$CI->m_global->get_data_all('vcard', NULL, [strEncryptcode('vcard_id', TRUE,'vcard_id') => $id])[0];
    // echo "<pre>";
    // print_r ($CI->db->last_query());
    // echo "</pre>";exit();
    if (!$cekcode) {
        $cekcode = null;
    }
    return $cekcode;
}

function generateQRCode($text='')
{
    $CI      = &get_instance();
    $CI->load->library('ciqrcode');
    
    if ($text == '') {
        $text = base_url();
    }

    $config['cacheable']    = false; //boolean, the default is true
    $config['cachedir']     = base_url('public/cache'); //string, the default is application/cache/
    $config['errorlog']     = base_url('public/logs'); //string, the default is application/logs/
    $config['quality']      = true; //boolean, the default is true
    $config['size']         = ''; //interger, the default is 1024
    $config['black']        = array(224,255,255); // array, default is array(255,255,255)
    $config['white']        = array(70,130,180); // array, default is array(0,0,0)
    $CI->ciqrcode->initialize($config);

    $params['data'] = $text;
    $params['level'] = 'H';
    $params['size'] = 10;
    $params['savename'] = FCPATH.'public/images/barcode/'.str_replace(' ','_',$text).'.png';
    $CI->ciqrcode->generate($params);
}