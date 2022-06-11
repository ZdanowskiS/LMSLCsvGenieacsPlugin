<?php

class LMSLCsvGenieacsPlugin extends LMSPlugin {
	const plugin_directory_name = 'LMSLCsvGenieacsPlugin';
	const PLUGIN_DBVERSION = '2022060600';
	const PLUGIN_DB_VERSION = '2022060600';
	const PLUGIN_NAME = 'LMSLCsvGenieacs';
	const PLUGIN_DESCRIPTION = 'LMS Plugin for LightCsv-Genieacs';
	const PLUGIN_AUTHOR = 'Sylwester Zdanowski';

	private static $lcsv = null;

	public static function getLCsvGenieacsInstance() {
		if (empty(self::$lcsv))
			self::$lcsv = new LCsvGenieacs();
		return self::$lcsv;
	}

	public function registerHandlers() {
		$this->handlers = array(
			'smarty_initialized' => array(
				'class' => 'LCsvGenieacsInitHandler',
				'method' => 'smartyInit'
			),
			'nodeadd_before_display' => array(
				'class' => 'LCsvGenieacsNodeHandler',
				'method' => 'nodeAddBeforeSubmit'
			),
			'nodeadd_after_submit' => array(
				'class' => 'LCsvGenieacsNodeHandler',
				'method' => 'nodeAddAfterSubmit'
			),
			'nodedel_before_submit' => array(
				'class' => 'LCsvGenieacsNodeHandler',
				'method' => 'nodeDelBeforeSubmit'
			),
		);
    }
}
