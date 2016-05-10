<?php
	abstract class banco{
		//propriedades
		private $servidor       = "localhost";
	  	private $usuario        = "root";
	  	private $senha          = "";
	  	private $nomebanco      = "focoefe";
	  	private $conexao        = NULL;
	  	private $dataset        = NULL;
	  	private $linhasafetadas = -1;
		
		public function __construct(){
			$this->conecta();
		}
		
		public function __destruct(){
			if($this->conexao != NULL):
				mysql_close($this->conexao);
			endif;	
		}
		
	  	//métodos
		public function conecta(){
			$this->conexao = mysql_connect($this->servidor,$this->usuario,$this->senha,TRUE) 
			or die($this->trataerro(__FILE__,__FUNCTION__,mysql_errno(),mysql_error(), TRUE));
			mysql_select_db($this->nomebanco) or die($this->trataerro(__FILE__,__FUNCTION__,mysql_errno(),mysql_error(), TRUE));
			mysql_query("SET NAMES 'utf8'");
			mysql_query("SET character_set_connection=utf8");
			mysql_query("SET character_set_client=utf8");
			mysql_query("SET character_set_results=utf8");
	  	}
	  	
	  	public function inserir($objeto){
	  		$sql = "INSERT INTO " . $objeto->tabela . " (";
	  		for($i = 0; $i<count($objeto->campos_valores);$i++):
	  			$sql .= key($objeto->campos_valores);
	  			if($i < count($objeto->campos_valores)-1):
	  				$sql .= ", ";
	  			else:
	  				$sql .= ") ";
	  			endif;
	  			next($objeto->campos_valores);
	  		endfor;
	  		reset($objeto->campos_valores);
	  		$sql .= "VALUES ( ";
	  		for($i = 0; $i<count($objeto->campos_valores);$i++):
	  			if(is_numeric($objeto->campos_valores[key($objeto->campos_valores)])):
	  				$sql .= $objeto->campos_valores[key($objeto->campos_valores)];
	  			else:
	  				$sql .= "'".$objeto->campos_valores[key($objeto->campos_valores)]."'";
	  			endif;
	  			if($i < count($objeto->campos_valores)-1):
	  				$sql .= ", ";
	  			else:
	  				$sql .= ") ";
	  			endif;
	  			next($objeto->campos_valores);
	  		endfor;
	  		return $this->executaSQL($sql);
	  	}
	  	
	  	public function atualizar($objeto){
	  		$sql = "UPDATE " . $objeto->tabela . " SET ";
	  		for($i = 0; $i<count($objeto->campos_valores);$i++):
	  			$sql .= key($objeto->campos_valores)."=";
	  			if(is_numeric($objeto->campos_valores[key($objeto->campos_valores)])):
	  				$sql .= $objeto->campos_valores[key($objeto->campos_valores)];
	  			else:
	  				$sql .= "'".$objeto->campos_valores[key($objeto->campos_valores)]."'";
	  			endif;
	  			if($i < count($objeto->campos_valores)-1):
	  				$sql .= ", ";
	  			else:
	  				$sql .= " ";
	  			endif;
	  			next($objeto->campos_valores);
	  		endfor;
 			$sql .= "WHERE ".$objeto->campopk."="; 
 			$sql .= is_numeric($objeto->valorpk) ? $objeto->valorpk : "'".$objeto->valorpk."'";
	  		return $this->executaSQL($sql);
	  	}
	  	
	  	public function deletar($objeto){
	  		$sql = "DELETE FROM " . $objeto->tabela;
	  		$sql .= " WHERE ".$objeto->campopk."="; 
 			$sql .= is_numeric($objeto->valorpk) ? $objeto->valorpk : "'".$objeto->valorpk."'";
	  		return $this->executaSQL($sql);
	  	}
	  	
	  	public function selecionaTudo($objeto){
	  		$sql = "SELECT * FROM " . $objeto->tabela;
	  		if($objeto->extras_select!=NULL):
	  			$sql .= " ".$objeto->extras_select;
	  		endif;
	  		return $this->executaSQL($sql);
	  	}
	  	
	  	public function selecionaCampos($objeto){
	  		$sql = "SELECT ";
	  		for($i = 0; $i<count($objeto->campos_valores);$i++):
	  			$sql .= key($objeto->campos_valores);
	  			if($i < count($objeto->campos_valores)-1):
	  				$sql .= ", ";
	  			else:
	  				$sql .= " ";
	  			endif;
	  			next($objeto->campos_valores);
	  		endfor;	
	  		$sql .= "FROM " . $objeto->tabela;
	  		if($objeto->extras_select!=NULL):
	  			$sql .= " ".$objeto->extras_select;
	  		endif;
	  		return $this->executaSQL($sql);
	  	}
	  	
	  	public function executaSQL($sql=NULL){
	  		if($sql!=NULL):
	  			$query = mysql_query($sql) or $this->trataerro(__FILE__, __FUNCTION__);
	  			$this->linhasafetadas = mysql_affected_rows($this->conexao);
	  			if(substr(trim(strtolower($sql)),0,6)=='select'):
	  				$this->dataset = $query;
	  				return $query;
	  			else:
	  				return $this->linhasafetadas;
	  			endif;
	  		else:
	  			$this->trataerro(__FILE__, __FUNCTION__,NULL,'Comando SQL nao informado na rotina', FALSE);
	  		endif;
	  	}
	  	
	  	public function retornaDados($tipo=NULL){
	  		switch ( strtolower($tipo) ):
				case "array":
					return mysql_fetch_array($this->dataset);
					break;
				case "assoc":
					return mysql_fetch_assoc($this->dataset);
					break;
				case "object":
					return mysql_fetch_object($this->dataset);
					break;
				default:
					return mysql_fetch_object($this->dataset);
					break;
			endswitch;
	  	}
	  	
	  	public function trataerro($arquivo=NULL, $rotina=NULL, $numerro=NULL, $msgerro=NULL,$geraexcept=FALSE){
	  		if($arquivo==NULL) $arquivo="nao informado";
	  		if($rotina==NULL) $rotina="nao informada";
	  		if($numerro==NULL) $numerro=mysql_errno($this->conexao);
	  		if($msgerro==NULL) $msgerro=mysql_error($this->conexao);
	  		$resultado ='Ocorreu um erro com os seguintes detalhes:<br />' .
						'<strong>Arquivo:</strong> '.$arquivo. '<br />' .
						'<strong>Rotina:</strong> '.$rotina. '<br />' .
						'<strong>Codigo:</strong> '.$numerro. '<br />' .
						'<strong>Mensagem:</strong> '.$msgerro; 
			if($geraexcept):
				die($resultado);
			else:
				echo($resultado);
			endif;
	  	}

        public function convertDatetoDateTime($date=NULL){
            if($date != NULL) {
                list($startDay, $startMonth, $startYear) = explode("/", $date);
                return date("Y-m-d H:i:s", mktime(0, 0, 0, $startMonth, $startDay, $startYear));
            }
        }

        public function convertDateTimetoDate($dateTime=NULL){
            if($dateTime != NULL) {
                $phpdate = strtotime($dateTime);
                return date('d/m/Y', $phpdate);
            }
        }
  	}
?>
