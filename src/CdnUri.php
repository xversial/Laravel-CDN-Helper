<?php
/**
 * Part of the cdn application.
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) VIONOX, Inc - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Brandon Xversial <xversial@vionox.com>, 04 2018
 */


namespace Xversial\LaravelCdnHelper;


class CdnUri
{

    /**
     * @var string
     */
    protected $resourceURI;

    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * CdnUri constructor.
     * @param \Illuminate\Config\Repository $config
     * @param $resourceURI
     */
    public function __construct(
        /*ConfigRepository */ $config,
        $resourceURI)
    {
        $this->resourceURI = str_replace(['\'', '"'], '', $resourceURI);
        $this->config = $config;
    }

    /**
     * Returns the built asset uri string
     * @return string
     */
    public function buildStaticURI()
    {
        return $this->getResourceURI();
    }

    private function getResourceURI()
    {
        $uri = parse_url($this->resourceURI);
        dd($uri);
        return print_r($uri, true);
    }
}