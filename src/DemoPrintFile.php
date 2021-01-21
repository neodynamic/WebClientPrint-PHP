<?php 
  ob_start();
  session_start();
  
  include 'WebClientPrint.php';
  use Neodynamic\SDK\Web\WebClientPrint;
  use Neodynamic\SDK\Web\Utils;

  $title = 'WebClientPrint for PHP - Print Known File Formats';
  
?>

<div class="container">
    <div class="row">
        
            <h3><a href="Samples.php" class="btn btn-md btn-danger"><i class="fa fa-chevron-left"></i></a>&nbsp;Print Known File Formats without displaying any Print dialog! <small>(if needed)</small></h3>
            <p>
                With <strong>WebClientPrint for PHP</strong> solution you can <strong>print most common file formats</strong> <em>(PDF, TXT, DOC/X, XLS/X, JPG/JPEG, PNG, TIF/TIFF)</em> right to any installed printer at the client side.
            </p>

            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="btn btn-info btn-lg">Client System Requirements
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="background-color: #ececec; font-weight: bold; color: #666">
                                        <td style="width: 20%">File Format</td>
                                        <td style="width: 40%">Windows Clients</td>
                                        <td style="width: 40%">Linux, Raspberry Pi &amp; Mac Clients</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>DOC, DOCX</td>
                                        <td><span class="badge alert-warning"><i class="glyphicon glyphicon-info-sign"></i></span>Microsoft Word is required</td>
                                        <td><span class="badge alert-warning"><i class="glyphicon glyphicon-info-sign"></i></span>LibreOffice is required</td>
                                    </tr>
                                    <tr>
                                        <td>XLS, XLSX</td>
                                        <td><span class="badge alert-warning"><i class="glyphicon glyphicon-info-sign"></i></span>Microsoft Excel is required</td>
                                        <td><span class="badge alert-warning"><i class="glyphicon glyphicon-info-sign"></i></span>LibreOffice is required</td>
                                    </tr>
                                    <tr>
                                        <td>PDF</td>
                                        <td><span class="badge alert-success"><i class="glyphicon glyphicon-ok-sign"></i></span>Natively supported!</td>
                                        <td><span class="badge alert-success"><i class="glyphicon glyphicon-ok-sign"></i></span>Natively supported!</td>
                                    </tr>
                                    <tr>
                                        <td>TXT</td>
                                        <td><span class="badge alert-success"><i class="glyphicon glyphicon-ok-sign"></i></span>Natively supported!</td>
                                        <td><span class="badge alert-success"><i class="glyphicon glyphicon-ok-sign"></i></span>Natively supported!</td>
                                    </tr>
                                    <tr>
                                        <td>JPEG</td>
                                        <td><span class="badge alert-success"><i class="glyphicon glyphicon-ok-sign"></i></span>Natively supported!</td>
                                        <td><span class="badge alert-success"><i class="glyphicon glyphicon-ok-sign"></i></span>Natively supported!</td>
                                    </tr>
                                    <tr>
                                        <td>PNG</td>
                                        <td><span class="badge alert-success"><i class="glyphicon glyphicon-ok-sign"></i></span>Natively supported!</td>
                                        <td><span class="badge alert-success"><i class="glyphicon glyphicon-ok-sign"></i></span>Natively supported!</td>
                                    </tr>
                                    <tr>
                                        <td>BMP</td>
                                        <td><span class="badge alert-success"><i class="glyphicon glyphicon-ok-sign"></i></span>Natively supported!</td>
                                        <td><span class="badge alert-success"><i class="glyphicon glyphicon-ok-sign"></i></span>Natively supported!</td>
                                    </tr>
                                    <tr>
                                        <td>Printer Support</td>
                                        <td><span class="badge alert-warning"><i class="glyphicon glyphicon-info-sign"></i></span>You can print files to local installed printers ONLY! Parallel, Serial and IP/Ethernet printers are NOT supported for printing files but for printing raw commands.</td>
                                        <td><span class="badge alert-success"><i class="glyphicon glyphicon-ok-sign"></i></span>You can print files to any installed printers through CUPS system.</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed btn btn-info btn-lg" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Test Printing Now!
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <p>
                                The following are pre-selected files to test WebClientPrint File Printing feature.
                            </p>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-2">
                                    <hr />
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="useDefaultPrinter" />
                                            <strong>Print to Default printer</strong> or...
                                        </label>
                                    </div>
                                    <div id="loadPrinters">
                                        Click to load and select one of the installed printers!
                                        <br />
                                        <a onclick="javascript:jsWebClientPrint.getPrinters();" class="btn btn-success">Load installed printers...</a>
                                        <br />
                                        <br />
                                    </div>
                                    <div id="installedPrinters" style="visibility: hidden">
                                        <label for="installedPrinterName">Select an installed Printer:</label>
                                        <select name="installedPrinterName" id="installedPrinterName" class="form-control"></select>
                                    </div>
                                    <script type="text/javascript">
                                        //var wcppGetPrintersDelay_ms = 0;
                                        var wcppGetPrintersTimeout_ms = 60000; //60 sec
                                        var wcppGetPrintersTimeoutStep_ms = 500; //0.5 sec
                                        function wcpGetPrintersOnSuccess() {
                                            // Display client installed printers
                                            if (arguments[0].length > 0) {
                                                var p = arguments[0].split("|");
                                                var options = '';
                                                for (var i = 0; i < p.length; i++) {
                                                    options += '<option>' + p[i] + '</option>';
                                                }
                                                $('#installedPrinters').css('visibility', 'visible');
                                                $('#installedPrinterName').html(options);
                                                $('#installedPrinterName').focus();
                                                $('#loadPrinters').hide();
                                            } else {
                                                alert("No printers are installed in your system.");
                                            }
                                        }
                                        function wcpGetPrintersOnFailure() {
                                            // Do something if printers cannot be got from the client
                                            alert("No printers are installed in your system.");
                                        }
                                    </script>
                                </div>
                                <div class="col-md-4">
                                    <hr />
                                    <div id="fileToPrint">
                                        <label for="ddlFileType">Select a sample File to print:</label>
                                        <select id="ddlFileType" class="form-control">
                                            <option>PDF</option>
                                            <option>TXT</option>
                                            <option>DOC</option>
                                            <option>XLS</option>
                                            <option>JPG</option>
                                            <option>PNG</option>
                                            <option>TIF</option>
                                        </select>
                                        <br />
                                        <a class="btn btn-success btn-lg" onclick="javascript:jsWebClientPrint.print('useDefaultPrinter=' + $('#useDefaultPrinter').attr('checked') + '&printerName=' + encodeURIComponent($('#installedPrinterName').val()) + '&filetype=' + $('#ddlFileType').val());">Print File...</a>
                                    </div>
                                </div>
                            </div>
                            <h5>File Preview</h5>
                            <iframe id="ifPreview" style="width: 100%; height: 500px;" frameborder="0"></iframe>

                        </div>
                    </div>
                </div>

            </div>
            
        
    </div>
</div>


<?php
  $content = ob_get_contents();
  ob_clean();
?>    


<?php
  
    //Get Absolute URL of this page
    $currentAbsoluteURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $currentAbsoluteURL .= $_SERVER["SERVER_NAME"];
    if($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443")
    {
        $currentAbsoluteURL .= ":".$_SERVER["SERVER_PORT"];
    } 
    $currentAbsoluteURL .= $_SERVER["REQUEST_URI"];
    
    //WebClientPrinController.php is at the same page level as WebClientPrint.php
    $webClientPrintControllerAbsoluteURL = substr($currentAbsoluteURL, 0, strrpos($currentAbsoluteURL, '/')).'/WebClientPrintController.php';
    
    //DemoPrintFileController.php is at the same page level as WebClientPrint.php
    $demoPrintFileControllerAbsoluteURL = substr($currentAbsoluteURL, 0, strrpos($currentAbsoluteURL, '/')).'/DemoPrintFileController.php';
    
    //Specify the ABSOLUTE URL to the WebClientPrintController.php and to the file that will create the ClientPrintJob object
    echo WebClientPrint::createScript($webClientPrintControllerAbsoluteURL, $demoPrintFileControllerAbsoluteURL, session_id());
?>

<script type="text/javascript">
    $("#ddlFileType").change(function () {
        var s = $("#ddlFileType option:selected").text();
        if (s == 'PDF') $("#ifPreview").attr("src", "//docs.google.com/gview?url=http://webclientprintphp.azurewebsites.net/files/LoremIpsum.pdf&embedded=true");
        if (s == 'TXT') $("#ifPreview").attr("src", "//docs.google.com/gview?url=http://webclientprintphp.azurewebsites.net/files/LoremIpsum.txt&embedded=true");
        if (s == 'TIF') $("#ifPreview").attr("src", "//docs.google.com/gview?url=http://webclientprintphp.azurewebsites.net/files/patent2pages.tif&embedded=true");
        if (s == 'XLS') $("#ifPreview").attr("src", "//docs.google.com/gview?url=http://webclientprintphp.azurewebsites.net/files/SampleSheet.xls&embedded=true");
        if (s == 'DOC') $("#ifPreview").attr("src", "//docs.google.com/gview?url=http://webclientprintphp.azurewebsites.net/files/LoremIpsum.doc&embedded=true");
        if (s == 'JPG') $("#ifPreview").attr("src", "//webclientprintphp.azurewebsites.net/files/penguins300dpi.jpg");
        if (s == 'PNG') $("#ifPreview").attr("src", "//webclientprintphp.azurewebsites.net/files/SamplePngImage.png");
    }).change();
</script>

<?php
  $script = ob_get_contents();
  ob_clean();
  
  
  include("template.php");
?>

