<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ref')
            ->add('title', TextType::class) // ✅ Champ manquant ajouté ici
            ->add('publicationDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('category', ChoiceType::class, [
                'choices'  => [
                    'Science Fiction' => 'Science Fiction',
                    'Fantasy' => 'Fantasy',
                    'Mystery' => 'Mystery',
                    'Non-Fiction' => 'Non-Fiction',
                ],
            ])
            ->add('published')
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'id', // tu peux mettre 'username' si ton Author a un champ 'username'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
