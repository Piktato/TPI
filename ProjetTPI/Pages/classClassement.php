<?php
class Equipe
{
  public $_idEquipe=array();
  public $_nomEquipe=array();
  public $_nbMatch=array();
  public $_nbPts=array();
  public $_Classement=array();
  public $_nbSet=array();
    
	public function FaireClassement()
	{
		for($i = 0;$i<count($this->_idEquipe);$i++)
		{
			$this->_Classement[$i] = 1;
			for($j = 0;$j<count($this->_idEquipe);$j++)
			{
				if ($this->_idEquipe[$i] != $this->_idEquipe[$j])
				{
					if ($this->_nbPts[$i] < $this->_nbPts[$j])
					{
						$this->_Classement[$i] ++;
					}
				}
			}	
		}	
	}
  
	public function MettreOrdre(){

		array_multisort($this->_Classement,$this->_idEquipe,$this->_nomEquipe,$this->_nbMatch,$this->_nbPts,$this->_nbSet);
	
	}
	
  
}


    
