<?php

namespace Book\BookBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BookType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Check the action to see if its an edit or create form
        $pieces[] = explode('/',$options['action']);
        $isCreateForm = in_array("create", $pieces[0]);

        $builder->add('title')
                ->add('author')
                ->add('isbn')
                ->add('summaryOfBook')
                ->add('imageFile', VichImageType::class, [
                    'required' => $isCreateForm ? true : false,
                    'download_uri' => false,
                    'image_uri' => false,
                ])
                ->add('submit',SubmitType::class, ['attr'
                    => ['class' => 'btn btn-primary']
                ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Book\BookBundle\Entity\Book'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'book_bookbundle_book';
    }
}
