<?php

namespace Kunstmaan\MenuBundle\Form;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Kunstmaan\MenuBundle\Entity\MenuItem;
use Kunstmaan\NodeBundle\Entity\NodeTranslation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuItemAdminType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $entityId = $options['entityId'];
        $menu = $options['menu'];
        $menuItemclass = $options['menuItemClass'];

        $builder->add(
            'parent',
            EntityType::class,
            [
                'class'         => $menuItemclass,
                'choice_label'  => 'displayTitle',
                'query_builder' => function (EntityRepository $entityRepository) use
                (
                    $entityId,
                    $menu
                ): QueryBuilder {
                    $queryBuilder = $entityRepository
                        ->createQueryBuilder('mi')
                        ->where('mi.menu = :menu')
                        ->setParameter(
                            'menu',
                            $menu
                        )
                        ->orderBy(
                            'mi.lft',
                            'ASC'
                        )
                    ;
                    if ($entityId) {
                        $queryBuilder
                            ->andWhere('mi.id != :id')
                            ->setParameter(
                                'id',
                                $entityId
                            )
                        ;
                    }

                    return $queryBuilder;
                },
                'attr'          => [
                    'class' => 'js-advanced-select',
                ],
                'multiple'      => false,
                'expanded'      => false,
                'required'      => false,
                'label'         => 'kuma_menu.form.parent',
                'placeholder'   => 'kuma_menu.form.parent_placeholder',
            ]
        );
        $builder->add(
            'type',
            ChoiceType::class,
            [
                'choices'     => array_combine(
                    MenuItem::$types,
                    MenuItem::$types
                ),
                'placeholder' => false,
                'required'    => true,
                'label'       => 'kuma_menu.form.type',
            ]
        );
        $locale = $options['locale'];
        $rootNode = $options['rootNode'];

        $builder->add(
            'nodeTranslation',
            EntityType::class,
            [
                'class'         => NodeTranslation::class,
                'choice_label'  => 'title',
                'query_builder' => function (EntityRepository $entityRepository) use
                (
                    $locale,
                    $rootNode
                ): QueryBuilder {
                    $queryBuilder = $entityRepository
                        ->createQueryBuilder('nt')
                        ->innerJoin(
                            'nt.publicNodeVersion',
                            'nv'
                        )
                        ->innerJoin(
                            'nt.node',
                            'n'
                        )
                        ->where('n.deleted = 0')
                        ->andWhere('nt.lang = :lang')
                        ->setParameter(
                            'lang',
                            $locale
                        )
                        ->andWhere('nt.online = 1')
                        ->orderBy(
                            'nt.title',
                            'ASC'
                        )
                    ;

                    if ($rootNode) {
                        $queryBuilder
                            ->andWhere('n.lft >= :left')
                            ->andWhere('n.rgt <= :right')
                            ->setParameter(
                                'left',
                                $rootNode->getLeft()
                            )
                            ->setParameter(
                                'right',
                                $rootNode->getRight()
                            )
                        ;
                    }

                    return $queryBuilder;
                },
                'attr'          => [
                    'class' => 'js-advanced-select',
                ],
                'multiple'      => false,
                'expanded'      => false,
                'required'      => true,
                'label'         => 'kuma_menu.form.node_translation',
                'placeholder'   => 'kuma_menu.form.node_translation_placeholder',
            ]
        );
        $builder->add(
            'title',
            TextType::class,
            [
                'required' => false,
                'label'    => 'kuma_menu.form.title',
            ]
        );
        $builder->add(
            'url',
            TextType::class,
            [
                'required' => true,
                'label'    => 'kuma_menu.form.url',
            ]
        );
        $builder->add(
            'newWindow',
            CheckboxType::class,
            [
                'required' => false,
                'label'    => 'kuma_menu.form.new_window',
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class'    => MenuItem::class,
                'menu'          => null,
                'entityId'      => null,
                'rootNode'      => null,
                'menuItemClass' => null,
                'locale'        => null,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'menuitem_form';
    }
}
