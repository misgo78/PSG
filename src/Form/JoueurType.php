<?php

namespace App\Form;

use App\Entity\Personne;
use App\Entity\Poste;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class JoueurType extends AbstractType
{
        /**
     * Perme d'avoir la configuration de base d'un champ 
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
        $builder
            ->add('prenom', TextType::class, $this->getConfiguration("Prenom", "Saisir le prenom du joueur"))
            ->add('nom', TextType::class, $this->getConfiguration("Nom", "Saisir le nom du joueur"))
            ->add('dateNaiss', DateType::class, ['widget'=>'single_text'])
            ->add('statut', TextareaType::class, $this->getConfiguration("Statut", "Saisir la taille et le poids du joueur"))
            ->add('personneImage', UrlType::class, $this->getConfiguration("Image", "Saisir une image du joueur"))
            ->add('nationalite', TextType::class, $this->getConfiguration("Nationalite", "Saisir la nationalite du joueur"))
            ->add('dateArrivee', DateType::class, ['widget'=>'single_text'])
            ->add('poste', EntityType::class,[
                'class'=>Poste::class,
                'choice_label'=>'name',
            ],);
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
