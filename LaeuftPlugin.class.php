<?php

class LaeuftPlugin extends StudIPPlugin implements SystemPlugin {

    public function __construct() {
        parent::__construct();
        PageLayout::addScript($this->getPluginURL() . '/laeuft.js');
        PageLayout::addStylesheet($this->getPluginURL() . '/laeuft.css');
        StudipTransformFormat::addStudipMarkup('LaeuftPlugin', '#läuft', NULL, 'LaeuftPlugin::init');
        StudipFormat::addStudipMarkup('LaeuftPlugin', "\[läuft:(\w){32}\]", null, 'LaeuftPlugin::markup');

        if (Request::submitted('laeuft')) {
            $parameter = array(Request::get('laeuft'), $GLOBALS['user']->id);
            if (DBManager::get()->execute('SELECT 1 FROM laeuft WHERE laeuft_id = ? AND user_id = ?', $parameter)) {
                DBManager::get()->execute('DELETE FROM laeuft WHERE laeuft_id = ? AND user_id = ?', $parameter);
            } else {
                DBManager::get()->execute('INSERT INTO laeuft VALUES (?,?)', $parameter);
            }
        }
    }

    public static function init($markup, $matches, $contents) {
        return "[läuft:" . md5(uniqid("läuft")).']';
    }

    public static function markup($markup, $matches, $contents) {
        $md5 = substr($matches[0], 7, 32);
        $parameter = array(md5($md5), $GLOBALS['user']->id);
        $count = DBManager::get()->fetchColumn('SELECT count(*) FROM laeuft WHERE laeuft_id = ? AND user_id != ?', $parameter);
        $me = DBManager::get()->execute('SELECT 1 FROM laeuft WHERE laeuft_id = ? AND user_id = ?', $parameter) ? 'laeuft_bei_dir' : '';
        
        return sprintf(dgettext('laeuft', '<a class="laeuft '.$me.'" href="'.URLHelper::getLink('', array('laeuft' => md5($md5))).'">#läuft</a> bei<span> dir und</span> %s Personen'), $count);
    }

}
