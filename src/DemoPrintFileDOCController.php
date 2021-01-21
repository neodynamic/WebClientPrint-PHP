<?php

include 'WebClientPrint.php';

use Neodynamic\SDK\Web\WebClientPrint;
use Neodynamic\SDK\Web\Utils;
use Neodynamic\SDK\Web\DefaultPrinter;
use Neodynamic\SDK\Web\InstalledPrinter;
use Neodynamic\SDK\Web\PrintFile;
use Neodynamic\SDK\Web\PrintFileDOC;
use Neodynamic\SDK\Web\ClientPrintJob;

// Process request
// Generate ClientPrintJob? only if clientPrint param is in the query string
$urlParts = parse_url($_SERVER['REQUEST_URI']);

if (isset($urlParts['query'])) {
    $rawQuery = $urlParts['query'];
    parse_str($rawQuery, $qs);
    if (isset($qs[WebClientPrint::CLIENT_PRINT_JOB])) {

        $fileName = uniqid();
        $filePath = 'files/Sample-Employee-Handbook.doc';
        
        //Create PrintFileDOC obj
        $myfile = new PrintFileDOC($filePath, $fileName, null);
        $myfile->pagesRange = $qs['pagesRange'];
        $myfile->printInReverseOrder = ($qs['printInReverseOrder']=='true');
        $myfile->duplexPrinting = ($qs['duplexPrinting']=='true');
        //myfile->duplexPrintingDialogMessage = 'Your custom dialog message for duplex printing';

        //Create a ClientPrintJob obj that will be processed at the client side by the WCPP
        $cpj = new ClientPrintJob();
        $cpj->printFile = $myfile;
        
        //Create an InstalledPrinter obj
        $printerName = urldecode($qs['printerName']);
        if ($printerName == 'null'){
            $myPrinter = new DefaultPrinter();
        } else {
            $myPrinter = new InstalledPrinter($printerName);
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
    


 