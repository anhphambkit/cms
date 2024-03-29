<?php

namespace Core\SeoHelper\Contracts\Entities;

use Core\SeoHelper\Contracts\RenderableContract;

interface MiscTagsContract extends RenderableContract
{
    /**
     * Get the current URL.
     *
     * @return string
     * @author ARCANEDEV
     */
    public function getUrl();

    /**
     * Set the current URL.
     *
     * @param  string $url
     *
     * @return self
     * @author ARCANEDEV
     */
    public function setUrl($url);

    /**
     * Make MiscTags instance.
     *
     * @param  array $defaults
     *
     * @return self
     * @author ARCANEDEV
     */
    public static function make(array $defaults = []);

    /**
     * Add a meta tag.
     *
     * @param  string $name
     * @param  string $content
     *
     * @return self
     * @author ARCANEDEV
     */
    public function add($name, $content);

    /**
     * Add many meta tags.
     *
     * @param  array $meta
     *
     * @return self
     * @author ARCANEDEV
     */
    public function addMany(array $meta);

    /**
     * Remove a meta from the meta collection by key.
     *
     * @param  array|string $names
     *
     * @return self
     * @author ARCANEDEV
     */
    public function remove($names);

    /**
     * Reset the meta collection.
     *
     * @return self
     * @author ARCANEDEV
     */
    public function reset();
}
