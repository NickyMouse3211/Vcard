<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
    START Core Helper        
*/

function csrf_init(){
    $CI =& get_instance();  

    $csrf   = strEncrypt('csrf');
    $value  = strEncrypt(date('YmdHis'));

    $CI->session->unset_userdata($csrf);    
    $CI->session->set_userdata([$csrf => $value]);
}

function csrf_get_token(){
    $CI =& get_instance();
    $csrf   = strEncrypt('csrf');
    $data   = @$CI->session->userdata($csrf);

    $data   = ($data != '') ? $data : '-';

    return $data;
}

function strEncrypt($str, $forDB = FALSE){
    $CI =& get_instance();  
    $key    = $CI->config->item('encryption_key');

    $str    = ($forDB) ? 'md5(concat(\'' . $key . '\',' . $str . '))' : md5($key . $str);   
    return $str;
}

function strEncryptcode($str, $forDB = FALSE){
    $CI =& get_instance();  
    $key    = $CI->config->item('encryption_key');
    $code = $CI->session->userdata('user_code').$CI->session->userdata('user_data')->vcard_id;

    $str    = ($forDB) ? 'md5(concat(\'' . $key . $code . '\',' . $str. '))' : md5($key . $code . $str);   
    return $str;
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

function multi_encript($id)
{
    $data = [];
    foreach ($id as $key => $value) {
        $data[] = strEncrypt($value);
    }

    return $data;
}

function display($var, $exit=NULL)
{
    echo '<pre>';print_r($var);echo '</pre>';
    if($exit){
        exit();
    }
}

/*
    END Core Helper        
*/

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

function Terbilang($x)
{
    $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    if ($x < 12)
        return " " . $abil[$x];
    elseif ($x < 20)
        return Terbilang($x - 10) . "belas";
    elseif ($x < 100)
        return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
    elseif ($x < 200)
        return " seratus" . Terbilang($x - 100);
    elseif ($x < 1000)
        return Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
    elseif ($x < 2000)
        return " seribu" . Terbilang($x - 1000);
    elseif ($x < 1000000)
        return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
    elseif ($x < 1000000000)
        return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
}

function rgb2hex($rgb) {
   $hex = '';
   $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
   $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
   $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

   return $hex;
}

function tree_view($table, $where) {
    $CI = &get_instance();
    
    // get parent               
        $CI->db->select('*')->from($table);
        $CI->db->where($where);

        $query  = $CI->db->get();
        $parent     = $query->result();
        return $parent;
}

function tree_child($table, $where, $prefix) {
    $CI = &get_instance();
    
    // get parent               
    $CI->db->select('*')->from($table);
    $CI->db->where($where);

    $query  = $CI->db->get();
    $data   = $query->result();

    if (count($data) > 0) {
        $str    = "<ul>";

        foreach ($data as $rows) {  
            $name   = $prefix . "_long";
            $id     = $prefix . "_id";
            @$str .= '<li data-jstree=\'{ "opened" : true }\'><span onClick="f_edit(\''.$rows->$id.'\')">'. @$rows->$name.'</span>';

            // check lagi dong ah :D
            $str .= tree_child($table, [$prefix . "_parent" => $rows->$id], $prefix);

            $str .= '</li>';

        }

        $str    .= "</ul>";
    }       

    return @$str;
}

function save_file($file, $file_name, $file_size, $folder, $flag, $size)
{
    if($file!=''){
      $ret['error'] = 0;
      $pict = getimagesize($file);
        //if (!(($pict[2]==1) || ($pict[2]==2))) :
        $extension = strtolower(substr($file_name,-4));
        // if(!in_array($extension, array('.xls', '.pdf', 'docx','pptx','xlsx','.doc'))) :
        if(!in_array($extension, array('.jpg','.png','.jpeg','.pdf','.tiff','.doc','docx','.xls','xlsx'))) :
            $ret['error'] = 1;
            // $ret['msg'] = "Please, File ".$tail." must be xls,pdf,docx or GIF format...";
            $ret['msg'] = "Please, File ".$extension." must be xls,pdf,docx or GIF format...";
            return $ret;
            exit();
        endif;
    
      if ($file == "none") :
            $ret['error'] = 1;
            $ret['msg'] = "Please, Fill file field...";
            return $ret;
            exit();
        endif;
        if ($flag) :
            if ($file_size >= $size*1024) :
                $ret['error'] = 1;
                $ret['msg'] = "File size too large. Maximum file size $size KB...";
                return $ret;
                exit();
            endif;
        endif;
        $name_file = time()."-". trim($file_name);
    
        if (!@copy ($file,$folder."/".$name_file)) :
            $ret['error'] = 1;
            $ret['msg'] = "Copy file failed. Please check the file $file_name... $file -> $folder/$name_file";
            return $ret;
            exit();
        endif;
    
        $ret['nama_file'] = $name_file;
        return $ret;
        exit();
    }


}
function getcolor($image)
{
    if (isset($image))
    {
        $PREVIEW_WIDTH    = 150;  //WE HAVE TO RESIZE THE IMAGE, BECAUSE WE ONLY NEED THE MOST SIGNIFICANT COLORS.
        $PREVIEW_HEIGHT   = 150;
        $size = GetImageSize($image);
        $scale=1;
        if ($size[0]>0)
        $scale = min($PREVIEW_WIDTH/$size[0], $PREVIEW_HEIGHT/$size[1]);
        if ($scale < 1)
        {
            $width = floor($scale*$size[0]);
            $height = floor($scale*$size[1]);
        }
        else
        {
            $width = $size[0];
            $height = $size[1];
        }
        $image_resized = imagecreatetruecolor($width, $height);
        if ($size[2]==1)
        $image_orig=imagecreatefromgif($image);
        if ($size[2]==2)
        $image_orig=imagecreatefromjpeg($image);
        if ($size[2]==3)
        $image_orig=imagecreatefrompng($image);
        imagecopyresampled($image_resized, $image_orig, 0, 0, 0, 0, $width, $height, $size[0], $size[1]); //WE NEED NEAREST NEIGHBOR RESIZING, BECAUSE IT DOESN'T ALTER THE COLORS
        $im = $image_resized;
        $imgWidth = imagesx($im);
        $imgHeight = imagesy($im);
        for ($y=0; $y < $imgHeight; $y++)
        {
            for ($x=0; $x < $imgWidth; $x++)
            {
                $index = imagecolorat($im,$x,$y);
                $Colors = imagecolorsforindex($im,$index);
                $Colors['red']=intval((($Colors['red'])+15)/32)*32;    //ROUND THE COLORS, TO REDUCE THE NUMBER OF COLORS, SO THE WON'T BE ANY NEARLY DUPLICATE COLORS!
                $Colors['green']=intval((($Colors['green'])+15)/32)*32;
                $Colors['blue']=intval((($Colors['blue'])+15)/32)*32;
                if ($Colors['red']>=256)
                $Colors['red']=240;
                if ($Colors['green']>=256)
                $Colors['green']=240;
                if ($Colors['blue']>=256)
                $Colors['blue']=240;
                $hexarray[]=substr("0".dechex($Colors['red']),-2).substr("0".dechex($Colors['green']),-2).substr("0".dechex($Colors['blue']),-2);
            }
        }

        $hexarray=array_count_values($hexarray);
        natsort($hexarray);
        $hexarray=array_reverse($hexarray,true);
        return '#'.array_keys($hexarray)[0];

    }
    else{
        return '#FFFFFF';
    }
}
function colomImgZize($base,$img = '',$sizeImg = '6',$sizeTxt = '6'){
    $imageFile  = base_url($base.$img);

    $orientation['img'] = "hidden-object";
    $orientation['txt'] = "medium-12 columns"; 
    if ($imageFile != Null) {
        $imageSize  = GetImageSize($imageFile);
        $width      = $imageSize[0];
        $height     = $imageSize[1];

        if ($width > $height) {
            $orientation['img'] = "medium-12 columns";
            $orientation['txt'] = "medium-12 columns"; 
        }else {
            $orientation['img'] = "medium-".$sizeImg." columns";
            $orientation['txt'] = "medium-".$sizeTxt." columns";  
        }
    }
    return $orientation;
}

function colImgSize($base,$img = '',$sizeImg = '6',$sizeTxt = '6'){
    $imageFile          = base_url($base.$img);
    $orientation['img'] = 'hidden-object';
    $orientation['txt'] = 'col-sm-12';
    if ($imageFile != Null) {
        $imageSize  = GetImageSize($imageFile);
        $width      = $imageSize[0];
        $height     = $imageSize[1];

        if ($width > $height) {
           $orientation['img'] = 'col-sm-12';
           $orientation['txt'] = 'col-sm-12'; 
        }else {
            $orientation['img'] = 'col-sm-'.$sizeImg;
            $orientation['txt'] = 'col-sm-6'.$sizeTxt; 
        }
    }
    return $orientation;
}

function textsubstr($text='' , $start=0 , $end=999999999999999999)
{
    $textout = substr($text, $start, $end);
    if (strlen($text) > $end) {
        $textout .= ' ...';
    }

    return $textout;
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
function cekCode($email_login)
{
    $CI      = &get_instance();
    $cekcode = @$CI->m_global->get_data_all('code', NULL, ['code_email' => $email_login])[0];

    if (!empty($cekcode)) {
        return $cekcode->code_string;
    } else {
        return false;
    }
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

function newcode($id,$email,$password)
{
    $CI      = &get_instance();
    $rand    = generateRandomString();

    $newkey = chiper($password,'encrypt',$rand);
    $newpass= strEncrypt($password.$rand);

    $data['code_vcard_id'] = $id;
    $data['code_string'] = $rand;
    $data['code_email'] = $email;
    $data['code_key'] = $newkey;
    $saverand = $CI->m_global->insert('code', $data);
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
    $params['savename'] = FCPATH.'public/images/barcode/'.str_replace('/','_',str_replace(':','_',str_replace(' ','_',$text))).'.png';
    $CI->ciqrcode->generate($params);
}