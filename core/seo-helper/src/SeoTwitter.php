<?php

namespace Core\SeoHelper;

use Core\SeoHelper\Contracts\Entities\TwitterCardContract;
use Core\SeoHelper\Contracts\SeoTwitterContract;

class SeoTwitter implements SeoTwitterContract
{

    /**
     * The Twitter Card instance.
     *
     * @var \Core\SeoHelper\Contracts\Entities\TwitterCardContract
     */
    protected $card;

    /**
     * Make SeoTwitter instance.
     * @author ARCANEDEV
     */
    public function __construct()
    {
        $this->setCard(
            new Entities\Twitter\Card()
        );
    }

    /**
     * Set the Twitter Card instance.
     *
     * @param  \Core\SeoHelper\Contracts\Entities\TwitterCardContract $card
     *
     * @return \Core\SeoHelper\SeoTwitter
     * @author ARCANEDEV
     */
    public function setCard(TwitterCardContract $card)
    {
        $this->card = $card;

        return $this;
    }

    /**
     * Set the card type.
     *
     * @param  string $type
     *
     * @return \Core\SeoHelper\SeoTwitter
     * @author ARCANEDEV
     */
    public function setType($type)
    {
        $this->card->setType($type);

        return $this;
    }

    /**
     * Set the card site.
     *
     * @param  string $site
     *
     * @return \Core\SeoHelper\SeoTwitter
     * @author ARCANEDEV
     */
    public function setSite($site)
    {
        $this->card->setSite($site);

        return $this;
    }

    /**
     * Set the card title.
     *
     * @param  string $title
     *
     * @return \Core\SeoHelper\SeoTwitter
     * @author ARCANEDEV
     */
    public function setTitle($title)
    {
        $this->card->setTitle($title);

        return $this;
    }

    /**
     * Set the card description.
     *
     * @param  string $description
     *
     * @return \Core\SeoHelper\SeoTwitter
     * @author ARCANEDEV
     */
    public function setDescription($description)
    {
        $this->card->setDescription($description);

        return $this;
    }

    /**
     * Add image to the card.
     *
     * @param  string $url
     *
     * @return \Core\SeoHelper\SeoTwitter
     * @author ARCANEDEV
     */
    public function addImage($url)
    {
        $this->card->addImage($url);

        return $this;
    }

    /**
     * Add many meta to the card.
     *
     * @param  array $meta
     *
     * @return \Core\SeoHelper\SeoTwitter
     * @author ARCANEDEV
     */
    public function addMetas(array $meta)
    {
        $this->card->addMetas($meta);

        return $this;
    }

    /**
     * Add a meta to the Twitter Card.
     *
     * @param  string $name
     * @param  string $content
     *
     * @return \Core\SeoHelper\SeoTwitter
     * @author ARCANEDEV
     */
    public function addMeta($name, $content)
    {
        $this->card->addMeta($name, $content);

        return $this;
    }

    /**
     * Render the tag.
     *
     * @return string
     * @author ARCANEDEV
     */
    public function render()
    {
        return $this->card->render();
    }

    /**
     * Render the tag.
     *
     * @return string
     * @author ARCANEDEV
     */
    public function __toString()
    {
        return $this->render();
    }
}
