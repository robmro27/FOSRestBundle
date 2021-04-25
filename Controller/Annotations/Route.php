<?php

/*
 * This file is part of the FOSRestBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\RestBundle\Controller\Annotations;

use Symfony\Component\Routing\Annotation\Route as BaseRoute;

/**
 * Route annotation class.
 *
 * @Annotation
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class Route extends BaseRoute
{
    public function __construct(...$data)
    {
        parent::__construct(...$data);

        if (!$this->getMethods()) {
            $this->setMethods((array) $this->getMethod());
        }
    }

    /**
     * @return string|null
     */
    public function getMethod()
    {
        return;
    }
}
