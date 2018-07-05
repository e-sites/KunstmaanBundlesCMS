<?php

namespace Kunstmaan\TabBundle\Form\Type;

use Kunstmaan\TabBundle\Tests\Entity\TestEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TestType.
 *
 * @package Kunstmaan\NodeBundle\Form\Type
 */
class TestType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('title');
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => TestEntity::class,
		]);
	}
}
