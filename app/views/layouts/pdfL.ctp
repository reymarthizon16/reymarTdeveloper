<?php 
//header("Content-type: application/pdf"); 
//echo $content_for_layout; 

?>

<?php 
App::import('Vendor','mpdf',array('file'=>'mpdf'.DS.'mpdf.php'));
	
if ($report['papersize']){
	
	if(!isset($report['paperorientation']) || $report['paperorientation']!='landscape'){
		$pdf = new mPDF('utf-8', $report['papersize']);	
	}else{
		
		$pdf = new mPDF('utf-8',$report['papersize'],
			0, //font size
			'',// font family
			0,// margin_left
			0,// margin_right
			0,// margin_top
			0,// margin_bottom
			0,//margin header
			0,// margin footer
			'L');// L- landscape ,P-protrait
	}
	
}
else
	$pdf = new mPDF('utf-8', 
			'', // size of paper
			0, //font size
			'',// font family
			0,// margin_left
			0,// margin_right
			0,// margin_top
			0,// margin_bottom
			0,//margin header
			0,// margin footer
			'L');// L- landscape ,P-protrait
	

//$pdf->SetWatermarkImage('media/taclobanwatermark.png',0.1);
// $pdf->showWatermarkImage = true;
// $this->log($content_for_layout,'print');
$pdf->WriteHTML($content_for_layout);

$pdf->Output($data['title'],'I');


?>



