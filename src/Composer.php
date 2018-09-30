<?php

namespace Codger\Php;

use Composer\Console\Application;
use Composer\Factory;
use Symfony\Component\Console\Input\ArrayInput;

class Composer
{
    /** @var stdClass */
    private $composer;
    /** @var Composer\Console\Application */
    private $app;
    /** @var Symfony\Component\Console\Output\ConsoleOutput */
    private $output;

    /**
     * @param string|null $path Optional path to `composer.json`. Defaults to
     *  current working directory.
     * @return void
     */
    public function __construct(string $path = null)
    {
        $path = $path ?? getcwd();
        $this->composer = json_decode(file_get_contents("$path/composer.json"));
        $factory = new Factory;
        $this->output = $factory->createOutput();
        $this->app = new Application;
    }

    /**
     * Check if project has a dependency (`vendor/package`).
     *
     * @param string $name
     * @return bool
     */
    public function hasDependency(string $name) : bool
    {
        return (isset($this->composer->require) && array_key_exists($name, $this->composer->require))
            || (isset($this->composer->{'require-dev'}) && array_key_exists($name, $this->composer->{'require-dev'}));
    }

    /**
     * Adds a dependency (`vendor/package`) if it not yet exists.
     *
     * @param string $name
     * @param bool $dev Whether to install as dev-dependency. Defaults to
     *  `false`.
     * @return void
     */
    public function addDependency(string $name, bool $dev = false) : void
    {
        if (!$this->hasDependency($name)) {
            $options = ['command' => 'require'];
            if ($dev) {
                $options[] = '--dev';
            }
            $options['packages'] = [$name];
            $input = new ArrayInput($options);
            $input->setInteractive(false);
            $this->app->doRun($input, $this->output);
        }
    }

    /**
     * Adds a VCS repository.
     *
     * @param string $name
     * @param string $url
     * @return void
     */
    public function addVcsRepository(string $name, string $url) : void
    {
        $input = new ArrayInput(['command' => 'config', 'setting-key' => "repositories.$name", 'setting-value' => ['vcs', $url]]);
        $input->setInteractive(false);
        $this->app->doRun($input, $this->output);
    }
}

