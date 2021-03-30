<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\DTO\ToDoListItemDTO;
use App\Entity\ToDoListItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ToDoListItemType extends AbstractType implements DataMapperInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('task', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 255,
                    ]),
                ],
            ])
            ->setDataMapper($this);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'      => ToDoListItemDTO::class,
            'empty_data'      => null,
            'csrf_protection' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function mapDataToForms($viewData, iterable $forms): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function mapFormsToData($forms, &$viewData): void
    {
        try {
            if (!$forms instanceof \Traversable) {
                return;
            }
            $forms    = \iterator_to_array($forms);
            $viewData = new ToDoListItemDTO(
                null,
                $forms['task']->getData(),
                ToDoListItem::STATUS_PENDING
            );
        } catch (\Throwable $exception) {
            // ...
        }
    }
}
