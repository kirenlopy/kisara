<?php 
function resize_image($file, $w, $h, $crop=FALSE, $newfilepath='') {
	$imageinfo = getimagesize($file);
	$imginfo = pathinfo($file);
	if(!empty($imageinfo) && !empty($imageinfo[0])) {
		try {
			$width = $imageinfo[0];
			$height = $imageinfo[1];
			
			$r = $width / $height;
			
			if ($crop) {
				if ($width > $height) {
					$width = ceil($width-($width*abs($r-$w/$h)));
				} else {
					$height = ceil($height-($height*abs($r-$w/$h)));
				}
				$newwidth = $w;
				$newheight = $h;
			} else {
				if ($w/$h > $r) {
					$newwidth = $h*$r;
					$newheight = $h;
				} else {
					if($w < $width) {
						$newwidth = $w;
						$newheight = $w/$r;
					} 
					else {
						$newwidth = $width;
						$newheight = $height;
					}
				}
			}
			
			$func_imagecreate = 'imagecreatefromjpeg';
			$func_image = 'imagejpeg';
			$transparency = 100;
			if($imageinfo['mime'] == 'image/png') {
				$func_imagecreate = 'imagecreatefrompng';
				$func_image = 'imagepng';
				$transparency = 0;
			}
			else if($imageinfo['mime'] == 'image/gif') {
				$func_imagecreate = 'imagecreatefromgif';
				$func_image = 'imagegif';
				$transparency = -1;
			}
			
			$src = @$func_imagecreate($file);
			if(empty($src)) {
				throw new Exception("Can't resize file");
			}
			$dst = @imagecreatetruecolor($newwidth, $newheight);
			
			
			if($imageinfo['mime'] == 'image/png') {
				imagealphablending($dst, false);
				imagesavealpha($dst, true);
			}
			else if($imageinfo['mime'] == 'image/gif') {
				$transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
				imagefill($dst, 0, 0, $transparent);
				imagealphablending($dst, true);
			}
			
			imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			
			$path = $newfilepath.$imginfo['basename'];
			if(empty($newfilepath)) {
				$path = $file;
			}
			if( $transparency >= 0 ) {
				$func_image($dst, $path, $transparency);
			}
			else {
				$func_image($dst, $path);
			}
		}
		catch ( Exception $e ) {
			if(!empty($newfilepath)) {
				@copy($file, $newfilepath.$imginfo['basename']);
			}
			echo $imginfo['basename'].' couldn\'t be resize, due to => ',  $e->getMessage(), ".<br />";
		}
		
	}
	else {
		if(!empty($newfilepath)) {
			@copy($file, $newfilepath.$imginfo['basename']);
		}
		echo $imginfo['basename'].' have some errors.<br />';
	}
	// echo '<pre>'.$file;print_r($imageinfo);exit;
    //return $dst;
}
ini_set('display_errors', 'on');
error_reporting(E_ALL & ~E_NOTICE);

$image_folder = __DIR__.'/upload/';
chdir($image_folder);
$images = glob("*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}", GLOB_BRACE);


$image_bkp_folder = __DIR__.'/upload_new/';
if(!is_dir($image_bkp_folder)) {
	mkdir($image_bkp_folder, 0777);
}
chdir($image_bkp_folder);
$imagesbkp = glob("*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}", GLOB_BRACE);
if(empty($imagesbkp)) {
	$imagesbkp = array();
}
// $imager_folder = __DIR__.'/upload_resize/';

$resizesimages = array_diff($images, $imagesbkp);

if(!empty($resizesimages)) {
	foreach($resizesimages as $counter => $img) {
		//$imginfo = pathinfo($img);
		// copy($image_folder.$img, $image_bkp_folder.$img);
		resize_image($image_folder.$img, 300, 300, false, $image_bkp_folder);
	}
}
// echo count($images).'<br />';
// echo count($imagesbkp).'<br />';
// echo count($resizesimages).'<br />';
// resize_image