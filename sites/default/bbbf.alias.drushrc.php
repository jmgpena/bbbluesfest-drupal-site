<?php
$aliases['bbbf'] = array (
    'uri' => 'vps.jmgpena.net',
    'root' => '/home/jmgpena/bbbluesfest.com.pt',
    'remote-host' => 'vps.jmgpena.net',
    'remote-user' => 'jmgpena',
    'path-aliases' => array (
        '%files' => 'sites/default/files',
        ),
    );
$options['shell-aliases']['push-files'] = '!drush rsync @self:%files @bbbf:%files';
$options['shell-aliases']['pull-files'] = '!drush rsync @bbbf:%files @self:%files';
?>