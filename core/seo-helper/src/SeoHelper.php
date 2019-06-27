<?php

namespace Core\SeoHelper;

use Core\SeoHelper\Contracts\SeoHelperContract;
use Core\SeoHelper\Contracts\SeoMetaContract;
use Core\SeoHelper\Contracts\SeoOpenGraphContract;
use Core\SeoHelper\Contracts\SeoTwitterContract;
use Exception;

class SeoHelper implements SeoHelperContract
{
    /**
     * The SeoMeta instance.
     *
     * @var \Core\SeoHelper\Contracts\SeoMetaContract
     */
    private $seoMeta;

    /**
     * The SeoOpenGraph instance.
     *
     * @var \Core\SeoHelper\Contracts\SeoOpenGraphContract
     */
    private $seoOpenGraph;

    /**
     * The SeoTwitter instance.
     *
     * @var \Core\SeoHelper\Contracts\SeoTwitterContract
     */
    private $seoTwitter;

    /**
     * Make SeoHelper instance.
     *
     * @param  \Core\SeoHelper\Contracts\SeoMetaContract $seoMeta
     * @param  \Core\SeoHelper\Contracts\SeoOpenGraphContract $seoOpenGraph
     * @param  \Core\SeoHelper\Contracts\SeoTwitterContract $seoTwitter
     * @author ARCANEDEV
     */
    public function __construct(
        SeoMetaContract $seoMeta,
        SeoOpenGraphContract $seoOpenGraph,
        SeoTwitterContract $seoTwitter
    ) {
        $this->setSeoMeta($seoMeta);
        $this->setSeoOpenGraph($seoOpenGraph);
        $this->setSeoTwitter($seoTwitter);
    }

    /**
     * Get SeoMeta instance.
     *
     * @return \Core\SeoHelper\Contracts\SeoMetaContract
     * @author ARCANEDEV
     */
    public function meta()
    {
        return $this->seoMeta;
    }

    /**
     * Set SeoMeta instance.
     *
     * @param  \Core\SeoHelper\Contracts\SeoMetaContract $seoMeta
     *
     * @return \Core\SeoHelper\SeoHelper
     * @author ARCANEDEV
     */
    public function setSeoMeta(SeoMetaContract $seoMeta)
    {
        $this->seoMeta = $seoMeta;

        return $this;
    }

    /**
     * Get SeoOpenGraph instance.
     *
     * @return \Core\SeoHelper\Contracts\SeoOpenGraphContract
     * @author ARCANEDEV
     */
    public function openGraph()
    {
        return $this->seoOpenGraph;
    }

    /**
     * Get SeoOpenGraph instance.
     *
     * @param  \Core\SeoHelper\Contracts\SeoOpenGraphContract $seoOpenGraph
     *
     * @return \Core\SeoHelper\SeoHelper
     * @author ARCANEDEV
     */
    public function setSeoOpenGraph(SeoOpenGraphContract $seoOpenGraph)
    {
        $this->seoOpenGraph = $seoOpenGraph;

        return $this;
    }

    /**
     * Get SeoTwitter instance.
     *
     * @return \Core\SeoHelper\Contracts\SeoTwitterContract
     * @author ARCANEDEV
     */
    public function twitter()
    {
        return $this->seoTwitter;
    }

    /**
     * Set SeoTwitter instance.
     *
     * @param  \Core\SeoHelper\Contracts\SeoTwitterContract $seoTwitter
     *
     * @return \Core\SeoHelper\SeoHelper
     * @author ARCANEDEV
     */
    public function setSeoTwitter(SeoTwitterContract $seoTwitter)
    {
        $this->seoTwitter = $seoTwitter;

        return $this;
    }

    /**
     * Set title.
     *
     * @param  string $title
     * @param  string|null $siteName
     * @param  string|null $separator
     *
     * @return \Core\SeoHelper\SeoHelper
     * @author ARCANEDEV
     */
    public function setTitle($title, $siteName = null, $separator = null)
    {
        $this->meta()->setTitle($title, $siteName, $separator);
        $this->openGraph()->setTitle($title);
        $this->openGraph()->setSiteName($siteName);
        $this->twitter()->setTitle($title);

        return $this;
    }

    /**
     * Set description.
     *
     * @param  string $description
     *
     * @return \Core\SeoHelper\Contracts\SeoHelperContract
     * @author ARCANEDEV
     */
    public function setDescription($description)
    {
        $this->meta()->setDescription($description);
        $this->openGraph()->setDescription($description);
        $this->twitter()->setDescription($description);

        return $this;
    }

    /**
     * Set keywords.
     *
     * @param  array|string $keywords
     *
     * @return \Core\SeoHelper\SeoHelper
     * @author ARCANEDEV
     */
    public function setKeywords($keywords)
    {
        $this->meta()->setKeywords($keywords);

        return $this;
    }

    /**
     * Render all seo tags.
     *
     * @return string
     * @author ARCANEDEV
     */
    public function render()
    {
        return implode(PHP_EOL, array_filter([
            $this->meta()->render(),
            $this->openGraph()->render(),
            $this->twitter()->render(),
        ]));
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

    /**
     * @param $screen
     * @param \Illuminate\Http\Request $request
     * @param $object
     * @return bool
     * @author TrinhLe
     */
    public function saveMetaData($screen, $request, $object)
    {
        if (in_array($screen, config('packages.seo-helper.general.supported'))) {
            try {
                if (empty($request->input('seo_meta'))) {
                    delete_meta_data($object->id, 'seo_meta', $screen);
                    return false;
                }
                save_meta_data($object->id, 'seo_meta', $request->input('seo_meta'), $screen);
                return true;
            } catch (Exception $ex) {
                return false;
            }
        }
        return false;
    }

    /**
     * @param $screen
     * @param $object
     * @return bool
     * @author TrinhLe
     */
    public function deleteMetaData($screen, $object)
    {
        try {
            if (in_array($screen, config('packages.seo-helper.general.supported'))) {
                delete_meta_data($object->id, 'seo_meta', $screen);
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @param string | array $screen
     * @return SeoHelper
     * @author TrinhLe
     */
    public function registerModule($screen)
    {
        if (!is_array($screen)) {
            $screen = [$screen];
        }
        config([
            'packages.seo-helper.general.supported' => array_merge(config('packages.seo-helper.general.supported'),
                $screen),
        ]);
        return $this;
    }
}
