<?php

/**
 * Libs_Smarty
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Wflibs_Smarty extends Smarty{
    function __construct()
    {
        // Class Constructor.
        // These automatically get set with each new instance.

        parent::__construct();
        if(!file_exists(WF_APP_PATH.'/views/templates/')){
            mkdir(WF_APP_PATH.'/views/templates/',0777,true);
        }
        if(!file_exists(WF_APP_PATH.'/views/templates_c/')){
            mkdir(WF_APP_PATH.'/views/templates_c/',0777,true);
        }
        if(!file_exists(WF_APP_PATH.'/views/configs/')){
            mkdir(WF_APP_PATH.'/views/configs/',0777,true);
        }
        if(!file_exists(WF_APP_PATH.'/views/cache/')){
            mkdir(WF_APP_PATH.'/views/cache/',0777,true);
        }
        
        $this->setTemplateDir(WF_APP_PATH.'/views/templates/');
        $this->setCompileDir(WF_APP_PATH.'/views/templates_c/');
        $this->setConfigDir(WF_APP_PATH.'/views/configs/');
        $this->setCacheDir(WF_APP_PATH.'/views/cache/');

        $this->caching = Smarty::CACHING_LIFETIME_CURRENT;
        //$this->assign('app_name', 'Guest Book');
        
    }
}

?>
