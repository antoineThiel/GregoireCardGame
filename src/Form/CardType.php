<?php

namespace App\Form;

use App\Entity\Card;
use App\Entity\Deck;
use App\Enum\ColorEnum;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre",
            ])
            ->add('text', TextareaType::class, [
                "label" => "Description",
                "attr" => ['style' => 'min-height:150px']
            ])
            ->add('deck', EntityType::class, [
                "class" => Deck::class,
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('color', ChoiceType::class, [
                "label" => "Couleur",
                "choices" => array_flip(ColorEnum::getChoices())
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
