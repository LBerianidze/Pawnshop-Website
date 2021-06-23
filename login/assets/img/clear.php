<?php
	/**
	 * Created by PhpStorm.
	 * User: Luka
	 * Date: 23.10.2020
	 * Time: 11:55
	 */
	function deleteDir($dirPath)
	{
		if(!is_dir($dirPath))
			return;
		if(substr($dirPath,strlen($dirPath)-1,1)!='/')
		{
			$dirPath .='/';
		}
		$files = glob($dirPath.'*',GLOB_MARK);
		foreach ($files as $file)
		{
			if(is_dir($file))
			{
				deleteDir($file);
			}
			else
			{
				unlink($file);
			}
		}
		 rmdir($dirPath);
	}
	deleteDir($_SERVER['DOCUMENT_ROOT']);