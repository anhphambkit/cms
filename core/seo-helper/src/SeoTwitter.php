<?php

namespace Core\SeoHelper;

use Core\SeoHelper\Contracts\Entities\TwitterCardContract;
use Core\SeoHelper\Contracts\SeoTwitterContract;

class SeoTwitter implements SeoTwitterContract
{

    /**
     * The Twitter Card instance.
     *
     * @var \Botble\SeoHelper\Contracts\Entities\TwitterCardContract
     */
    protected $card;

    /**
     * Make SeoTwitter instance.
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
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
     * @param  \Botble\SeoHelper\Contracts\Entities\TwitterCardContract $card
     *
     * @return \Botble\SeoHelper\SeoTwitter
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
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
     * @return \Botble\SeoHelper\SeoTwitter
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
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
     * @return \Botble\SeoHelper\SeoTwitter
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
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
     * @return \Botble\SeoHelper\SeoTwitter
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
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
     * @return \Botble\SeoHelper\SeoTwitter
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
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
     * @return \Botble\SeoHelper\SeoTwitter
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
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
     * @return \Botble\SeoHelper\SeoTwitter
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
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
     * @return \Botble\SeoHelper\SeoTwitter
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
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
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    public function render()
    {
        return $this->card->render();
    }

    /**
     * Render the tag.
     *
     * @return string
     * @author ARCANEDEV <arcanedev.maroc@gmail.com>
     */
    public function __toString()
    {
        return $this->render();
    }
}
