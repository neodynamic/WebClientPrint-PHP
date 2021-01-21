<?php

include 'WebClientPrint.php';
use Neodynamic\SDK\Web\WebClientPrint;
use Neodynamic\SDK\Web\Utils;
use Neodynamic\SDK\Web\ClientPrintJob;
use Neodynamic\SDK\Web\DefaultPrinter;
use Neodynamic\SDK\Web\UserSelectedPrinter;
use Neodynamic\SDK\Web\InstalledPrinter;
use Neodynamic\SDK\Web\ParallelPortPrinter;
use Neodynamic\SDK\Web\SerialPortPrinter;
use Neodynamic\SDK\Web\NetworkPrinter;


// Process request

// Generate ClientPrintJob? only if clientPrint param is in the query string
$urlParts = parse_url($_SERVER['REQUEST_URI']);
if (isset($urlParts['query'])) {
    $rawQuery = $urlParts['query'];
    parse_str($rawQuery, $qs);
    if (isset($qs[WebClientPrint::CLIENT_PRINT_JOB])) {
        
        //get printer commands
        $printerCommands = urldecode($qs['printerCommands']);

        //get printer settings
        $printerTypeId = $qs['pid'];
        $clientPrinter = NULL;    
        if ($printerTypeId == '0') //use default printer
        {
            $clientPrinter = new DefaultPrinter();
        }
        else if ($printerTypeId == '1') //show print dialog
        {
            $clientPrinter = new UserSelectedPrinter();
        }
        else if ($printerTypeId == '2') //use specified installed printer
        {
            $clientPrinter = new InstalledPrinter($qs['installedPrinterName']);
        }
        else if ($printerTypeId == '3') //use IP-Ethernet printer
        {
            $clientPrinter = new NetworkPrinter($qs['netPrinterHost'], $qs['netPrinterIP'], $qs['netPrinterPort']);
        }
        else if ($printerTypeId == '4') //use Parallel Port printer
        {
            $clientPrinter = new ParallelPortPrinter($qs['parallelPort']);
        }
        else if ($printerTypeId == '5') //use Serial Port printer
        {
            $clientPrinter = new SerialPortPrinter($qs['serialPort'],
                                                   $qs['serialPortBauds'],
                                                   $qs['serialPortParity'],
                                                   $qs['serialPortStopBits'],
                                                   $qs['serialPortDataBits'],
                                                   $qs['serialPortFlowControl']);
        }

        //Create a ClientPrintJob obj that will be processed at the client side by the WCPP
        $cpj = new ClientPrintJob();
        $cpj->clientPrinter = $clientPrinter;
        $cpj->printerCommands = $printerCommands;
        $cpj->formatHexValues = true;

        //Send ClientPrintJob back to the client
        ob_start();
        ob_clean();
        header('Content-type: application/octet-stream');
        echo $cpj->sendToClient();
        ob_end_flush();
        exit();
    }
            
}
    

 