<?php

namespace Core\SeoHelper\Entities;

use Core\SeoHelper\Bases\MetaCollection as BaseMetaCollection;
use Core\SeoHelper\Helpers\Meta;

class MetaCollection extends BaseMetaCollection
{
    /**
     * Ignored tags, they have dedicated class.
     *
     * @var array
     */
    protected $ignored = [
        'description',
        'keywords',
    ];

    /**
     * Add a meta to collection.
     *
     * @param  string $name
     * @param  string $content
     *
     * @return \Core\SeoHelper\Entities\MetaCollection
     * @author ARCANEDEV
     */
    public function add($item)
    {
        $meta = Meta::make($item['name'], $item['content']);

        if ($meta->isValid() && !$this->isIgnored($item['name'])) {
            $this->put($meta->key(), $meta);
        }

        return $this;
    }
}
