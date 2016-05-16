<?php 

namespace stalker\library\Fw;

class Exportar{
	
	public static function get($arquivo,$html){
		
		header('Content-Encoding: Windows-1252');
		header("Content-Transfer-Encoding: binary");
		
		// Determina que o arquivo é uma planilha do Excel
		header("Content-type: application/vnd.ms-excel; charset=Windows-1252");
		//header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=UTF-8");
		
		// Força o download do arquivo
		//header("Content-type: application/force-download");
		
		// Seta o nome do arquivo
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		
		header("Pragma: public");
		
		/*header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		header ("Content-Description: PHP Generated Data" );*/
		
		$output = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
				<head>
					<style>
					.num {
					  mso-number-format:General;
					}
					.text{
					  mso-number-format:"\@";/*force text*/
					}
					</style>
				    <!--[if gte mso 9]>
				    <xml>
				        <x:ExcelWorkbook>
				            <x:ExcelWorksheets>
				                <x:ExcelWorksheet>
				                    <x:Name>Relatorio</x:Name>
				                    <x:WorksheetOptions>
				                        <x:Print>
				                            <x:ValidPrinterInfo/>
				                        </x:Print>
				                    </x:WorksheetOptions>
				                </x:ExcelWorksheet>
				            </x:ExcelWorksheets>
				        </x:ExcelWorkbook>
				    </xml>
				    <![endif]-->
				</head>
				
				<body>';
		
		$output .= $html;
				
		$output .= "</body></html>";
		
		echo $output;
		
		exit;
		
	} 
	
}

?>