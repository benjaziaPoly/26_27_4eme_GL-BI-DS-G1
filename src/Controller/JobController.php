<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\Image;
use App\Entity\Job;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JobController extends AbstractController
{
    // /job => toutes les offres d'emploi
    #[Route("/job",name:'job_index')]
    public function index(EntityManagerInterface $entity){
        $listjobs=$entity->getRepository(Job::class)->findAll();
        return $this->render("job/index.html.twig",["jobs"=>$listjobs]);
    }
   #[Route('/job/candidature/create', name: 'add_cand_form')]
   public function createCandidature(){
     $cand=new Candidature();
     //creation du formulaire
     $formbuilder=$this->createFormBuilder($cand)
       ->add("candidat",TextType::class)
       ->add("contenu",TextType::class)
       ->add("date",DateType::class)
       //il manque le champs JOB !!!
       ->add("valider", SubmitType::class);

   }


    #[Route('/job/create-demo', name: 'app_job')]
    public function demo(EntityManagerInterface $em): Response
    {
       $job= new Job();

       $job->setType('CDD');
       $job->setCompany('Societe GFI');
       $job->setDescription('Ingénieur en BI');
       $job->setExpiresAt(new \DateTimeImmutable('+45 days'));
       $job->setEmail('contact@email.com');
       
       // création d'une Image 
       $img=new Image();
       $img->setUrl("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9uaAbs2x-jQKYwYZRa_WbiU_CZcXoFVSAdFUqmNQ3PQ&s=10");
       $img->setAlt("job de reve");
       //affecter l'image creer au job courant
       $job->setImage($img);
       //candidatures
       $candidat1=new Candidature();
       $candidat1->setCandidat("Ali ben saleh")
        ->setContenu("poste ing dev")
        ->setDate(new \DateTime())
        ->setJob($job);
        $candidat2=new Candidature();
       $candidat2->setCandidat("Amira ben saleh")
        ->setContenu("poste ing dev")
        ->setDate(new \DateTime())
        ->setJob($job);
        $em->persist($candidat1);
        $em->persist($candidat2);
       

       
       $em->persist($job);
       $em->flush();//save to database
      return $this->render('job/createjob.html.twig',["id"=>$job->getId()]);
    }
#[Route("/job/{id}", name:"job_detail")]
public function show(int $id, EntityManagerInterface $em){
    $job=$em->getRepository(Job::class)->find($id);
    //candidatures!!!
    $listcandidats=$em->getRepository(Candidature::class)
         ->findBy(["job"=>$job]);

    return $this->render('job/show.html.twig',[ 
        "job"=>$job ,"candidatures"=>$listcandidats
    ]);

    /**
     * find ==> id : find(3); where id=3, retour: 1L /0 
     * findall  : findall(): select *: Array
     * findOne  : findOne['type'=>"cdi", "ville"=>"sousse], retour: 0, 1
     * findBy: findBy['type'=>'cdi', "ville"=>"sousse] => Array
     
     */
    }
}
