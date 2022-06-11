<?php

class LCsvGenieacs {

	private $DB;
	private $AUTH;
	protected $LMS;

	public function __construct() {
		global $AUTH, $LMS;

		$this->db = LMSDB::getInstance();
		$this->AUTH = $AUTH;
		$this->LMS= $LMS;

    }

    public function existsCPE($id)
    {
        $dir=ConfigHelper::getConfig('lcsv.cpedir', '', true);

        $files=scandir(ConfigHelper::getConfig('lcsv.cpedir', '', true));
        
        foreach($files as $file)
        {
            if(strpos(strtoupper($file),$id)===strpos('a','a'))
                return $file;
        }

        return FALSE;
    }

    public function addCPE($id, $data)
    {
        $dir=ConfigHelper::getConfig('lcsv.cpedir', '', true);

        file_put_contents($dir.$id.".csv", $data);

        return;
    }

    public function deleteCPE($id)
    {
        if($file=$this->existsCPE($id))
            unlink(ConfigHelper::getConfig('lcsv.cpedir', '', true).$file);

        return;
    }


    public function existsTemplate($name)
    {
        $dir=ConfigHelper::getConfig('lcsv.templatedir', '', true);
        if(file_exists($dir.$name.'.csv'))
            return TRUE;
        else
            return FALSE;
    }

    public function getTemplateList()
    {
        $files = scandir(ConfigHelper::getConfig('lcsv.templatedir', '', true));

        foreach($files as $file)
        {
            if($file!='.' && $file!='..')
            {
                $id=str_replace('.csv','',$file);

                $templates[]=array('id' =>$id,
                    'file' => $file);
            }
        }

        return $templates;
    }

    public function getTemplateByLine($name)
    {

        $handle=fopen(ConfigHelper::getConfig('lcsv.templatedir', '', true).$name.'.csv','r');

        while(($data = fgetcsv($handle,1000,";")) !== FALSE)
        {
            $result[]=$data;
        }
        fclose($handle);

        return $result;
    }

	public function generate_password($length = 11){
  		$chars =  'abcdefghijkmnopqrstuvwxyz'.
            	'123456789';

  		$str = '';
  		$max = strlen($chars) - 1;

  		for ($i=0; $i < $length; $i++)
    		$str .= $chars[mt_rand(0, $max)];

  		return $str;
	}
}

?>
