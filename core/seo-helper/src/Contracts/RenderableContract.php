<?php

namespace Core\SeoHelper\Contracts;

interface RenderableContract
{
    /**
     * Render the tag.
     *
     * @return string
     * @author ARCANEDEV
     */
    public function render();

    /**
     * Render the tag.
     *
     * @return string
     * @author ARCANEDEV
     */
    public function __toString();
}
