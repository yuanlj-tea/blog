<?php

namespace App\Console\Commands;

use App\Libs\Common;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class Inspire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pathToPdf = '/mnt/hgfs/oa_site/new_src/public/attachment/1.pdf';
        $pathToWhereImageShouldBeStored = '/tmp/pdfToImg/';
        $pdf = new \Spatie\PdfToImage\Pdf($pathToPdf);
        $pages = $pdf->getNumberOfPages();


        for($i=1;$i<=$pages;$i++){
            $pdf->setPage($i)->setResolution(600)->setCompressionQuality(100)->saveImage($pathToWhereImageShouldBeStored);
            echo $i."==ok\n";
        }
        // $this->comment(PHP_EOL.Inspiring::quote().PHP_EOL);
    }
}
