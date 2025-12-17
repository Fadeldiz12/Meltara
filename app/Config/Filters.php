<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,

        // ================= AUTH FILTERS =================
        'authadmin' => \App\Filters\AuthAdmin::class,
        'authCustomer'  => \App\Filters\AuthCustomer::class, // ✅ FIX
    ];
    

    /**
     * List of special required filters.
     */
    public array $required = [
    'before' => [
        'forcehttps',
        // 'pagecache', ❌ MATIKAN
    ],
    'after' => [
        // 'pagecache', ❌ MATIKAN
        'performance',
        'toolbar',
    ],
];


    /**
     * Global filters.
     */
    public array $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],
        'after' => [
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * Method-specific filters.
     */
    public array $methods = [];

    /**
     * URI pattern filters.
     */
public array $filters = [];

}
