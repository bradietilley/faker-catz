<?php

namespace BradieTilley\Catz;

use BradieTilley\Catz\Exceptions\CatzImageException;
use Illuminate\Support\Collection;

class Catz
{
    /**
     * Stores the current singleton instance
     */
    protected static ?self $instance = null;

    /**
     * The complete set of cats
     *
     * @var array<int, string>
     */
    protected ?array $all = null;

    /**
     * The current pool of cats
     *
     * @var array<int, string>
     */
    protected ?array $pool = null;

    /**
     * The current cat pic
     */
    protected ?string $current = null;

    /**
     * The seed to use for shuffling profile pics within each pool
     */
    protected ?int $seed = null;

    /**
     * Resolve the current instance
     */
    public static function instance(): self
    {
        return static::$instance ??= new self();
    }

    /**
     * Set the shuffle seed and update the pool
     */
    public function seed(int $seed = null): static
    {
        $this->seed = $seed;

        return $this->load();
    }

    /**
     * Get the next image's path
     */
    public function path(): string
    {
        return $this->refeed()->next()->getCurrentImagePath();
    }

    /**
     * Get the next image's contents
     */
    public function contents(): string
    {
        return $this->refeed()->next()->getCurrentImageContents();
    }

    /**
     * Get the current iterated image path
     */
    public function getCurrentImagePath(): string
    {
        if ($this->current === null) {
            $this->next();
        }

        return $this->current ?? throw CatzImageException::make('Unable to load catz image path');
    }

    /**
     * Get the current iterated image contents
     */
    public function getCurrentImageContents(): string
    {
        return file_get_contents($this->getCurrentImagePath()) ?: throw CatzImageException::make('Unable to load catz image content');
    }

    /**
     * Cycle to the next cat
     */
    public function next(): static
    {
        /** @phpstan-ignore-next-line */
        $this->current = array_pop($this->pool);

        return $this;
    }

    /**
     * Load in all cat pics
     */
    public function load(): static
    {
        if ($this->all === null) {
            $path = self::absolutePath('');
            $pics = scandir($path) ?: throw CatzImageException::make('Unable to read catz images');

            $pics = Collection::make($pics)
                ->filter(fn (string $file) => $file !== '.' && $file !== '..')
                ->map(fn (string $file) => $path.DIRECTORY_SEPARATOR.$file)
                ->values()
                ->all();

            $this->all = $pics;
        }

        $this->pool = Collection::make($this->all)
            ->shuffle($this->seed)
            ->values()
            ->all();

        return $this;
    }

    /**
     * Load in all cat pics if we've run out.
     */
    public function refeed(): static
    {
        if (empty($this->pool)) {
            $this->load();
        }

        return $this;
    }

    /**
     * @return array<int, string>
     */
    public function all(): array
    {
        if ($this->all === null) {
            $this->load();
        }

        return $this->all ?? throw CatzImageException::make('Unable to load catz pics');
    }

    /**
     * @return array<int, string>
     */
    public function pool(): array
    {
        if ($this->all === null) {
            $this->load();
        }

        return $this->pool ?? throw CatzImageException::make('Unable to load catz pool');
    }

    public static function absolutePath(string $name): string
    {
        return rtrim(dirname(__DIR__).DIRECTORY_SEPARATOR.'pics'.DIRECTORY_SEPARATOR.$name, DIRECTORY_SEPARATOR);
    }
}
