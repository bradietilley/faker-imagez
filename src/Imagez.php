<?php

namespace BradieTilley\FakerImagez;

use BradieTilley\FakerImagez\Exceptions\ImagezException;
use Illuminate\Support\Collection;
use SplFileInfo;

abstract class Imagez
{
    public const ERROR_UNABLE_TO_FIND_IMAGE_NUMBER = 'Unable to find image #%s';
    public const ERROR_UNABLE_TO_LOAD_CURRENT_PATH = 'Unable to load current image path';
    public const ERROR_UNABLE_TO_READ_IMAGE_CONTENTS = 'Unable to load image content at path %s';
    public const ERROR_UNABLE_TO_READ_IMAGE_DIRECTORY = 'Unable to read the source image directory at path %s';

    /**
     * Stores the current singleton instance
     */
    protected static ?self $instance = null;

    /**
     * The complete set of images
     *
     * @var array<int, string>
     */
    protected ?array $all = null;

    /**
     * The current pool of images
     *
     * @var array<int, string>
     */
    protected ?array $pool = null;

    /**
     * The current image pic
     */
    protected ?string $current = null;

    /**
     * Resolve the current instance
     */
    public static function instance(): static
    {
        /** @phpstan-ignore-next-line */
        return static::$instance ??= new static();
    }

    /**
     * Get the number of images
     */
    public function count(): int
    {
        $this->all ??= $this->load();

        return count($this->all);
    }

    /**
     * Get a image by fixed number.
     *
     * Example: 1 matches image_0001.jpeg
     * Example: 120 matches image_0120.jpeg
     */
    public function get(int $number): string
    {
        $this->all ??= $this->load();

        return $this->all[$number - 1] ?? $this->throw(sprintf(static::ERROR_UNABLE_TO_FIND_IMAGE_NUMBER, $number));
    }

    /**
     * Get the next image's path
     */
    public function path(): string
    {
        return $this->loanWhenEmpty()->iterate()->getCurrentImagePath();
    }

    /**
     * Get the next image's contents
     */
    public function contents(): string
    {
        return $this->loanWhenEmpty()->iterate()->getCurrentImageContents();
    }

    /**
     * Get the next image as an instance of SplFileInfo
     */
    public function fileinfo(): SplFileInfo
    {
        return $this->loanWhenEmpty()->iterate()->getCurrentImageFileinfo();
    }

    /**
     * Get the current iterated image path
     */
    public function getCurrentImagePath(): string
    {
        if ($this->current === null) {
            $this->iterate();
        }

        return $this->current ?? $this->throw(self::ERROR_UNABLE_TO_LOAD_CURRENT_PATH);
    }

    /**
     * Get the current iterated image contents
     */
    public function getCurrentImageContents(): string
    {
        return file_get_contents($path = $this->getCurrentImagePath()) ?: $this->throw(sprintf(self::ERROR_UNABLE_TO_READ_IMAGE_CONTENTS, $path));
    }

    /**
     * Get the current iterated image's fileinfo
     */
    public function getCurrentImageFileinfo(): SplFileInfo
    {
        return new SplFileInfo($this->getCurrentImagePath());
    }

    /**
     * Cycle to the next image
     */
    public function iterate(): static
    {
        /** @phpstan-ignore-next-line */
        $this->current = array_pop($this->pool);

        return $this;
    }

    /**
     * Load in all image pics
     *
     * @return array<int, string> All image pics
     */
    public function load(): array
    {
        if ($this->all === null) {
            $path = static::absolutePath('');
            $pics = scandir($path) ?: $this->throw(sprintf(self::ERROR_UNABLE_TO_READ_IMAGE_DIRECTORY, $path));

            $pics = Collection::make($pics)
                ->filter(fn (string $file) => $file !== '.' && $file !== '..')
                ->map(fn (string $file) => static::absolutePath($file))
                ->values()
                ->all();

            $this->all = $pics;
        }

        $this->pool = Collection::make($this->all)
            ->shuffle()
            ->values()
            ->all();

        return $this->all;
    }

    /**
     * Load in all image pics if we've run out.
     */
    public function loanWhenEmpty(): static
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
        $this->all ??= $this->load();

        return $this->all;
    }

    /**
     * @return array<int, string>
     */
    public function pool(): array
    {
        $this->all ??= $this->load();

        /** @phpstan-ignore-next-line */
        return $this->pool;
    }

    abstract public static function basePath(): string;

    public static function absolutePath(string $name): string
    {
        $base = rtrim(static::basePath(), DIRECTORY_SEPARATOR);
        $name = trim($name, DIRECTORY_SEPARATOR);

        return $base.DIRECTORY_SEPARATOR.$name;
    }

    public function throw(string $message): never
    {
        throw ImagezException::make(sprintf('%s: %s', $this::class, $message));
    }
}
