<?php 
App::import('Vendor','mpdf',array('file'=>'mpdf'.DS.'mpdf.php'));

$pdf =null;
if ($result['papersize'])
	$pdf = new mPDF('utf-8', $report['papersize']);
else
	$pdf = new mPDF('utf-8', 'LETTER');

$pdf->progbar_heading = 'WebLIS Analytics';
$pdf->progbar_altHTML = '
	<div style="margin-top: 5em; text-align: center; font-family: Verdana; font-size: 12px;"><img style="vertical-align: middle" src="/img/loading.gif" /> Creating PDF file. Please wait...</div>';

if (isset($result['settings']['autoprint']) && $result['settings']['autoprint'])
	$pdf->SetJS('function() closeDoc {/*var str="click ok to close"; app.alert(str); app.setTimeOut("this.closeDoc(true);", 5000);*/} function() silentPrint{app.beginPriv(); try { var pp=this.getPrintParams(); pp.interactive=pp.constants.interactionLevel.silent; this.print(pp);   } catch(err){ alert(err);} app.endPriv();} closeDoc(); var SilentPrint = app.trustedFunction(silentPrint); silentPrint();');
elseif (!isset($result['settings']['autoprint']))
	$pdf->SetJS('function() closeDoc {/*var str="click ok to close"; app.alert(str); app.setTimeOut("this.closeDoc(true);", 5000);*/} function() silentPrint{app.beginPriv(); try { var pp=this.getPrintParams(); pp.interactive=pp.constants.interactionLevel.silent; this.print(pp);   } catch(err){ alert(err);} app.endPriv();} closeDoc(); var SilentPrint = app.trustedFunction(silentPrint); silentPrint();');

$pdf->SetWatermarkImage('','0.1', '200', 'array(50,100)');
$pdf->showWatermarkImage = true;
$pdf->WriteHTML($content_for_layout);

$pdf->Output($data['title'],'I');


?>

