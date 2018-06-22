<?php

namespace Kunstmaan\NodeBundle\Repository;

use DateTime;
use Doctrine\ORM\EntityRepository;
use Kunstmaan\AdminBundle\Entity\BaseUser;
use Kunstmaan\NodeBundle\Entity\HasNodeInterface;
use Kunstmaan\NodeBundle\Entity\NodeTranslation;
use Kunstmaan\NodeBundle\Entity\NodeVersion;
use Kunstmaan\UtilitiesBundle\Helper\ClassLookup;

/**
 * NodeRepository
 */
class NodeVersionRepository extends EntityRepository
{
	/**
	 * @param HasNodeInterface $hasNode
	 * @return NodeVersion|null
	 * @throws \Doctrine\ORM\NonUniqueResultException
	 */
	public function getNodeVersionFor(HasNodeInterface $hasNode)
	{
		return $this->getNodeVersionForIdAndEntityname($hasNode->getId(), ClassLookup::getClass($hasNode));
	}

	/**
	 * @param $id
	 * @param $entityName
	 * @return NodeVersion|null
	 * @throws \Doctrine\ORM\NonUniqueResultException
	 */
	public function getNodeVersionForIdAndEntityname($id, $entityName) {
		return $this->createQueryBuilder('node_version')
			->addSelect('node_translation')
			->join('node_version.nodeTranslation', 'node_translation')
			->where('node_version.refId = :refId')
			->andWhere('node_version.refEntityName = :refEntityName')
			->andWhere('node_translation.lang = :lang')
			->setParameter('refId', $id)
			->setParameter('refEntityName', $entityName)
			->setParameter('lang', \Locale::getDefault())
			->setMaxResults(1)
			->getQuery()
			->getOneOrNullResult()
		;
	}

    /**
     * @param HasNodeInterface $hasNode         The object
     * @param NodeTranslation  $nodeTranslation The node translation
     * @param BaseUser         $owner           The user
     * @param NodeVersion      $origin          The nodeVersion this nodeVersion originated from
     * @param string           $type            (public|draft)
     * @param DateTime         $created         The date this node version is created
     *
     * @return NodeVersion
     */
    public function createNodeVersionFor(
        HasNodeInterface $hasNode,
        NodeTranslation $nodeTranslation,
        BaseUser $owner,
        NodeVersion $origin = null,
        $type = 'public',
        $created = null
    ) {
        $em = $this->getEntityManager();

        $nodeVersion = new NodeVersion();
        $nodeVersion->setNodeTranslation($nodeTranslation);
        $nodeVersion->setType($type);
        $nodeVersion->setOwner($owner);
        $nodeVersion->setRef($hasNode);
        $nodeVersion->setOrigin($origin);

        if (!is_null($created)) {
            $nodeVersion->setCreated($created);
        }

        $em->persist($nodeVersion);
        $em->flush();
        $em->refresh($nodeVersion);

        return $nodeVersion;
    }
}
