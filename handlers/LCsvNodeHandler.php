<?php

class LCsvGenieacsNodeHandler {

    public function nodeAddBeforeSubmit(array $hook_data) {
		global $SMARTY;

		$LCsvGenieacs = LMSLCsvGenieacsPlugin::getLCsvGenieacsInstance();

        $SMARTY->assign('LCsvmodels', $LCsvGenieacs->getTemplateList());
        return $hook_data;
    }

	public function nodeAddAfterSubmit(array $hook_data) {

		$LCsvGenieacs = LMSLCsvGenieacsPlugin::getLCsvGenieacsInstance();

        $node=$hook_data['nodeadd'];

        $lines=$LCsvGenieacs->getTemplateByLine($node['lcsvmodel']);

        foreach($lines as $line)
        {
            switch($line[4]){
                case '%confpass':
                    $line[4]=ConfigHelper::getConfig('lcsv.confpass', '', true);
                break;
                case '%keypass':
                    $line[4]=$LCsvGenieacs->generate_password();
                break;
                case '%name':
                    $line[4]=$node['name'];
                break;
                case '%passwd':
                    $line[4]=$node['passwd'];
                break;
                case '%ssid':
                    $line[4]=ConfigHelper::getConfig('lcsv.ssid', 'ssid', true).$node['ownerid'];
                break;
                default:
            }
			$configuration.=implode(';',$line)."\n";
        }

        $LCsvGenieacs->addCPE($node['name'], $configuration);

		return $hook_data;
	}

	public function nodeEditAfterSubmit(array $hook_data) {

		$LCsvGenieacs = LMSLCsvGenieacsPlugin::getLCsvGenieacsInstance();

		$node=$hook_data['nodeedit'];

		return $hook_data;
	}

	public function nodeDelBeforeSubmit(array $hook_data) {
        global $DB;

		$LCsvGenieacs = LMSLCsvGenieacsPlugin::getLCsvGenieacsInstance();

        $name=$DB->GetOne('SELECT name FROM nodes WHERE id=?',
                            array($hook_data['id']));

        $LCsvGenieacs->deleteCPE($name);
		return $hook_data;
	}
}
?>
