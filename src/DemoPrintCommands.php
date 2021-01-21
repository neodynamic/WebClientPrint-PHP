<?php 
  ob_start();
  session_start();
  
  include 'WebClientPrint.php';
  use Neodynamic\SDK\Web\WebClientPrint;
  use Neodynamic\SDK\Web\Utils;

  $title = 'WebClientPrint for PHP - Print Commands Demo';
  
  $style = 'fieldset {
            width: 700px;
            border: 0 none #ffffff;
        }

        legend {
            visibility: hidden;
        }

        label {
            display: block;
            margin: 15px 0 5px;
        }

        input[type=text], input[type=password] {
            width: 300px;
            padding: 5px;
            border: solid 1px #000;
        }

        .prev {
            float: left;
        }

        .next {
            float: right;
        }

        #steps {
            list-style: none;
            width: 100%;
            overflow: hidden;
            margin: 0px;
            padding: 0px;
        }

            #steps li {
                font-size: 24px;
                float: left;
                padding: 10px;
                color: #b0b1b3;
            }

                #steps li span {
                    font-size: 11px;
                    display: block;
                }

                #steps li.current {
                    color: #000;
                }';
  
?>

 <h3><a href="Samples.php" class="btn btn-md btn-danger"><i class="fa fa-chevron-left"></i></a>&nbsp;Print Raw/Text Commands</h3>

<div class="container">
    <div class="row">
        <form id="myForm" action="">

            <input type="hidden" id="sid" name="sid" value="<?php echo session_id(); ?>" />

            <fieldset>
                <legend>Client Printer Settings</legend>

                <div>
                    WebClientPrint does support all common printer communications like USB-Installed
                    Drivers, Network/IP-Ethernet, Serial COM-RS232 and Parallel (LPT).
                    <br />
                    <br />
                    I want to:&nbsp;&nbsp;
                    <select id="pid" name="pid" class="form-control">
                        <option selected="selected" value="0">Use Default Printer</option>
                        <option value="1">Display a Printer dialog</option>
                        <option value="2">Use an installed Printer</option>
                        <option value="3">Use an IP/Etherner Printer</option>
                        <option value="4">Use a LPT port</option>
                        <option value="5">Use a RS232 (COM) port</option>
                    </select>
                    <br />
                    <br />
                    <div id="info" class="alert alert-info" style="font-size:11px;"></div>
                    <br />
                </div>

                <div id="installedPrinter">
                    <div id="loadPrinters" name="loadPrinters">
                        WebClientPrint can detect the installed printers in your machine. <a onclick="javascript:jsWebClientPrint.getPrinters();" class="btn btn-success">Load installed printers...</a>
                        <br /><br />
                    </div>
                    <label for="installedPrinterName">Select an installed Printer:</label>
                    <select name="installedPrinterName" id="installedPrinterName" class="form-control"></select>


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

                <div id="netPrinter">
                    <label for="netPrinterHost">Printer's DNS Name or IP Address:</label>
                    <input type="text" name="netPrinterHost" id="netPrinterHost" class="form-control"/>
                    <label for="netPrinterPort">Printer's Port:</label>
                    <input type="text" name="netPrinterPort" id="netPrinterPort" class="form-control"/>
                </div>

                <div id="parallelPrinter">
                    <label for="parallelPort">Parallel Port:</label>
                    <input type="text" name="parallelPort" id="parallelPort" value="LPT1" class="form-control"/>
                </div>

                <div id="serialPrinter">
                    <table border="0">
                        <tr>
                            <td valign="top">
                                <label for="serialPort">Serial Port:</label>
                                <input type="text" name="serialPort" id="serialPort" value="COM1" class="form-control"/>
                                <label for="serialPortBauds">Baud Rate:</label>
                                <input type="text" name="serialPortBauds" id="serialPortBauds" value="9600" class="form-control"/>
                                <label for="serialPortDataBits">Data Bits:</label>
                                <input type="text" name="serialPortDataBits" id="serialPortDataBits" value="8" class="form-control"/>
                            </td>
                            <td style="width:30px;"></td>
                            <td valign="top">
                                <label for="serialPortParity">Parity:</label>
                                <select id="serialPortParity" name="serialPortParity" class="form-control">
                                    <option selected="selected">None</option>
                                    <option>Odd</option>
                                    <option>Even</option>
                                    <option>Mark</option>
                                    <option>Space</option>
                                </select>

                                <label for="serialPortStopBits">Stop Bits:</label>
                                <select id="serialPortStopBits" name="serialPortStopBits" class="form-control">
                                    <option selected="selected">One</option>
                                    <option>Two</option>
                                    <option>OnePointFive</option>
                                </select>

                                <label for="serialPortFlowControl">Flow Control:</label>
                                <select id="serialPortFlowControl" name="serialPortFlowControl" class="form-control">
                                    <option selected="selected">None</option>
                                    <option>XOnXOff</option>
                                    <option>RequestToSend</option>
                                    <option>RequestToSendXOnXOff</option>
                                </select>
                            </td>
                        </tr>
                    </table>


                </div>

            </fieldset>
            <fieldset>
                <legend>Printer Commands</legend>

                <p>
                    Enter the printer's commands you want to send and is supported by the specified printer (ESC/P, PCL, ZPL, EPL, DPL, IPL, EZPL, etc).
                    <br /><br />
                    <b>NOTE:</b> You can use the <b>hex notation of VB or C# for non-printable characters</b> e.g. for Carriage Return (ASCII 13) you could use &H0D or 0x0D
                </p>
                <div class="alert alert-info" style="font-size:11px;">
                    <b>Upload Files</b><br />
                    This online demo does not allow you to upload files. So, if you have a file containing the printer commands like a PRN file, Postscript, PCL, ZPL, etc, then we recommend you to <a href="//neodynamic.com/products/printing/raw-data/php/download/" target="_blank">download WebClientPrint</a> and test it by using the sample source code included in the package. Feel free to <a href="http://www.neodynamic.com/support" target="_blank">contact our Tech Support</a> for further assistance, help, doubts or questions.
                </div>
                <textarea id="printerCommands" name="printerCommands" rows="10" cols="80" class="form-control" style="min-width: 100%"></textarea>
                
            </fieldset>
            <fieldset>
                <legend>Ready to print!</legend>
                <h3>Your settings were saved! Now it's time to <a href="#" onclick="javascript:doClientPrint();" class="btn btn-lg btn-success">Print</a></h3>
                <br /><br />
            </fieldset>
            <br /><br />

        </form>
        </div>
    </div>
        <br />
        <br />
        <br />


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
    
    //_DemoPrintCommandsController.php is at the same page level as WebClientPrint.php
    $demoPrintCommandsControllerAbsoluteURL = substr($currentAbsoluteURL, 0, strrpos($currentAbsoluteURL, '/')).'/DemoPrintCommandsController.php';
    
    //Specify the ABSOLUTE URL to the WebClientPrintController.php and to the file that will create the ClientPrintJob object (DemoPrintCommandsController.php)
    echo WebClientPrint::createScript($webClientPrintControllerAbsoluteURL, $demoPrintCommandsControllerAbsoluteURL, session_id());
?>

        
 <script type="text/javascript">

                function doClientPrint() {

                    //collect printer settings and raw commands
                    var printJobInfo = $("#myForm").serialize();

                    // Launch WCPP at the client side for printing...
                    jsWebClientPrint.print(printJobInfo);

                }


                $(document).ready(function () {
                    //jQuery-based Wizard
                    $("#myForm").formToWizard();

                    //change printer options based on user selection
                    $("#pid").change(function () {
                        var printerId = $("select#pid").val();

                        displayInfo(printerId);
                        hidePrinters();
                        if (printerId == 2)
                            $("#installedPrinter").show();
                        else if (printerId == 3)
                            $("#netPrinter").show();
                        else if (printerId == 4)
                            $("#parallelPrinter").show();
                        else if (printerId == 5)
                            $("#serialPrinter").show();
                    });

                    hidePrinters();
                    displayInfo(0);


                });

                function displayInfo(i) {
                    if (i == 0)
                        $("#info").html('This will make the WCPP to send the commands to the printer installed in your machine as "Default Printer" without displaying any dialog!');
                    else if (i == 1)
                        $("#info").html('This will make the WCPP to display the Printer dialog so you can select which printer you want to use.');
                    else if (i == 2)
                        $("#info").html('Please specify the <b>Printer\'s Name</b> as it figures installed under your system.');
                    else if (i == 3)
                        $("#info").html('Please specify the Network Printer info.<br /><strong>On Linux &amp; Mac</strong> it\'s recommended you install the printer through <strong>CUPS</strong> and set the assigned printer name to the <strong>"Use an installed Printer"</strong> option on this demo.');
                    else if (i == 4)
                        $("#info").html('Please specify the Parallel Port which your printer is connected to.<br /><strong>On Linux &amp; Mac</strong> you must install the printer through <strong>CUPS</strong> and set the assigned printer name to the <strong>"Use an installed Printer"</strong> option on this demo.');
                    else if (i == 5)
                        $("#info").html('Please specify the Serial RS232 Port info which your printer does support.<br /><strong>On Linux &amp; Mac</strong> you must install the printer through <strong>CUPS</strong> and set the assigned printer name to the <strong>"Use an installed Printer"</strong> option on this demo.');
                }

                function hidePrinters() {
                    $("#installedPrinter").hide(); $("#netPrinter").hide(); $("#parallelPrinter").hide(); $("#serialPrinter").hide();
                }




                /* FORM to WIZARD */
                /* Created by jankoatwarpspeed.com */

                (function ($) {
                    $.fn.formToWizard = function () {

                        var element = this;

                        var steps = $(element).find("fieldset");
                        var count = steps.size();


                        // 2
                        $(element).before("<ul id='steps'></ul>");

                        steps.each(function (i) {
                            $(this).wrap("<div id='step" + i + "'></div>");
                            $(this).append("<p id='step" + i + "commands'></p>");

                            // 2
                            var name = $(this).find("legend").html();
                            $("#steps").append("<li id='stepDesc" + i + "'>Step " + (i + 1) + "<span>" + name + "</span></li>");

                            if (i == 0) {
                                createNextButton(i);
                                selectStep(i);
                            }
                            else if (i == count - 1) {
                                $("#step" + i).hide();
                                createPrevButton(i);
                            }
                            else {
                                $("#step" + i).hide();
                                createPrevButton(i);
                                createNextButton(i);
                            }
                        });

                        function createPrevButton(i) {
                            var stepName = "step" + i;
                            $("#" + stepName + "commands").append("<a href='#' id='" + stepName + "Prev' class='prev btn btn-info'>< Back</a>");

                            $("#" + stepName + "Prev").bind("click", function (e) {
                                $("#" + stepName).hide();
                                $("#step" + (i - 1)).show();

                                selectStep(i - 1);
                            });
                        }

                        function createNextButton(i) {
                            var stepName = "step" + i;
                            $("#" + stepName + "commands").append("<a href='#' id='" + stepName + "Next' class='next btn btn-info'>Next ></a>");

                            $("#" + stepName + "Next").bind("click", function (e) {
                                $("#" + stepName).hide();
                                $("#step" + (i + 1)).show();

                                selectStep(i + 1);
                            });
                        }

                        function selectStep(i) {
                            $("#steps li").removeClass("current");
                            $("#stepDesc" + i).addClass("current");
                        }

                    }
                })(jQuery);

            </script>
            

<?php
  $script = ob_get_contents();
  ob_clean();
  
  
  include("template.php");
?>

