<?php

declare(strict_types=1);

namespace Barth\SlackUpdater\Generator\Script;

use Barth\SlackUpdater\Console\Application;
use Barth\SlackUpdater\Generator\ScriptGeneratorInterface;
use Loilo\StoragePaths\StoragePaths;
use function Symfony\Component\String\u;

final class WakeupLinuxScriptGenerator implements ScriptGeneratorInterface
{
    public function generate(string $commandName, array $options): string
    {
        $rootDir = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'bin';
        $binary = 'slack-status-updater';

        $customOptions = '';
        if (array_key_exists('custom_message', $options)) {
            $customOptions = ' --message ' . $options['custom_message'];
        }

        if (array_key_exists('custom_emoji', $options)) {
            $customOptions = ' --emoji ' . $options['custom_emoji'];
        }

        $scriptContent = <<<TXT
[Desktop Entry]
Name=Slack status updater - Wakeup
GenericName=Slack status updater - Wakeup
Comment=Prevent slack workspace that you are active
Exec=php $binary $commandName $customOptions
Path=$rootDir
Terminal=false
Type=Application
X-GNOME-Autostart-enabled=true
TXT;

        $autostartPath = StoragePaths::for('autostart', ['suffix' => '']);
        $filename = u(Application::NAME)->snake()->ensureEnd('-' . $commandName .'.desktop')->toString();
        $filepath = $autostartPath->config() . DIRECTORY_SEPARATOR . $filename;

        file_put_contents(
            $filepath,
            $scriptContent
        );

        return $filepath;
    }

    public function support(string $commandName, array $options): bool
    {
        return $commandName === 'wakeup' && PHP_OS_FAMILY === 'Linux';
    }
}
