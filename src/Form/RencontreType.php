<?php

namespace App\Form;

use App\Entity\Competition;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class RencontreType extends AbstractType
{
     /**
     * Permer d'avoir la configuration de base d'un champ 
     *
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    private function getConfiguration($label, $placeholder)
    {
        return[
             'label' => $label,
                'attr' => [
                    'placeholder' => $placeholder]
                ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $rencontre = $options['data'];
        $currentDate = new DateTime();

        $builder
            ->add('dateRencontre', DateType::class, [
                'label' => "Date de la rencontre",
                'attr' => [
                    'placeholder' => "Saisir la date de la rencontre"
                ],
                // 'constraints' => [
                //     new GreaterThan([
                //         'value' => new \DateTime(),
                //         'message' => "La date de la rencontre doit être supérieure ou égale à la date du jour."
                //     ])
                // ]
            ])
            ->add('Stade', TextType::class, $this->getConfiguration("Stade", "Saisir le stade de la rencontre"))
            ->add('domicile', TextType::class, $this->getConfiguration("Domicile", "Saisir l'equipe à domicile"))
            ->add('exterieur', TextType::class, $this->getConfiguration("Exterieur", "Saisir l'equipe à l'exterieur"))
            ->add('rencontreImage', UrlType::class, $this->getConfiguration("Image", "Saisir une image de rencontre"))
            ->add('score',TextType::class,[
                'label'=>"Score",
                'attr'=>[
                    'placeholder'=>"Saisir le score du match",'readonly' => $rencontre->getDateRencontre() > $currentDate
                ],
                'required' => false
            ])
            ->add('prix', IntegerType::class, [
                'label'=> "Prix", 
                'attr' => 
                ['placeholder' => "Saisir le prix de la rencontre", 'readonly' => $rencontre->getDateRencontre() < $currentDate],
                'required' => false
            ])
            ->add('competition', EntityType::class,[
                'class'=>Competition::class,
                'choice_label'=>'nom',
            ],);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            
        ]);
    }
}
