<?php

namespace stalker\library\Fw;

/**
 * Puxa data do acesso do 
 * cliente ao site.
 * @author rafael
 * @package APP
 * @subpackage Fw
 */
class Data 
{	
	/**
	 * Puxa data de acesso 
	 * do cliente.
	 * @access public
	 */
	public static function getDataENNow()
	{	
		/**
		 * Retorna ano,mes e dia.
		 * @return Y-m-d
		 */
		return date("Y-m-d");
	}
	
	/**
	 * Converte formato americano
	 * de data para o formato
	 * brasileiro.
	 * @param conversão de data $data
	 * @access public
	 */
	public static function getDataBanco($data)
	{	
		/**
		 * retorna data convertida
		 * @return $data
		 */
		return "date_format($data,'%d/%m/%Y')";	
	}
	/**
	 * Identificar dia da semana
	 * do acesso
	 * @param return dia da semana $date
	 * @access public
	 */
	public static function isWeekend($date){
		/**
		 * Registra da semana.
		 * @name @weekDay
		 */
	    $weekDay = date('w', strtotime($date));
	    
	    /**
	     * Se dia da semana = 0
	     */
	    if($weekDay == 0){
	    	
	    	/**
	    	 * retorna dia 1.
	    	 */
	    	$day = 1;
	    	
	    }
	    /**
	     * Se dia da semana = 6
	     */
	    if($weekDay == 6){
	    	
	    	/**
	    	 * retorna dia 2.
	    	 */
	    	$day = 2;
	    	
	    }
	    /**
	     * Se retorna dia da semana
	     * = vai pra variavel $date.
	     */
	    if($weekDay != 0 && $weekDay != 6){
	    	
	    	/**
	    	 * @return $date
	    	 */
	    	return $date;
	    	
	    }
	    /**
	     * Informa data horario e dia da semana
	     * do acesso do cliente.
	     * @return $date
	     * @return $day
	     */
	    return date("Y-m-d", strtotime("$date +$day day"));
	    
	}
	
	/**
	 * Registra caso acesso ao fim de 
	 * semana
	 * @param se for fim de semana $date
	 * @access public
	 */
	public static function isFds($date){
		
		/**
		 * busca data e horario
		 * @var $weekday
		 * @param string $date
		 */
	    $weekDay = date('w', strtotime($date));
	    
	    /**
	     * se for dia de semana retorna
	     * falta
	     */
	    if($weekDay != 0 && $weekDay != 6){

	    	/**
	    	 * @return false
	    	 */
	    	return false;
	    	
	    }
	    /**
	     * Se não retorna true.
	     */
	    return true;
	    
	}
	
	/**
	 * Registra regista minutos e segundos.
	 * @param segundos $date1
	 * @param minutos $date2
	 * @return horas $hours
	 * @access public
	 */
	public static function getDiffHoursDateTime($date1,$date2){
		
		/**
		 * segundos
		 * @name $t1
		 * @param strin $date1
		 */
		$t1 = StrToTime ( $date1 );
		
		/**
		 * minutos
		 * @name $t2
		 * @param string $date2
		 */
		$t2 = StrToTime ( $date2 );
		
		/**
		 * subtração de t1 e t2.
		 * @name $diff
		 * @var $t1
		 * @var $t2
		 */
		$diff = $t1 - $t2;
		
		/**
		 * transforma minutos
		 * e segundos em horas
		 * @name $hours
		 * @var $diff
		 */
		$hours = $diff / ( 60 * 60 );
		
		/**
		 * retorna horas
		 * @return $hours
		 */
		return $hours;
		
	}
	
	/**
	 * Puxa dia mes e ano
	 * @param dia $day
	 * @param mes $month
	 * @param ano $year
	 * @access public
	 */
	public static function getWeekDay($day,$month,$year){
		
		/**
		 * Registra horario +
		 * ano, mes e dia
		 * @name $data
		 * @var $year
		 * @var $mouth
		 * @var $day
		 */
		$data = Fw_Data::getDiaSemanaBR(date("l",strtotime($year.'-'.$month.'-'.$day)));
		
		/**
		 * Retorna registro
		 * completo.
		 * @return $data
		 * 
		 */
		return $data;
		
	}
	/**
	 * Converte dia da semana Americano
	 * para o formato Brasileiro
	 * @access public
	 * @param string $data
	 */
	public static function getDiaSemana($data){
		/**
		 * separar palavras da semana
		 * com "-" exemplo terçafeira
		 * para terça-feira.
		 * @name $data
		 */
		$data=explode("-",$data);
		
		/**
		 * Altera formato de data
		 * @var $d_var
		 * @param string $data
		 */
		$d_var=getdate(mktime(0,0,0,$data[1],$data[2],$data[0]));
		
		/**
		 * Conversão de dia de semana.
		 * @param string $d_var
		 */
		switch (strtolower($d_var['weekday'])){
			case "tuesday": return "Terça-Feira";
			case "thursday": return "Quinta-Feira";
			case "saturday": return "Sábado";
			case "wednesday": return "Quarta-Feira";
		}
		/**
		 * @retunr $d_var
		 */
		return $d_var['weekday'];
	}
	
	/**
	 * Registro completo da dia da semana
	 * Americano para o formato Brasileiro.
	 * @param dia da semana $data.
	 * @access public
	 */
	public static function getDiaSemanaBR($data){
		
		/**
		 * caso haja tais registros faça converssão.
		 */
		switch ($data){
			case "Friday": return "Sexta-Feira";
			case "Monday": return "Segunda-Feira";
			case "Tuesday": return "Terça-Feira";
			case "Thursday": return "Quinta-Feira";
			case "Saturday": return "Sábado";
			case "Sunday": return "Domingo";
			case "Wednesday": return "Quarta-Feira";
		}
		
		
	}
	/**
	 * Altera apresentação do mês na linguagem
	 * Inglesa para Português
	 * @param unknown_type $data
	 * @access public
	 */
	public static function getMes($data){
		
		/**
		 * separa data por "-"
		 * @name data
		 * @param string $data
		 */
		$data=explode("-",$data);
		
		/**
		 * inverte apresentação da dia mes e ano
		 * inglês para formato português
		 * @name $d_var
		 * @param string $data
		 */
		$d_var=getdate(mktime(0,0,0,$data[1],$data[2],$data[0]));
		
		/**
		 * Caso haja mes em escrita Inglesa
		 * retorna para Português.
		 * $param string $d_var
		 */
		switch (strtolower($d_var['month'])){
			case "may":return "Maio";
			case "april":return "Abril";
			case "march":return "Março";
			case "january":return "Janeiro";
		}
		
		/**
		 * Retorna mes convetido.
		 * @return $d_var
		 */
		return $d_var['month'];
	}
	/**
	 * Puxa mes convertendo linguagem
	 * @param string $mes
	 * @return mes
	 * @access public
	 */
	public static function getMesBR($mes){
		
		switch ($mes){
			case "Jan":return "Janeiro";
			case "Feb":return "Fevereiro";
			case "Mar":return "Março";
			case "Apr":return "Abril";
			case "May":return "Maio";
			case "Jun":return "Junho";
			case "Jul":return "Julho";
			case "Aug":return "Agosto";
			case "Sep":return "Setembro";
			case "Oct":return "Outubro";
			case "Nov":return "Novembro";
			case "Dec":return "Dezembro";
		}
	}
	/**
	 * Puxa data convertida para
	 * formato Brasileiro
	 * @param data $data
	 * @param hora $time
	 * @return $rstData
	 * @access public
	 */
	public static function getDataBR($data,$time=null)
	{
		/**
		 * Se data ou hora subtraia ou separe
		 * de acordo com variaveis informadas.
		 * @name $data
		 * @var $dat
		 * @var $time
		 */
		if($data){
			$dat    = substr($data, 0, 10);
			$time    = substr($data, 10, 15);
			$dat    = explode ("-", $dat);
			$time    = explode (":", $time);
			
			/**
			 * Insera data na ordem informada
			 * @name $rstData
			 * @var $dat
			 */
			$rstData = "$dat[2]/$dat[1]/$dat[0]";
			
			/**
			 * Se informa apenas data, informara
			 * dia hora e minuto
			 */
			if($time[0]){
				$rstData = "$dat[2]/$dat[1]/$dat[0] $time[0]:$time[1]";
			}
			
			/**
			 * retorna variavel convertida
			 * @return $rstData
			 */
			return $rstData;
		}
	}
	
	/**
	 * Puxa dia e mes em formato
	 * Brasileiro.
	 * @param string $data
	 * @access public
	 */
	public static function getDiaMesBR($data)
	{	
		/**
		 * Subtraia $dat && $time
		 * separe informações com
		 * as caracteres informadas.
		 */
		if($data){
			$dat    = substr($data, 0, 10);
			$time    = substr($data, 10, 15);
			$dat    = explode ("-", $dat);
			$time    = explode (":", $time);
		
			/**
			 * retorna variaveis
			 * @name $rstData
			 * @var $dat
			 */
			$rstData = "$dat[2]/$dat[1]";
			
			/**
			 * @return $rstData
			 */
			return $rstData;
		}
	}
	
	/**
	 * Puxa Data e hora
	 * @param data $data
	 * @access public
	 */
	public static function getDataHBR($data)
	{
		$dat    = substr($data, 0, 10);
		$time    = substr($data, 10, 15);
		$dat    = explode ("-", $dat);
		$time    = explode (":", $time);

		$rstData = "$dat[2]/$dat[1]/$dat[0]";
		
		return $rstData;
	}
	
	public static function getHora($data)
	{
		$dat    = substr($data, 0, 10);
		$time    = substr($data, 10, 15);
		$dat    = explode ("-", $dat);
		$time    = explode (":", $time);

		$rstData = "$time[0]:$time[1]";
		
		if($time[0] == "00" && $time[1] == "00")
		{
			return;
		}
		
		return $rstData;
	}
	
	public static function getDataEN($data)
	{
		$data    = substr($data, 0, 10);
		$d       = explode ("/", $data);
		$rstData = "$d[2]-$d[1]-$d[0]";
		
		if($data)
			return $rstData;
	}
}

?>
