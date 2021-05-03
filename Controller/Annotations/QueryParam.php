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

use Symfony\Component\HttpFoundation\Request;

/**
 * Represents a parameter that must be present in GET data.
 *
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 *
 * @author Alexander <iam.asm89@gmail.com>
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class QueryParam extends AbstractScalarParam
{

    public function __construct($name,
                                $key = null,
                                $requirements = null,
                                $incompatibiles = [],
                                $default = null,
                                $description = null,
                                $strict = null,
                                $map = null,
                                $nullable = null )
    {
        $this->name = $name;
        $this->key = $key;
        $this->requirements = $requirements;
        $this->incompatibles = $incompatibiles;
        $this->default = $default;
        $this->description = $description;
        $this->strict = $strict;
        $this->map = $map;
        $this->nullable = $nullable;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue(Request $request, $default = null)
    {
        return $request->query->all()[$this->getKey()] ?? $default;
    }
}
