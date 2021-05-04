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

use Symfony\Component\Validator\Constraints;

/**
 * {@inheritdoc}
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 * @author Boris Guéry <guery.b@gmail.com>
 * @author Ener-Getick <egetick@gmail.com>
 */
abstract class AbstractParam implements ParamInterface
{
    /** @var string */
    public $name;

    /** @var string */
    public $key;

    /** @var mixed */
    public $default;

    /** @var string */
    public $description;

    /** @var bool */
    public $strict = false;

    /** @var bool */
    public $nullable = false;

    /** @var array */
    public $incompatibles = [];

    public function __construct(
        $name,
        $key = null,
        $default = null,
        $description = null,
        $strict = null,
        $nullable = null,
        $incompatibiles = null
    ) {
        $this->name = $name;
        $this->key = $key;
        $this->default = $default;
        $this->description = $description;
        $this->strict = $strict;
        $this->nullable = $nullable;
        $this->incompatibles = $incompatibiles;
    }

    /** {@inheritdoc} */
    public function getName()
    {
        return $this->name;
    }

    /** {@inheritdoc} */
    public function getDefault()
    {
        return $this->default;
    }

    /** {@inheritdoc} */
    public function getDescription()
    {
        return $this->description;
    }

    /** {@inheritdoc} */
    public function getIncompatibilities()
    {
        return $this->incompatibles;
    }

    /** {@inheritdoc} */
    public function getConstraints()
    {
        $constraints = [];
        if (!$this->nullable) {
            $constraints[] = new Constraints\NotNull();
        }

        return $constraints;
    }

    /** {@inheritdoc} */
    public function isStrict()
    {
        return $this->strict;
    }

    /**
     * @return string
     */
    protected function getKey()
    {
        return $this->key ?: $this->name;
    }
}
