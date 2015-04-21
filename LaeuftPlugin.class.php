<?php

class LaeuftPlugin extends StudIPPlugin implements SystemPlugin {

    public function __construct() {
        parent::__construct();
        StudipTransformFormat::addStudipMarkup('LaeuftPlugin', '\[l�uft\]', NULL, 'LaeuftPlugin::init');
        StudipFormat::addStudipMarkup('LaeuftPlugin', "\[l�uft:(\w){32}\]", null, 'LaeuftPlugin::markup');

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
        return "[l�uft:" . md5(uniqid("l�uft")) . "]";
    }

    public static function markup($markup, $matches, $contents) {
        $md5 = substr($matches[0], 7, 32);
        
        $count = DBManager::get()->fetchColumn('SELECT count(*) FROM laeuft WHERE laeuft_id = ?', array(md5($md5)));
        
        return sprintf(dgettext('laeuft', 'L�uft bei %s Personen'), $count) . ' ' . Studip\LinkButton::create('L�uft!', '?laeuft=' . md5($md5));
    }

}
