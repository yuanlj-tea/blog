<?php

namespace PdfWatermarker;

use PdfWatermarker\Watermark\Watermark;
use PdfWatermarker\Watermarker\Watermarker;

class PDFWatermarker {

    private $pdfInput;
    private $pdfOutput;
    private $watermarkImage;
    private $watermarkPosition;
    private $replaceOriginal;

    public function __construct($pdfInput, $pdfOutput, $watermarkImage, $watermarkPosition, $replaceOriginal = false) {
        $this->pdfInput = $pdfInput;
        $this->pdfOutput = $pdfOutput;
        $this->watermarkImage = $watermarkImage;
        $this->watermarkPosition = $watermarkPosition;
        $this->replaceOriginal = $replaceOriginal;
    }

    public function create()
    {
        $this->watermark = new Watermark($this->watermarkImage);
        $this->watermarker = new Watermarker($this->pdfInput, $this->pdfOutput, $this->watermark, $this->watermarkPosition, $this->replaceOriginal); 
        $this->watermarker->watermarkPdf();
    }

}