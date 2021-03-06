<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\ItemSaleType;
use Doctrine\ORM\EntityRepository;

class SaleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


            ->add('items', 'collection', array(
                'type' => new ItemSaleType(),
                'allow_add' => true,
                'allow_delete' => true,
                'cascade_validation' => true,
                'by_reference' => false,
                'required' => true,
            ))
            ->add('person', 'entity', array('class' => 'AppBundle:Person',
                'property' => 'name',
                'label' => 'client.labels.self',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->select('c')
                        ->from('AppBundle:Client', 'c')
                        ->where('c.deleted = false')
                        ;
                }))
            ->add('cash', null, ['label' => 'operation.labels.cash'])
            ->add('total', null, ['label' => 'operation.labels.total' , 'attr'=> array('class'=>'total')])

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Sale',
            'cascade_validation' => true,

        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_operation';
    }
}
