<?php
  ob_start();
  
  $title = 'WebClientPrint for PHP Samples';
?>

<h2>Available Samples</h2>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <h2>
                    <a href="DemoPrintCommands.php"><i class="icon fa fa-barcode"></i>&nbsp;Raw Data Printing</a>
                </h2>
                <p>
                    Send any <strong>raw data &amp; commands</strong> supported by the client printer like <strong>Epson ESC/POS, HP PCL, PostScript, Zebra ZPL and Eltron EPL, and more!</strong>
                </p>
            </div>
            <div class="col-sm-4">
                <h2>
                    <a href="DemoPrintFile.php"><i class="icon fa fa-file-text-o"></i>&nbsp;Print Files</a>
                </h2>
                <p>
                    Print <strong>PDF, TXT, DOC, XLS, JPG & PNG images</strong> to a client printer <strong>without displaying any Print dialog!</strong>
                </p>
            </div>
            <div class="col-sm-4">
                <h2>
                    <a href="PrintersInfo.php"><i class="icon fa fa-print"></i>&nbsp;Printers Info</a>
                </h2>
                <p>
                    Collect many useful info from all the installed printers in the client machine.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <h2>
                    <a href="DemoPrintFilePDF.php"><i class="icon fa fa-file-pdf-o"></i>&nbsp;Advanced PDF Printing</a>
                </h2>
                <p>
                    Print <strong>PDF</strong> files specifying advanced settings like <strong>tray, paper source, print rotation, duplex printing, pages range and more!</strong>
                </p>
            </div>
            <div class="col-sm-4">
                <h2>
                    <a href="DemoPrintFileDOC.php"><i class="icon fa fa-file-word-o"></i>&nbsp;Advanced DOC Printing</a>
                </h2>
                <p>
                    Print <strong>DOC</strong> files specifying advanced settings like <strong>duplex printing, pages range, print in reverse and more!</strong> <span class="label label-info">Windows Only</span>
                </p>
            </div>
            <div class="col-sm-4">
                <h2>
                    <a href="DemoPrintFileXLS.php"><i class="icon fa fa-file-excel-o"></i>&nbsp;Advanced XLS Printing</a>
                </h2>
                <p>
                    Print <strong>XLS</strong> files specifying advanced settings like <strong>pages range (From - To) and more!</strong> <span class="label label-info">Windows Only</span>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <h2>
                    <a href="DemoPrintFileTIF.php"><i class="icon fa fa-files-o"></i>&nbsp;Advanced TIF Printing</a>
                </h2>
                <p>
                    Print <strong>Multipage TIF</strong> files specifying advanced settings like <strong>tray, paper source, print rotation, duplex printing, pages range and more!</strong>
                </p>
            </div>
            <div class="col-sm-4">
                <h2>
                    <a href="DemoPrintFileWithEncryption.php"><i class="icon fa fa-lock"></i>&nbsp;Print Files With Encryption</a>
                </h2>
                <p>
                    <strong>Encrypt and Print PDF, TXT, JPG & PNG files!</strong> 
                </p>
            </div>
            <div class="col-sm-4">
               <h2>
                    <a href="DemoPrintFileWithPwdProtection.php"><i class="icon fa fa-key"></i>&nbsp;Print Files With Password Protection</a>
                </h2>
                <p>
                    <strong>Print Password Protected PDF, DOC & XLS files!</strong> 
                </p>
            </div>
        </div>
    </div>


<?php
  $content = ob_get_contents();
  ob_clean();
  
  include("template.php");
?>

