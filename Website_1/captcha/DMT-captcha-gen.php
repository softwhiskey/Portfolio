<?php
require_once("DMT-captcha-config.php");

function VMulVector($v1,$v2){
  $v3[0]=$v1[1]*$v2[2]-$v1[2]*$v2[1];
  $v3[1]=$v1[2]*$v2[0]-$v1[0]*$v2[2];
  $v3[2]=$v1[0]*$v2[1]-$v1[1]*$v2[0];
  return $v3;
}

function MulVector($v1,$v2,$v3){
  return $v1[0]*$v2[1]*$v3[2]+
  $v1[1]*$v2[2]*$v3[0]+
  $v2[0]*$v3[1]*$v1[2]-
  $v3[0]*$v2[1]*$v1[2]-
  $v2[0]*$v1[1]*$v3[2]-
  $v3[1]*$v2[2]*$v3[0];
}

function SubVector($v1,$v2){
  $v3[0]=$v1[0]-$v2[0];
  $v3[1]=$v1[1]-$v2[1];
  $v3[2]=$v1[2]-$v2[2];
  return $v3;
}

function GetPoint($x,$y,$z){
  GLOBAL $u1,$u2,$u,$r0;
  $r[0]=$x;
  $r[1]=$y;
  $r[2]=$z;
  $s1=MulVector($u1,$u2,$u);
  $r1=SubVector($r,$r0);
  $s3=MulVector($r1,$u2,$u);
  $s4=MulVector($r1,$u1,$u);
  $pt[0]=$s3/$s1;
  $pt[1]=-$s4/$s1;
  return $pt;
}

function ToScreen($pt,$width,$height){
 $pt[0]=$width/2+$pt[0];
 $pt[1]=$height/2-$pt[1];
 return $pt;
}

class DMTcaptcha{
 function DMTcaptcha(){
 require(dirname(__FILE__).'/DMT-captcha-config.php');
 GLOBAL $u1,$u2,$u,$r0,$alphabet_length,$alphabet,$jpeg_quality,$REMOTE_ADDR;
 //GLOBAL $dmtC_pict_folder,$dmtC_gen_folder,$dmtC_skey;
 $im=imagecreatefromgif(dirname(__FILE__)."/DMT_captcha_fonts/back".mt_rand(1,$back_count).".gif");
 $width = imagesx($im);
 $height = imagesy($im);
 if (rand(0,1)) $koef=-1; else $koef=1;
 $u[0]=$koef*rand(100,170)/100;
 $u[1]=$koef*rand(200,500)/100;
 $u[2]=1;
 $u1[0]=0.3; $u1[1]=0; $u1[2]=0;
 $u2[0]=0; $u2[1]=0.3; $u2[2]=0; 
 $r0[0]=5; $r0[1]=5; $r0[2]=0;
 $font='aqua';$nll=-29;$wd=0;
			while(true){
				$this->keystring='';
				for($i=0;$i<$length;$i++)
					$this->keystring.=$use_symbols{mt_rand(0,$use_symbols_len-1)};
				if(!preg_match('/cp|cb|ck|c6|c9|rn|rm|mm|co|do|cl|db|qp|qb|dp|ww/', $this->keystring)) break;
			}
GLOBAL $dmt_font,$dmt_font_width;
 for ($i=0;$i<$length;$i++){
  for ($j=0;$j<$alphabet_length;$j++) if ($this->keystring{$i}==$alphabet[$j]) {
   $simb_nom[$i]=$j; break;
   }
 $z[$i]=0;
 require_once(dirname(__FILE__).'/DMT_captcha_fonts/'.$font.$simb_nom[$i].'.php');
 $twd=intval(count($dmt_font[$font][$simb_nom[0]])/($dmt_font_width[$font][$simb_nom[0]]+1));
 if ($twd>$wd)$wd=$twd;
}

$rcolor=imagecolorallocate($im,mt_rand(0,160), mt_rand(0,160), mt_rand(0,160));
$lpts[0]=mt_rand(0,$width);$lpts[1]=mt_rand(0,$height);
for ($y=0;$y<$wd;$y++) {
$nly=-30;
for ($i=0;$i<$length;$i++){
     for ($x=0;$x<$dmt_font_width[$font][$simb_nom[$i]]+1;$x++) {
      $pts=ToScreen(GetPoint($x/1.1+$nly,-$y/1.1-$nll/1.1,$dmt_font[$font][$simb_nom[$i]][$z[$i]]*-1),$width,$height);
      if ($x%($dmt_font_width[$font][$simb_nom[$i]]+1)==0){
		$lpts=$pts;
      }
      imageline($im,$lpts[0],$lpts[1],$pts[0],$pts[1],$rcolor);
	  $lpts=$pts;
	  $z[$i]++;
     }
	 $nly+=$dmt_font_width[$font][$simb_nom[$i]]/1.1;
	}
}
 wave_region($im,0,0,$width,$height,10,rand(60,100));
		header('Expires: Sat, 17 May 2008 05:00:00 GMT'); 
		header('Cache-Control: no-store, no-cache, must-revalidate'); 
		header('Cache-Control: post-check=0, pre-check=0', FALSE); 
		header('Pragma: no-cache');
		
		if(function_exists("imagejpeg")){
			header("Content-Type: image/jpeg");
			imagejpeg($im, null, $jpeg_quality);
		}else if(function_exists("imagegif")){
			header("Content-Type: image/gif");
			imagegif($im);
		}else if(function_exists("imagepng")){
			header("Content-Type: image/x-png");
			imagepng($im);
		}
 }
 	function getKeyString(){
		return $this->keystring;
	}
}


function wave_region($img, $x, $y, $width, $height,$amplitude = 4.5,$period = 30)
  {     $mult = 2;
        $img2 = imagecreatetruecolor($width * $mult, $height * $mult);
        imagecopyresampled ($img2,$img,0,0,$x,$y,$width * $mult,$height * $mult,$width, $height);
        for ($i = 0;$i < ($width * $mult);$i += 2)
        {
           imagecopy($img2,$img2,
               $x + $i - 2,$y + sin($i / $period) * $amplitude,
               $x + $i,$y,            // src
               2,($height * $mult));
        }
        imagecopyresampled($img,$img2,$x,$y,0,0,$width, $height,$width * $mult,$height * $mult);
        imagedestroy($img2);
 }

?>
