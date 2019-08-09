<?php

namespace Kunstmaan\NodeSearchBundle\Helper;

/**
 * Implement this interface to define a custom Twig search block for your entity.
 */
interface SearchBlockInterface
{
    /**
     * @return array
     */
    public function getSearchBlocks();
}