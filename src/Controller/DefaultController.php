<?php

// src/Controller/DefaultController.php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Mezzo;
use App\Entity\Persona;
use App\Entity\Equipaggio;
use App\Entity\Intervento;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="homepage"))
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'name' => "HOMEPAGE",
        ]);
    }


    /**
     * @Route("/nuovo/intervento", name="nuovoIntervento"))
     */
    public function nuovoIntervento()
    {
        return $this->render('default/editIntervento.html.twig', [
            'name' => "HOMEPAGE",
        ]);
    }



    /**
     * @Route("/admin/mostra/mezzo", name="mostramezzo")
     */
    public function showMezzo(LoggerInterface $logger)
    {
        $logger->info("show mezzo");

        $mezzoList = $this->getDoctrine()
            ->getRepository(Mezzo::class)
            ->findAll();

//echo("<pre>"); var_dump($mezzoList); exit;

        return $this->render('default/mostraMezzo.html.twig', [
            'mezzoList' => $mezzoList,
        ]);

    }

    /**
      * @Route("/admin/mostra/persona", name="mostrapersona")
      */
    public function showPersona(LoggerInterface $logger)
    {
        $logger->info("show persona");

        $personaList = $this->getDoctrine()
            ->getRepository(Persona::class)
            ->findAll();

//echo("<pre>"); var_dump($personaList); exit;

        return $this->render('default/mostraPersona.html.twig', [
            'personaList' => $personaList,
        ]);

    }

    /**
      * @Route("/admin/modifica/mezzo/{id}", name="adminmodificamezzo")
      */
    public function modificaMezzo(Request $request, LoggerInterface $logger, $id=null)
    {
        $logger->info("show persona");

	if (is_null($id)) {
	    // crea un nuovo mezzo
	    $mezzo = new Mezzo();
	} else {
            $mezzo = $this->getDoctrine()
                ->getRepository(Mezzo::class)
                ->find($id);
        }
	if (is_null($mezzo)) {
	    // crea un nuovo mezzo
	    $mezzo = new Mezzo();	    
	}

	$form = $this->createFormBuilder();
	$form = $form->add('targa', TextType::class);
	$form = $form->add('codice', TextType::class);
	$form = $form->add('sigla', TextType::class);
	$form = $form->add('altro', TextType::class);
	$form = $form->add('save', SubmitType::class, array('label' => 'Nuovo mezzo'));
	$form = $form->getForm();
	$form->handleRequest($request);

	if ($form->isSubmitted() && $form->isValid()) {
	    $data = $form->getData();
	    $mezzo->setTarga($data['targa']);
	    $mezzo->setCodice($data['codice']);
	    $mezzo->setSigla($data['sigla']);
	    $mezzo->setAltro($data['altro']);
	    $em = $this->getDoctrine()->getManager();
	    $em->persist($mezzo);
	    $em->flush();

	    return $this->redirectToRoute('mostramezzo');
	}
        return $this->render('default/adminModificaMezzo.html.twig', array(
            'form' => $form->createView(),
	    'mezzo' => $mezzo,
	    ));
    }

    /**
      * @Route("/admin/modifica/persona", name="modificapersona")
      */
    public function modificaPersona(LoggerInterface $logger)
    {

//TODO

    }

    /**
      * @Route("/crea")
      */
    public function crea(LoggerInterface $logger)
    {
        $logger->info("Crea db entries");
	$entityManager = $this->getDoctrine()->getManager();

	$mezzo = new Mezzo();
	$mezzo->setTarga("CRI12345");
	$mezzo->setCodice("PD351234");
	$mezzo->setSigla("R12");
	$mezzo->setAltro("");
        $entityManager->persist($mezzo);
	$entityManager->flush();

	$mezzo = new Mezzo();
	$mezzo->setTarga("CRI67890");
	$mezzo->setCodice("PD351567");
	$mezzo->setSigla("R18");
	$mezzo->setAltro("");
        $entityManager->persist($mezzo);
	$entityManager->flush();

	$persona = new Persona();
	$mezzo = new Mezzo();
	$persona->setNome("Giorgio");
	$persona->setCognome("Gini");
	$persona->setCodiceFiscale("GNIGRG");
	$persona->setCodiceCRI("TACRI1");
	$persona->setAltro("");
        $entityManager->persist($persona);
	$entityManager->flush();

	$persona = new Persona();
	$mezzo = new Mezzo();
	$persona->setNome("Pino");
	$persona->setCognome("Paoli");
	$persona->setCodiceFiscale("PNIPLI");
	$persona->setCodiceCRI("TACRI2");
	$persona->setAltro("");
        $entityManager->persist($persona);
	$entityManager->flush();


        return $this->render('default/index.html.twig', [ 'name' => "Creati!" ]);
    }


    /**
      * @Route("/hello/{name}")
      */
    public function hello($name, LoggerInterface $logger)
    {
        $logger->info("Saying hello to $name!");
        return $this->render('default/index.html.twig', [
            'name' => $name,
        ]);
    }


//
// API
//
    /**
     * @Route("/api/hello/{name}")
     */
    public function apiExample($name)
    {
        return $this->json([
            'name' => $name,
            'symfony' => 'rocks',
        ]);
    }

}
