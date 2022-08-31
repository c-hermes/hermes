<?php

namespace App\Form\Admin;

use App\Entity\Hermes\Menu;
use App\Entity\Hermes\Post;
use App\Entity\Hermes\Section;

use App\Entity\Hermes\Template;
use App\Repository\TemplateRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SectionTemplateType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options['active'] = false;
        $options['name'] = false;
        $options['tooltip'] = 'Nom';

        if (true === $options['config'] || null  === $options['config']) {
            if ($options['position']) {
                $builder
                    ->add('position', NumberType::class, [
                        'required' => false,
                        'attr' => ['class' => 'select2 custom-select custom-select-lg mb-3 ']
                    ]);
            }
            $builder
                ->add('template', EntityType::class, [
                    'class' => Template::class,
                    'query_builder' => function (TemplateRepository $er) use ($options) {
                        if ($options['full_template']) {
                            return $er->getQbTemplates();
                        }
                        return $er->getQbInitTemplates();
                    },
                    'attr' => ['class' => 'select2 custom-select custom-select-lg mb-3 ']
                ])
                ->add('templateWidth', ChoiceType::class, [
                    'choices' => $options['template_width'],
                    'required' => false,
                    'attr' => ['class' => 'templateWidth select2 custom-select custom-select-lg mb-3 '],
                ])
                ->add('transparent', ChoiceType::class,
                    [
                        'choices' =>  [
                            'transparent.no' => false,
                            'transparent.yes' => true ,
                        ],
                        'attr' => ['class' => 'select2 custom-select select2 custom-select-lg mb-3']
                    ])
                ->add('templateBgcolor', ColorType::class, [
                    'required' => false,
                ])
                ->add('templateNbCol', ChoiceType::class, [
                    'choices' => [
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                    ],
                    'required' => false,
                    'attr' => ['class' => 'templateNbCol select2 custom-select custom-select-lg mb-3 '],
                ])
                ->add('templateImageFilter', ChoiceType::class, [
                    'choices' => [
                        'Format Bd 154' => 'bd_154',
                        'Format Bd 309' => 'bd_309',
                        'Format Bd 500' => 'bd_500',
                        'Format carre 150' => 'carre_150',
                        'Format carre 300' => 'carre_300',
                        'Format carre 550' => 'carre_550',
                        'Format paysage 860*618' => 'paysage_860',
                        'Format paysage 700*324' => 'paysage_700',
                    ],
                    'required' => false,
                    'attr' => ['class' => 'templateImageFilter select2 custom-select custom-select-lg mb-3 '],
                ])
                ->add('template2', EntityType::class, [
                    'class' => Template::class,
                    'query_builder' => function (TemplateRepository $er) use ($options) {
                        return $er->getQbTemplate2();
                    },
                    'attr' => ['class' => 'select2 custom-select custom-select-lg mb-3 ']
                ])
                ->add('template2Width', ChoiceType::class, [
                    'choices' => $options['template_width'],
                    'required' => false,
                    'attr' => ['class' => 'templateWidth select2 custom-select custom-select-lg mb-3 '],
                ]);
            if ($options['menu']) {
                $builder
                    ->add('menu', EntityType::class, [
                        'class' => Menu::class,
                        'attr' => ['class' => 'select2 custom-select custom-select-lg mb-3 ']
                    ]);
            }
            if ($options['position']) {
                $builder
                    ->add('position');
            }
        }

        if (false === $options['config'] || null  === $options['config'] ) {
            $builder->add('posts', CollectionType::class, $options['posts']);
        }


        if ($options['save_visibility']) {
            $builder
                ->add('saveAndAddPost', SubmitType::class, [
                    'icon_before' => '<i class="fa fa-save"></i> <i class="fa fa-plus-circle"></i>',
                    'label_html' => true,
                    'label' => 'menu.update_next'
                ])
                ->add('saveAndAddSectionPost', SubmitType::class, [
                    'icon_before' => '<i class="fa fa-save"></i> <i class="fa fa-plus-circle"></i>',
                    'label_html' => true,
                    'label' => 'menu.update_next_different'
                ])
                ->add('save', SubmitType::class, [
                    'icon_before' => '<i class="fa fa-save"></i>',
                    'label_html' => true,
                    'label' => 'global.update'
                ]);
        }

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            [$this, 'onPostSubmitData']
        );

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            if(!is_null($data)){
                if('transparent' == $data->getTemplateBgcolor()){
                    $data->setTransparent(true);
                }
            }
        });
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            if($data->getTransparent()){
                $data->setTemplateBgcolor('transparent');
            }
        });
    }

    public function onPostSubmitData(FormEvent $event)
    {
        $section = $event->getData();
        $form = $event->getForm();
        $section->setName($form->getViewData()->getTemplate()->getName() . '-' . $section->getMenu()->getName());
        $section->setTemplate($form->getViewData()->getTemplate());
        $section->setTemplate2($form->getViewData()->getTemplate2());
        $event->setData($section);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Section::class,
            'save_visibility' => true,
            'content' => true,
            'url' => true,
            'menu' => false,
            'config' => null,
            'template_width'=>  [
                '1/12' => '1',
                '2/12' => '2',
                '3/12' => '3',
                '4/12' => '4',
                '5/12' => '5',
                '6/12' => '6',
                '7/12' => '7',
                '8/12' => '8',
                '9/12' => '9',
                '10/12' => '10',
                '11/12' => '11',
                '12/12' => '12',
            ],
            'posts' => [
                'entry_type' => PostType::class,
                'constraints' => new \Symfony\Component\Validator\Constraints\Valid(),
                'prototype' => true,
                'prototype_name' => 'post',
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
                'label' => false,
                'entry_options' => ['label' => false, 'active' => false, 'position' => false, 'name' => true, 'content' => true, 'url' => true, 'save_visibility' => false, 'save' => false, 'saveAndAdd' => false, 'saveAndAddPost' => false, 'saveAndAddSectionPost' => false,],
            ],
            'full_template' => true,
            'name_constraints' => [],
            'position' => true,
            'saveAndAddSectionPost' => false,
            'validation_groups' => function (FormInterface $form) {
                $data = $form->getData();
                $image_valid = true;
                if (!$image_valid) {
                    foreach ($data->getPosts() as $post) {
                        if (!$post->getImageFile() && !$post->getFileName()) {
                            $image_valid = false;
                            break;
                        }
                    }
                }
                if ($data instanceof Section) {
                    $template = $data->getTemplate();
                }
                if ($data instanceof Post) {
                    $template = $data->getSection()->getTemplate();
                }
                if ('libre' == $template->getCode() || 'libre_code' == $template->getCode()) {
                    return ['Default', 'content'];
                } else {
                    if (!$image_valid) {
                        return ['Default', 'image'];
                    }
                }
                return ['Default'];
            },
        ]);
    }
}


