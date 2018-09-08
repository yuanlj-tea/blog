PHP PDF Watermarker
===================
Installation
-------------

```bash
composer require h2akim/pdfwatermarker:dev-master
```

Usage
-------------

```php
<?php

use PdfWatermarker\PdfWatermarker;

$watermarker = new PdfWatermarker(
                'input.pdf', // input
                'output.pdf', // output
                'watermark.png', // watermark file
                'center', // watermark position (topleft, topright, bottomleft, bottomright, center)
                true // set to true - replace original input file
               );
$watermarker->create();
```