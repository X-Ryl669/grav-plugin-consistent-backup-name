<?php
namespace Grav\Plugin;

use \Grav\Common\Plugin;

class ConsistentBackupNamePlugin extends Plugin
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    /**
     * Initialize configuration
     */
    public function onPluginsInitialized()
    {
        $config = $this->grav['config']->get('plugins.consistent-backup-name');

        // Should run and store page
        $this->enable([
            'onBackupFinished' => ['onBackupFinished', 0]
        ]);
    }

    /**
     * Save the page to the cache
     */
    public function onBackupFinished($event)
    {
        $dest = $event['backup'];
        $link = dirname($dest) . DIRECTORY_SEPARATOR . 'LATEST.zip';
	@unlink($link);
        symlink($dest, $link);
    }
}
