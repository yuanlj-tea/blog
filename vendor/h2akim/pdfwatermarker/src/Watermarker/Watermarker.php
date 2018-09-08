<?php

namespace PdfWatermarker\Watermarker;

use setasign\Fpdi\Fpdi;

class Watermarker {

	private $originalPdf;
	private $newPdf;
	private $tempPdf;
	private $watermark;
	private $imagePositionOutput;
	private $replaceOriginal;
	
	public function __construct($originalPdf, $newPdf, $watermark, $position, $replaceOriginal) {
		
		$this->originalPdf = $originalPdf;
		$this->newPdf = $newPdf;
		$this->tempPdf = new Fpdi();
		$this->watermark = $watermark;
		$this->replaceOriginal = $replaceOriginal;
		
		$this->validateAssets();
		$this->setWatermarkPosition($position);
	}
	
	private function validateAssets() {
		
		if ( !file_exists( $this->originalPdf ) ) {
			throw new \Exception("Inputted PDF file doesn't exist");
		}
		else if ( !file_exists( $this->watermark->getFilePath() ) ) {
			throw new \Exception("Watermark doesn't exist.");
		}
		
	}
	
	/**
	* $position string -  'center','topright', 'topleft', 'bottomright', 'bottomleft'
	*/
	public function setWatermarkPosition($position) {

        switch ($position) {

            case 'topright':
            case 'topleft':
            case 'topright':
            case 'bottomright':
            case 'bottomleft':
                $this->imagePositionOutput = $position;
                break;
            default:
                $this->imagePositionOutput = 'center';

        }
	}
	
	private function watermarkWholePdf() {
		$pageCtr = $this->tempPdf->setSourceFile($this->originalPdf);
		for($ctr = 1; $ctr <= $pageCtr; $ctr++){
			$this->watermarkPage($ctr);
		}
	}
	
	private function watermarkPage($pageNumber) {
		$templateId = $this->tempPdf->importPage($pageNumber);
		$templateDimension = $this->tempPdf->getTemplateSize($templateId);
		if ($templateDimension['width'] > $templateDimension['height']) {
			$orientation = 'L';
		} else {
			$orientation = 'P';
		}
		
		$this->tempPdf->addPage($orientation,array($templateDimension['width'],$templateDimension['height']));
		$this->tempPdf->useTemplate($templateId);
		
		$wWidth = ($this->watermark->getWidth() / 96) * 25.4; //in mm
		$wHeight = ($this->watermark->getHeight() / 96) * 25.4; //in mm
		
		$watermarkPosition = $this->determineWatermarkPosition( $wWidth, 
															    $wHeight, 
															    $templateDimension['width'], 
															    $templateDimension['height']);
		$this->tempPdf->Image($this->watermark->getFilePath(),$watermarkPosition[0],$watermarkPosition[1],-96);
	}
	
	private function determineWatermarkPosition($wWidth, $wHeight, $tWidth, $tHeight) {
		
		switch( $this->imagePositionOutput ) {
			case 'topleft': 
				$x = 0;
				$y = 0;
				break;
			case 'topright':
				$x = $tWidth - $wWidth;
				$y = 0;
				break;
			case 'bottomright':
				$x = $tWidth - $wWidth;
				$y = $tHeight - $wHeight;
				break;
			case 'bottomleft':
				$x = 0;
				$y = $tHeight - $wHeight;
				break;
			default:
				$x = ( $tWidth - $wWidth ) / 2 ;
				$y = ( $tHeight - $wHeight ) / 2 ;
				break;
		}
		
		return array($x,$y);
	}
	
	public function watermarkPdf() {
		$this->watermarkWholePdf();
		if ($this->replaceOriginal && file_exists($this->originalPdf)) {
			try {
				@chmod($this->originalPdf, 0777);
				@unlink($this->originalPdf);
				$this->newPdf = $this->originalPdf;
			} catch (\Exception $e) {
				throw new \Exception('No permission to replace file');
			}
		}
		return $this->tempPdf->Output('F', $this->newPdf);
	}

}