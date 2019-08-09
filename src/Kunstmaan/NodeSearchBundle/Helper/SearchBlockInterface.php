<?php

namespace Kunstmaan\NodeSearchBundle\Helper;

/**
 * Implement this interface to define custom Twig search blocks for your entity.
 */
interface SearchBlockInterface
{
    /**
     * @return array
     */
    public function getSearchBlocks();
}
