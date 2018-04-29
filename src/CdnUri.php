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


use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CdnUri
{

    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    private $scheme = NULL;
    private $host = NULL;
    private $port = NULL;
    private $user = NULL;
    private $pass = NULL;
    private $path = NULL;
    private $query = NULL;
    private $fragment = NULL;

    /**
     * CdnUri constructor.
     * @param \Illuminate\Config\Repository $config
     * @param $resourceURI
     */
    public function __construct(
        /*ConfigRepository */
        $config,
        $resourceURI )
    {
        $uri = str_replace( [ '\'', '"' ], '', $resourceURI );
        $this->scheme = parse_url( $uri, PHP_URL_SCHEME );
        $this->host = parse_url( $uri, PHP_URL_HOST );
        $this->port = parse_url( $uri, PHP_URL_PORT );
        $this->user = parse_url( $uri, PHP_URL_USER );
        $this->pass = parse_url( $uri, PHP_URL_PASS );
        $this->path = parse_url( $uri, PHP_URL_PATH );
        $this->query = parse_url( $uri, PHP_URL_QUERY );
        $this->fragment = parse_url( $uri, PHP_URL_FRAGMENT );
        $this->config = $config->get( 'cdn-helper' );
    }

    /**
     * Returns the built asset uri string
     * @return string
     */
    public function buildStaticURI()
    {
        return $this->getResourceURI();
    }

    public function getScheme()
    {
        if ( $this->getConfig( 'cdn-helper.enforce_ssl' ) ) {
            return "https";
        } elseif ( $this->getConfig( 'cdn-helper.scheme_crossover' ) ) {
            return "//";
        } else {
            return ( $this->scheme ? $this->scheme : ( $this->hasHost() ? "//" : null ) );
        }
    }

    public function getSchemeFormatted()
    {
        $scheme = $this->getScheme();
        return ( $scheme == "//" ? "//" : ( $scheme . "://" ) );
    }

    public function hasHost()
    {
        return ( $this->host !== null );
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getQueryFormatted()
    {
        return ( $this->query ? '?' . http_build_query( $this->query ) : null );
    }

    public function getFragment()
    {
        return $this->fragment;
    }

    public function getFragmentFormatted()
    {
        return ( $this->fragment ? '#' . ( $this->fragment ) : null );
    }

    public function getPath()
    {
        return Str::start( $this->path, '/' );
    }

    private function getConfig( $key, $default = null )
    {
        return Arr::get( $this->config, $key, $default );
    }

    private function getEndURI()
    {
        return $this->getPath() . $this->getQueryFormatted() . $this->getFragmentFormatted();
    }

    private function getResourceURI()
    {
        if ( $this->hasHost() ) {
            return $this->getSchemeFormatted() . $this->getHost() . $this->getEndURI();
        } elseif ( $this->getConfig( 'enable' ) ) {
            return $this->getSchemeFormatted() . $this->getConfig( 'domain' ) . $this->getEndURI();
        } else {
            return $this->getEndURI();
        }
    }
}