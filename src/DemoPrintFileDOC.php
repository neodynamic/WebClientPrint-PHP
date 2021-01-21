<?php 
  ob_start();
  session_start();
  
  include 'WebClientPrint.php';
  use Neodynamic\SDK\Web\WebClientPrint;
  use Neodynamic\SDK\Web\Utils;

  $title = 'WebClientPrint for PHP - Advanced DOC Printing';
  
  $style = '.glyphicon-refresh-animate {
            -animation: spin .7s infinite linear;
            -webkit-animation: spin2 .7s infinite linear;
        }

        @-webkit-keyframes spin2 {
            from {
                -webkit-transform: rotate(0deg);
            }

            to {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            from {
                transform: scale(1) rotate(0deg);
            }

            to {
                transform: scale(1) rotate(360deg);
            }
        }';
  
?>

<input type="hidden" id="sid" name="sid" value="<?php echo session_id(); ?>" />


    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <h3><a href="Samples.php" class="btn btn-md btn-danger"><i class="fa fa-chevron-left"></i></a>&nbsp;Advanced DOC Printing</h3>
                <p>
                    With <strong>WebClientPrint for PHP</strong> solution you can <strong>print DOC files</strong> right to any installed printer at the client side with advanced settings.
                </p>
                <div class="alert alert-info"><strong>Requirements:</strong> 
                    <ul>
                        <li>Available for <strong>Windows clients only</strong></li>
                        <li><strong>Microsoft Word 97+</strong> must be installed at the client machine</li>
                        <li>DOC files can be any of these file formats: <strong>*.docx, *.docm, *.dotx, *.dotm, *.doc, *.dot, *.rtf, and *.odt</strong></li>
                    </ul>
                </div>

                <div class="form-group well">
                    <h4>Click on <strong>"Get Printers Info"</strong> button to get installed Printers</h4>
                    <div class="row">

                        <div class="col-md-3">
                            <a onclick="javascript:jsWebClientPrint.getPrinters(); $('#spinner').css('visibility', 'visible');" class="btn btn-success">Get Printers...</a>
                        </div>
                        <div class="col-md-9">
                            <h3 id="spinner" style="visibility: hidden"><span class="label label-info"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>Please wait a few seconds...</span></h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="lstPrinters">Printers:</label>
                            <select name="lstPrinters" id="lstPrinters" class="form-control"></select>
                        </div>
                        <div class="col-md-3">
                            <label for="txtPagesRange">Pages Range: [e.g. 1,2,3,10-15]</label>
                            <input type="text" class="form-control" id="txtPagesRange">
                        </div>
                        <div class="col-md-3">
                             <div class="checkbox">
                              <label><input id="chkPrintInReverseOrder" type="checkbox" value="">Print In Reverse Order?</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="checkbox">
                              <label><input id="chkDuplexPrinting" type="checkbox" value="">Duplex Printing?</label>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        
                        <div class="col-md-12">
                             <a class="btn btn-success btn-lg pull-right" onclick="javascript:jsWebClientPrint.print('printerName=' + encodeURIComponent($('#lstPrinters').val()) + '&pagesRange=' + encodeURIComponent($('#txtPagesRange').val()) + '&printInReverseOrder=' + $('#chkPrintInReverseOrder').prop('checked') + '&duplexPrinting=' + $('#chkDuplexPrinting').prop('checked'));"><strong>Print DOC...</strong></a>
                        </div>
                    </div>
                    <hr />
                    <h4>DOC File Sample Preview - <strong>38 Pages!!!</strong></h4>
                    <iframe id="ifPreview" style="width: 100%; height: 500px;" frameborder="0" src="//docs.google.com/gview?url=https://webclientprint.azurewebsites.net/files/Sample-Employee-Handbook.doc&embedded=true"></iframe>

                </div>

            </div>


        </div>
    </div>

    <script type="text/javascript">
        //var wcppGetPrintersDelay_ms = 0;
        var wcppGetPrintersTimeout_ms = 60000; //60 sec
        var wcppGetPrintersTimeoutStep_ms = 500; //0.5 sec
        function wcpGetPrintersOnSuccess() {
            $('#spinner').css('visibility', 'hidden');
            // Display client installed printers
            if (arguments[0].length > 0) {
                var p = arguments[0].split("|");
                var options = '';
                for (var i = 0; i < p.length; i++) {
                    options += '<option>' + p[i] + '</option>';
                }
                $('#lstPrinters').html(options);
                $('#lstPrinters').focus();
            } else {
                alert("No printers are installed in your system.");
            }
        }
        function wcpGetPrintersOnFailure() {
            $('#spinner').css('visibility', 'hidden');
            // Do something if printers cannot be got from the client
            alert("No printers are installed in your system.");
        }
    </script>


    
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
    
    //DemoPrintFileDOCController.php is at the same page level as WebClientPrint.php
    $demoPrintFileDOCControllerAbsoluteURL = substr($currentAbsoluteURL, 0, strrpos($currentAbsoluteURL, '/')).'/DemoPrintFileDOCController.php';
    
    //Specify the ABSOLUTE URL to the WebClientPrintController.php and to the file that will create the ClientPrintJob object
    echo WebClientPrint::createScript($webClientPrintControllerAbsoluteURL, $demoPrintFileDOCControllerAbsoluteURL, session_id());
?>

<?php
  $script = ob_get_contents();
  ob_clean();
  
  
  include("template.php");
?>

