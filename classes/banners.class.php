<?php
require_once("base.class.php");
class banners extends base{
    public function __construct($campos=array()) {
    	parent::__construct();
    	$this->tabela = "TB_BANNER";
        $this->pasta_raiz = "../../banner/";
        $this->pasta_raiz_modal = "banner/";
    	if(sizeof($campos)<=0):
    		$this->campos_valores = array(
    			"descricao" => NULL,
    			"imagem" => NULL,
				"dt_inicio" => NULL,
				"dt_fim" => NULL
    		);
    	else:
    		$this->campos_valores = $campos;
    	endif;
    	$this->campopk = "id";
    }  
}
?>