<?php

include 'WebClientPrint.php';

use Neodynamic\SDK\Web\WebClientPrint;
use Neodynamic\SDK\Web\Utils;
use Neodynamic\SDK\Web\DefaultPrinter;
use Neodynamic\SDK\Web\InstalledPrinter;
use Neodynamic\SDK\Web\PrintFile;
use Neodynamic\SDK\Web\PrintFileTIF;
use Neodynamic\SDK\Web\PrintRotation;
use Neodynamic\SDK\Web\Sizing;
use Neodynamic\SDK\Web\Duplex;
use Neodynamic\SDK\Web\ClientPrintJob;

// Process request
// Generate ClientPrintJob? only if clientPrint param is in the query string
$urlParts = parse_url($_SERVER['REQUEST_URI']);

if (isset($urlParts['query'])) {
    $rawQuery = $urlParts['query'];
    parse_str($rawQuery, $qs);
    if (isset($qs[WebClientPrint::CLIENT_PRINT_JOB])) {

        $fileName = uniqid();
        $filePath = 'files/patent2pages.tif';
        
        //Create PrintFileTIF obj
        $myfile = new PrintFileTIF($filePath, $fileName, null);
        $myfile->printRotation = PrintRotation::parse($qs['printRotation']);
        $myfile->pagesRange = $qs['pagesRange'];
        $myfile->printAsGrayscale = ($qs['printAsGrayscale']=='true');
        $myfile->printInReverseOrder = ($qs['printInReverseOrder']=='true');
        //$myfile->copies = 1;
        $manualDuplexPrinting = ($qs['manualDuplexPrinting'] == 'true');
        $driverDuplexPrinting = ($qs['driverDuplexPrinting'] == 'true');

        if ($manualDuplexPrinting && $driverDuplexPrinting){
            $manualDuplexPrinting = false;
        }

        if ($manualDuplexPrinting){
            $myfile->duplexPrinting = $manualDuplexPrinting;
            //myfile->duplexPrintingDialogMessage = 'Your custom dialog message for duplex printing';
        }
            
        $myfile->sizing = Sizing::parse($qs['pageSizing']);
        $myfile->autoCenter = ($qs['autoCenter'] == 'true');
        $myfile->autoRotate = ($qs['autoRotate'] == 'true');


        //Create a ClientPrintJob obj that will be processed at the client side by the WCPP
        $cpj = new ClientPrintJob();
        $cpj->printFile = $myfile;
        
        //Create an InstalledPrinter obj
        $printerName = urldecode($qs['printerName']);
        if ($printerName == 'null'){
            $myPrinter = new DefaultPrinter();
        } else {
            $myPrinter = new InstalledPrinter($printerName);
            $myPrinter->trayName = $qs['trayName'];
            $myPrinter->paperName = $qs['paperName'];
            if ($driverDuplexPrinting){
                $myPrinter->duplex = Duplex::Vertical;
            }
        }
        
        $cpj->clientPrinter = $myPrinter;
        
        //Send ClientPrintJob back to the client
        ob_start();
        ob_clean();
        header('Content-type: application/octet-stream');
        echo $cpj->sendToClient();
        ob_end_flush();
        exit();
        
    }
}
    


 