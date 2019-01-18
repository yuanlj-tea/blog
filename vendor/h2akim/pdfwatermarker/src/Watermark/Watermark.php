<?php

namespace PdfWatermarker\Watermark;

class Watermark {

    private $watermarkFile;
	private $watermarkImageheight;
	private $watermarkImagewidth;

	function __construct($file) {

		$this->watermarkFile = $this->prepareWatermarkImage($file);
		$this->getWatermarkImageSize($this->watermarkFile);
	}
	
	private function prepareWatermarkImage($file) {
		
		if ( !file_exists( $file ) ) {
			throw new \Exception("Watermark doesn't exist.");
		}
		$imagetype = exif_imagetype($file);
		
		switch($imagetype) {
			
			case IMAGETYPE_JPEG: 
                $image = imagecreatefromjpeg($file);
                $path =  sys_get_temp_dir() . '/' . uniqid() . '.jpg';
				imageinterlace($image,false);
				imagejpeg($image, $path);
				imagedestroy($image);
				break;
				
			case IMAGETYPE_PNG:
                $image = imagecreatefrompng($file);
                $path =  sys_get_temp_dir() . '/' . uniqid() . '.png';
				imageinterlace($image,false);
				imagesavealpha($image,true);
				imagepng($image, $path);
				imagedestroy($image);
				break;
			default:
				throw new \Exception("Unsupported image type");
				break;
		};
		
		return $path;
		
	}
	
	private function getWatermarkImageSize($image) {
        $imageSize = getimagesize($image);
		$this->watermarkImageWidth = $imageSize[0];
		$this->watermarkImageWidth = $imageSize[1];
	}
	
	public function getFilePath() {
		return $this->watermarkFile;
	}
	
	public function getHeight() {
		return $this->watermarkImageWidth;
	}
	
	public function getWidth() {
		return $this->watermarkImageWidth;
	}
    
}