<?php

namespace Codger\Php;

use Composer\Console\Application;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Input\ArrayInput;
use stdClass;

/**
 * Simple wrapper so recipies can interact with Composer.
 */
class Composer
{
    /** Path to `composer.json`, defaults to cwd. */
    private string $path;

    private stdClass $composer;

    private Application $app;

    private NullOutput $output;

    /**
     * @param string|null $path Optional path to `composer.json`. Defaults to
     *  current working directory.
     * @return void
     */
    public function __construct(string $path = null)
    {
        $path = $path ?? getcwd();
        $this->composer = json_decode(file_get_contents("$path/composer.json"));
        $this->path = $path;
        $this->output = new NullOutput;
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
        return (isset($this->composer->require) && isset($this->composer->require->$name))
            || (isset($this->composer->{'require-dev'}) && isset($this->composer->{'require-dev'}->$name));
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
            $options = ['command' => 'require', 'packages' => [$name]];
            if ($dev) {
                $options['--dev'] = 'dev';
            }
            $options['--working-dir'] = $this->path;
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
        $this->__construct($this->path);
    }
}

