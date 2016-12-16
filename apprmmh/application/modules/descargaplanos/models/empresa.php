<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
    }
    
   	function obtenerDatosEmpresa($nro_orden){
   		$empresa = array();
   		$sql = "SELECT nro_orden, idnit, idproraz, idnomcom, idsigla, iddirecc, idtelno, idfaxno, idaano, idpagweb, idcorreo, fk_depto, fk_mpio
                FROM rmmh_admin_empresas EMP
                WHERE nro_orden = $nro_orden";
   		$query = $this->db->query($sql);
   		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$empresa["nro_orden"] = $row->nro_orden;
				$empresa["idnit"] = $row->idnit;
				$empresa["idproraz"] = $row->idproraz;
				$empresa["idnomcom"] = $row->idnomcom;
				$empresa["idsigla"] = $row->idsigla;
				$empresa["iddirecc"] = $row->iddirecc;
				$empresa["idtelno"] = $row->idtelno;
				$empresa["idfaxno"] = $row->idfaxno;
				$empresa["idaano"] = $row->idaano;
				$empresa["idpagweb"] = $row->idpagweb;
				$empresa["idcorreo"] = $row->idcorreo;
				$empresa["fk_depto"] = $row->fk_depto;
				$empresa["fk_mpio"] = $row->fk_mpio;
			}
		}
		$this->db->close();
		return $empresa;
   	}

   	function actualizarEmpresa($hddNroOrden, $idnit, $idproraz, $idnomcom, $idsigla, $iddirecc, $idtelno, $idfaxno, $idaano, $idpagweb, $idcorreo, $cmbDeptoEmp, $cmbMpioEmp){
   		$data = array('idnit' => $idnit,
                      'idproraz' => $idproraz,
                      'idnomcom' => $idnomcom,
   		              'idsigla' => $idsigla,
   		              'iddirecc' => $iddirecc,
   		              'idtelno' => $idtelno,
   		              'idfaxno' => $idfaxno,
   		              'idaano' => $idaano,
   		              'idpagweb' => $idpagweb,
   		              'idcorreo' => $idcorreo,
   		              'fk_depto' => $cmbDeptoEmp,
   		              'fk_mpio' => $cmbMpioEmp  
                );
		$this->db->where('nro_orden', $hddNroOrden);
		$this->db->update('rmmh_admin_empresas', $data); 	
   	}
   	
   	function existeEmpresa($nro_orden){
   		$empresa = array();
   		$sql = "SELECT * FROM rmmh_admin_empresas WHERE nro_orden = $nro_orden";
   		$query = $this->db->query($sql);
   		if ($query->num_rows()>0){
   			return true;
   		}
   		else{
   			return false;
   		}
   	}
   	
   	function obtenerNITEmpresa($nro_orden){
   		$nit = 0;
   		$sql = "SELECT idnit
                FROM rmmh_admin_empresas
                WHERE nro_orden = $nro_orden";
   		$query = $this->db->query($sql);
   		if ($query->num_rows()>0){
   			foreach($query->result() as $row){
				$nit = $row->idnit;
			}
   		}	
   	}
   	
   	
}//EOC