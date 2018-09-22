<?php

// src/Controller/DefaultController.php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Component\Validator\Constraints\DateTime;

use App\Entity\Mezzo;
use App\Entity\Persona;
use App\Entity\Equipaggio;
use App\Entity\Intervento;

class DefaultController extends AbstractController
{

    function getUltimoEquipaggio() {
        $last = $this->getDoctrine()
            ->getRepository(Equipaggio::class)
            ->findOneBy(array(), array("id" => "DESC"));
        return $last;
    }

    function getUltimoIntervento() {
        $last = $this->getDoctrine()
            ->getRepository(Intervento::class)
            ->findOneBy(array(), array("id" => "DESC"));
        return $last;
    }

    function getListaMezziAsDescId() {
        $l = $this->getDoctrine()
            ->getRepository(Mezzo::class)
            ->findAll();
        $assoc_arr = array_reduce($l, function ($result, $item) {
          $result[$item->getSigla() . " - " . $item->getTarga()] = $item->getId();
          return $result;
        }, array());
        return($assoc_arr);
    }

    function getListaPersoneAsDescId() {
        $l = $this->getDoctrine()
            ->getRepository(Persona::class)
            ->findAll();
        $assoc_arr = array_reduce($l, function ($result, $item) {
          $result[$item->getCognome() . " " . $item->getNome()] = $item->getId();
          return $result;
        }, array());
	$assoc_arr["-"] = 0;
        return($assoc_arr);
    }

    function getMezzoDisplayName($id) {
        $x = $this->getDoctrine()
            ->getRepository(Mezzo::class)
            ->find($id);
	return is_null($x)?"":$x->getSigla();
    }

    /**
     * @Route("/", name="homepage"))
     */
    public function index()
    {
        $equi = $this->getUltimoEquipaggio();
//echo("<pre>"); var_dump($equi->getInizio()); exit;
	$repoP = $this->getDoctrine()->getRepository(Persona::class);
	$repoI = $this->getDoctrine()->getRepository(Intervento::class);
	$listaCorrenti = $repoI->findBy(array('isCompletato' => false));
	$listaStorico = $repoI->findBy(array('isCompletato' => true));

//echo("<pre>"); var_dump($listaCorrenti); exit;

        return $this->render('default/index.html.twig', [
            'name' => "HOMEPAGE",
	    'listaCorrenti' => $listaCorrenti,
	    'listaStorico' => $listaStorico,
	    'listaMezziCorrenti' => array_map(function($x) { 
	        return $this->getMezzoDisplayName($x->getIdMezzo()); }, $listaCorrenti),
	    'listaMezziStorico' => array_map(function($x) { 
	        return $this->getMezzoDisplayName($x->getIdMezzo()); }, $listaStorico),
	    'equi' => $equi,
	    'm' => is_null($equi)?null:$this->getDoctrine()->getRepository(Mezzo::class)->find($equi->getIdMezzo()),
	    'listaPersone' => array_map(function ($x) use ($repoP) { 
	           $p = $repoP->find($x[0]);
		   if (is_null($p)) {
		     $cognomeNome = "";
		   } else {
		     $cognomeNome = $p->getCognome() . " " . $p->getNome();
		   }
	    	   return([$cognomeNome, $x[1], $x[2], $x[3], $x[4]]); 
	    }, is_null($equi)?[]:$equi->getIdPersonaABCTLista()),
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
     * @Route("/admin/mostra/equipaggio", name="mostraequipaggio")
     */
    public function showEquipaggio(LoggerInterface $logger)
    {
        $logger->info("show equipaggio");

        $equipaggioList = $this->getDoctrine()
            ->getRepository(Equipaggio::class)
            ->findAll();

//echo("<pre>"); var_dump($mezzoList); exit;

        return $this->render('default/mostraEquipaggio.html.twig', [
            'equipaggioList' => $equipaggioList,
        ]);

    }

    /**
      * @Route("/admin/cancella/equipaggio/{id}", name="admincancellaequipaggio")
      */
    public function cancellaEquipaggio(Request $request, LoggerInterface $logger, $id=null)
    {
        $logger->info("cancella equipaggio");
        $equipaggio = $this->getDoctrine()
                ->getRepository(Equipaggio::class)
                ->find($id);
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($equipaggio);
        $em->flush();
        return $this->redirectToRoute('mostraequipaggio');
    }

    /**
      * @Route("/admin/cancella/mezzo/{id}", name="admincancellamezzo")
      */
    public function cancellaMezzo(Request $request, LoggerInterface $logger, $id=null)
    {
        $logger->info("cancella mezzo");
        $mezzo = $this->getDoctrine()
                ->getRepository(Mezzo::class)
                ->find($id);
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($mezzo);
        $em->flush();
        return $this->redirectToRoute('mostramezzo');
    }

    /**
      * @Route("/modifica/equipaggio/start", name="modificaequipaggiostart")
      */
    public function modificaEquipaggioStart(Request $request, LoggerInterface $logger)
    {
        $logger->info("modifica equipaggio start");
	$ultimoEquipaggio = $this->getUltimoEquipaggio();
	$equipaggio = new Equipaggio();
	$equipaggio->setInizio(new \DateTime('now'));
	$equipaggio->setFine(null);
	$equipaggio->setNote(null);	 
	$equipaggio->setTipo("S");
	$equipaggio->setQuando("N");
	$equipaggio->setIdPersonaABCTLista([]);
	if (is_null($ultimoEquipaggio)) {
            // nessun equipaggio presente - inizializzane uno di nuovo
	    $equipaggio->setIdMezzo(0);
	    $equipaggio->setNumeroTurno(1);
	} else {
	    $equipaggio->setIdMezzo($ultimoEquipaggio->getIdMezzo());
	    $equipaggio->setNumeroTurno($ultimoEquipaggio->getNumeroTurno() + 1);
 	}
	$em = $this->getDoctrine()->getManager();
	$em->persist($equipaggio);
	$em->flush();
	$id = $equipaggio->getId();
//echo("<pre>"); var_dump($equipaggio); exit;
	return $this->redirectToRoute('modificaequipaggioint', array('id' => $id));
    }

    /**
      * @Route("/modifica/equipaggio/stop/{id}", name="modificaequipaggiostop")
      */
    public function modificaEquipaggioStop(Request $request, LoggerInterface $logger, $id)
    {
        $logger->info("modifica equipaggio stop");
        $equipaggio = $this->getDoctrine()
            ->getRepository(Equipaggio::class)
            ->find($id);
	if (is_null($equipaggio)) {
	    return $this->redirectToRoute('homepage');
	} 
	$equipaggio->setFine(new \DateTime('now'));
	$em = $this->getDoctrine()->getManager();
	$em->persist($equipaggio);
	$em->flush();
	return $this->redirectToRoute('homepage');
    }

    /**
      * @Route("/modifica/equipaggio/edit/{id}", name="modificaequipaggioedit")
      */
    public function modificaEquipaggioEdit(Request $request, LoggerInterface $logger, $id)
    {
        $logger->info("modifica equipaggio edit");
        $equipaggio = $this->getDoctrine()
            ->getRepository(Equipaggio::class)
            ->find($id);
	if (is_null($equipaggio)) {
	    return $this->redirectToRoute('homepage');
	} 
	return $this->redirectToRoute('modificaequipaggioint', array('id' => $id));
    }

    /**
      * @Route("/modifica/equipaggio/int/{id}", name="modificaequipaggioint")
      */
    public function modificaEquipaggioInt(Request $request, LoggerInterface $logger, $id)
    {
        $logger->info("modifica equipaggio");

        $equipaggio = $this->getDoctrine()
            ->getRepository(Equipaggio::class)
            ->find($id);

//echo("<pre>"); var_dump($equipaggio); exit;

	$form = $this->createFormBuilder();
	$form = $form->add('idMezzo', ChoiceType::class, array(
	  'expanded' => false,
	  'multiple' => false,
	  'choices' => $this->getListaMezziAsDescId(),
          'data' => $equipaggio->getIdMezzo(),
	));
	$form = $form->add('numeroTurno', TextType::class);
	$form = $form->add('tipo', ChoiceType::class, array(
	  'expanded' => false,
	  'multiple' => false,
	  'choices' => array(
	      'SUEM' => 'S',
	      'Altro' => 'x',
	      ),
          'data' => $equipaggio->getTipo(),
          ));
	$form = $form->add('quando', ChoiceType::class, array(
	  'expanded' => false,
	  'multiple' => false,
	  'choices' => array(
	    'Mattina' => 'M',
	    'Pomeriggio' => 'P',
	    'Notte' => 'N',
	  ),
          'data' => $equipaggio->getQuando(),
  	));
	$form = $form->add('note', TextType::class, array(
	       	    'required'    => false,
	));

        // persone 
	$listaPersoneAsDescId = $this->getListaPersoneAsDescId();
	for ($i=0; $i<4; $i++) {
	    $form = $form->add('persona' . $i, ChoiceType::class, array_merge(array(
	      'expanded' => false,
	      'multiple' => false,
	      'choices' => $listaPersoneAsDescId,
              ), empty($equipaggio->getIdPersonaABCTLista())?[]:
                array('data' => $equipaggio->getIdPersonaABCTLista()[$i][0]))
	    );

	    $form = $form->add('autista' . $i, CheckboxType::class, array(
	    	  'data'        => empty($equipaggio->getIdPersonaABCTLista())?false:$equipaggio->getIdPersonaABCTLista()[$i][1],
	       	  'required'    => false));
	    $form = $form->add('blsd' . $i, CheckboxType::class, array(
	    	  'data'        => empty($equipaggio->getIdPersonaABCTLista())?false:$equipaggio->getIdPersonaABCTLista()[$i][2],
	    	  'required'    => false));
	    $form = $form->add('capoequipaggio' . $i, CheckboxType::class, array(
	    	  'data'        => empty($equipaggio->getIdPersonaABCTLista())?false:$equipaggio->getIdPersonaABCTLista()[$i][3],
	    	  'required'    => false));
	    $form = $form->add('tirocinante' . $i, CheckboxType::class, array(
	    	  'data'        => empty($equipaggio->getIdPersonaABCTLista())?false:$equipaggio->getIdPersonaABCTLista()[$i][4],
	    	  'required'    => false));

	}

	$form = $form->add('save', SubmitType::class, array('label' => 'SALVA'));
	$form = $form->getForm();
	$form->handleRequest($request);

	if ($form->isSubmitted() && $form->isValid()) {
	    $data = $form->getData();
//echo("<pre>"); var_dump($data); exit;
	    $equipaggio->setIdMezzo($data['idMezzo']);
	    $equipaggio->setNumeroTurno($data['numeroTurno']);
	    $equipaggio->setTipo($data['tipo']);
	    $equipaggio->setQuando($data['quando']);
	    $equipaggio->setNote($data['note']);

	    $equipaggio->setIdPersonaABCTLista([
	      [$data['persona0'], $data['autista0'], $data['blsd0'], $data['capoequipaggio0'], $data['tirocinante0']],
	      [$data['persona1'], $data['autista1'], $data['blsd1'], $data['capoequipaggio1'], $data['tirocinante1']],
	      [$data['persona2'], $data['autista2'], $data['blsd2'], $data['capoequipaggio2'], $data['tirocinante2']],
	      [$data['persona3'], $data['autista3'], $data['blsd3'], $data['capoequipaggio3'], $data['tirocinante3']],
	    ]);

	    $em = $this->getDoctrine()->getManager();
	    $em->persist($equipaggio);
	    $em->flush();

//echo("<pre>"); var_dump($equipaggio); exit;

	    return $this->redirectToRoute('homepage');
	}
        return $this->render('default/modificaEquipaggio.html.twig', array(
            'form' => $form->createView(),
	    'equipaggio' => $equipaggio,
	    ));
    }

    /**
      * @Route("/admin/modifica/mezzo/{id}", name="adminmodificamezzo")
      */
    public function modificaMezzo(Request $request, LoggerInterface $logger, $id=null)
    {
        $logger->info("modifica mezzo");

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
	$form = $form->add('altro', TextType::class, array(
    	      'required'   => false,
	      ));
	$form = $form->add('save', SubmitType::class, array('label' => 'SALVA'));
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
      * @Route("/admin/cancella/persona/{id}", name="admincancellapersona")
      */
    public function cancellaPersona(Request $request, LoggerInterface $logger, $id=null)
    {
        $logger->info("cancella persona");
        $persona = $this->getDoctrine()
                ->getRepository(Persona::class)
                ->find($id);
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($persona);
        $em->flush();
        return $this->redirectToRoute('mostrapersona');
    }

    /**
      * @Route("/admin/modifica/persona/{id}", name="adminmodificapersona")
      */
    public function modificaPersona(Request $request, LoggerInterface $logger, $id=null)
    {
        $logger->info("modifica persona");

	if (is_null($id)) {
	    // crea un nuova persona
	    $persona = new Persona();
	} else {
            $persona = $this->getDoctrine()
                ->getRepository(Persona::class)
                ->find($id);
        }
	if (is_null($persona)) {
	    // crea un nuova persona
	    $persona = new Persona();	    
	}

	$form = $this->createFormBuilder();
	$form = $form->add('nome', TextType::class);
	$form = $form->add('cognome', TextType::class);
	$form = $form->add('codiceFiscale', TextType::class);
	$form = $form->add('codiceCRI', TextType::class);
	$form = $form->add('altro', TextType::class, array(
    	      'required'   => false,
	      ));
	$form = $form->add('save', SubmitType::class, array('label' => 'SALVA'));
	$form = $form->getForm();
	$form->handleRequest($request);

	if ($form->isSubmitted() && $form->isValid()) {
	    $data = $form->getData();
	    $persona->setNome($data['nome']);
	    $persona->setCognome($data['cognome']);
	    $persona->setCodiceFiscale($data['codiceFiscale']);
	    $persona->setCodiceCRI($data['codiceCRI']);
	    $persona->setAltro($data['altro']);
	    $em = $this->getDoctrine()->getManager();
	    $em->persist($persona);
	    $em->flush();

	    return $this->redirectToRoute('mostrapersona');
	}
        return $this->render('default/adminModificaPersona.html.twig', array(
            'form' => $form->createView(),
	    'persona' => $persona,
	    ));
    }

    function creaNuovointervento() {
        $equi = $this->getUltimoEquipaggio();
        $inte = $this->getUltimoIntervento();

        $intervento = new Intervento();
	$intervento->setIdMezzo($equi->getIdMezzo());
	$intervento->setNumeroTurno($equi->getNumeroTurno());
	$intervento->setTipoServizio($equi->getTipo());
	$intervento->setIdPersonaABCTLista($equi->getIdPersonaABCTLista());
	$intervento->setNumeroIntervento(is_null($inte)?1:$inte->getNumeroIntervento() + 1);
	$intervento->setKmPartenza(is_null($inte)?1:$inte->getKmArrivo());

        // date
	$intervento->setDateLista([new \DateTime('now'), null, null, null, null, null ]);

	return $intervento;
    }

    /**
      * @Route("/modifica/intervento/{id}", name="modificaintervento")
      */
    public function modificaIntervento(Request $request, LoggerInterface $logger, $id=null)
    {
        $logger->info("modifica intervento");

	if (is_null($id)) {
	    $intervento = $this->creaNuovoIntervento();	
	} else {
            $intervento = $this->getDoctrine()
                ->getRepository(Intervento::class)
                ->find($id);		
        }
	if (is_null($intervento)) {
	    $intervento = $this->creaNuovoIntervento();	
	}

	$form = $this->createFormBuilder();
	$form = $form->add('mezzo', ChoiceType::class, array(
	  'expanded' => false,
	  'multiple' => false,
	  'choices' => $this->getListaMezziAsDescId(),
          'data' => $intervento->getIdMezzo(),
	));
	$form = $form->add('kmPartenza', IntegerType::class, array(
          'data' => $intervento->getKmPartenza(),
	));
	$form = $form->add('kmArrivo', IntegerType::class, array(
          'data' => $intervento->getKmArrivo(),
	  'required'    => false,
	));
	$form = $form->add('numeroTurno', IntegerType::class, array(
          'data' => $intervento->getNumeroTurno(),
	));
	$form = $form->add('numeroIntervento', IntegerType::class, array(
          'data' => $intervento->getNumeroIntervento(),
	));
	$form = $form->add('numeroInterventoBis', TextType::class, array(
          'data' => $intervento->getNumeroInterventoBis(),
	  'required'    => false,
	));
	$form = $form->add('tipoServizio', TextType::class, array(
          'data' => $intervento->getTipoServizio(),
	));

// idPersonaABCTLista
        // persone 
	$listaPersoneAsDescId = $this->getListaPersoneAsDescId();
	for ($i=0; $i<4; $i++) {
	    $form = $form->add('persona' . $i, ChoiceType::class, array_merge(array(
	      'expanded' => false,
	      'multiple' => false,
	      'choices' => $listaPersoneAsDescId,
              ), empty($intervento->getIdPersonaABCTLista())?[]:
                array('data' => $intervento->getIdPersonaABCTLista()[$i][0]))
	    );

	    $form = $form->add('autista' . $i, CheckboxType::class, array(
	    	  'data'        => empty($intervento->getIdPersonaABCTLista())?false:$intervento->getIdPersonaABCTLista()[$i][1],
	       	  'required'    => false));
	    $form = $form->add('blsd' . $i, CheckboxType::class, array(
	    	  'data'        => empty($intervento->getIdPersonaABCTLista())?false:$intervento->getIdPersonaABCTLista()[$i][2],
	    	  'required'    => false));
	    $form = $form->add('capoequipaggio' . $i, CheckboxType::class, array(
	    	  'data'        => empty($intervento->getIdPersonaABCTLista())?false:$intervento->getIdPersonaABCTLista()[$i][3],
	    	  'required'    => false));
	    $form = $form->add('tirocinante' . $i, CheckboxType::class, array(
	    	  'data'        => empty($intervento->getIdPersonaABCTLista())?false:$intervento->getIdPersonaABCTLista()[$i][4],
	    	  'required'    => false));

	}

// idPersonaABCTLista

	$form = $form->add('indirizzoInterventoVia', TextType::class, array(
          'data' => $intervento->getIndirizzoInterventoVia(),
	  'required'    => false,
	));

	$form = $form->add('indirizzoInterventoComune', TextType::class, array(
          'data' => $intervento->getIndirizzoInterventoComune(),
	  'required'    => false,
	));

	$form = $form->add('codiceUscita', IntegerType::class, array(
          'data' => $intervento->getCodiceUscita(),
	  'required'    => false,
	));

        // dateLista

//echo("<pre>"); var_dump($intervento->getDateLista()); exit;

	for ($i=0; $i<6; $i++) {
	    $form = $form->add('data' . $i, DateTimeType::class, array(
	    	  'data'        => empty($intervento->getDateLista())?null:(new \DateTime($intervento->getDateLista()[$i]["date"], new \DateTimeZone('Europe/Rome'))),
		  'input'       => 'datetime',
	    	  'required'    => false));
	}

	$form = $form->add('codiceTrasporto', IntegerType::class, array(
          'data' => $intervento->getCodiceTrasporto(),
	  'required'    => false,
	));

	$form = $form->add('psDestinazione', TextType::class, array(
          'data' => $intervento->getPsDestinazione(),
	  'required'    => false,
	));

	$form = $form->add('isAnonimoPaziente', CheckboxType::class, array(
          'data' => $intervento->getIsAnonimoPaziente(),
	  'required'    => false,
	));

	$form = $form->add('cognomePaziente', TextType::class, array(
          'data' => $intervento->getCognomePaziente(),
	  'required'    => false,
	));

	$form = $form->add('nomePaziente', TextType::class, array(
          'data' => $intervento->getNomePaziente(),
	  'required'    => false,
	));

	$form = $form->add('codiceFiscalePaziente', TextType::class, array(
          'data' => $intervento->getCodiceFiscalePaziente(),
	  'required'    => false,
	));

	$form = $form->add('sessoPaziente', TextType::class, array(
          'data' => $intervento->getSessoPaziente(),
	  'required'    => false,
	));

	$form = $form->add('dataNascitaPaziente', TextType::class, array(
          'data' => $intervento->getDataNascitaPaziente(),
	  'required'    => false,
	));

	$form = $form->add('indirizzoViaPaziente', TextType::class, array(
          'data' => $intervento->getIndirizzoViaPaziente(),
	  'required'    => false,
	));

	$form = $form->add('indirizzoComunePaziente', TextType::class, array(
          'data' => $intervento->getIndirizzoComunePaziente(),
	  'required'    => false,
	));

	$form = $form->add('nazionalitaPaziente', TextType::class, array(
          'data' => $intervento->getNazionalitaPaziente(),
	  'required'    => false,
	));

	$form = $form->add('isCompletato', CheckboxType::class, array(
          'data' => $intervento->getIsCompletato(),
	  'required'    => false,
	));

	$form = $form->add('isStampato', CheckboxType::class, array(
          'data' => $intervento->getIsStampato(),
	  'required'    => false,
	));

	$form = $form->add('note', TextType::class, array(
          'data' => $intervento->getNote(),
	  'required'    => false,
	));

	$form = $form->add('save', SubmitType::class, array('label' => 'SALVA'));
	$form = $form->getForm();
	$form->handleRequest($request);

	if ($form->isSubmitted() && $form->isValid()) {
	    $data = $form->getData();
	    $intervento->setIdMezzo($data['mezzo']);
	    $intervento->setKmPartenza($data['kmPartenza']);
	    $intervento->setKmArrivo($data['kmArrivo']);
	    $intervento->setNumeroTurno($data['numeroTurno']);
	    $intervento->setNumeroIntervento($data['numeroIntervento']);
	    $intervento->setNumeroInterventoBis($data['numeroInterventoBis']);
	    $intervento->setTipoServizio($data['tipoServizio']);
	    $intervento->setIndirizzoInterventoVia($data['indirizzoInterventoVia']);
	    $intervento->setIndirizzoInterventoComune($data['indirizzoInterventoComune']);
	    $intervento->setCodiceUscita($data['codiceUscita']);

	    // dateLista
	    $intervento->setDateLista([$data['data0'], $data['data1'], $data['data2'], 
	                               $data['data3'], $data['data4'], $data['data5'] ]);

	    $intervento->setCodiceTrasporto($data['codiceTrasporto']);
	    $intervento->setPsDestinazione($data['psDestinazione']);

	    $intervento->setIdPersonaABCTLista([
	      [$data['persona0'], $data['autista0'], $data['blsd0'], $data['capoequipaggio0'], $data['tirocinante0']],
	      [$data['persona1'], $data['autista1'], $data['blsd1'], $data['capoequipaggio1'], $data['tirocinante1']],
	      [$data['persona2'], $data['autista2'], $data['blsd2'], $data['capoequipaggio2'], $data['tirocinante2']],
	      [$data['persona3'], $data['autista3'], $data['blsd3'], $data['capoequipaggio3'], $data['tirocinante3']],
	    ]);


	    $intervento->setIsAnonimoPaziente($data['isAnonimoPaziente']);
	    $intervento->setCognomePaziente($data['cognomePaziente']);
	    $intervento->setNomePaziente($data['nomePaziente']);
	    $intervento->setCodiceFiscalePaziente($data['codiceFiscalePaziente']);
	    $intervento->setSessoPaziente($data['sessoPaziente']);
	    $intervento->setDataNascitaPaziente($data['dataNascitaPaziente']);
	    $intervento->setIndirizzoViaPaziente($data['indirizzoViaPaziente']);
	    $intervento->setIndirizzoComunePaziente($data['indirizzoComunePaziente']);
	    $intervento->setNazionalitaPaziente($data['nazionalitaPaziente']);
	    $intervento->setIsCompletato($data['isCompletato']);
	    $intervento->setIsStampato($data['isStampato']);
	    $intervento->setNote($data['note']);
	    $em = $this->getDoctrine()->getManager();
	    $em->persist($intervento);
	    $em->flush();

	    return $this->redirectToRoute('homepage');
	}
        return $this->render('default/modificaIntervento.html.twig', array(
            'form' => $form->createView(),
	    'intervento' => $intervento,
	    ));
    }


    /**
      * @Route("/archivia/intervento/{id}", name="archiviaintervento")
      */
    public function archiviaIntervento(Request $request, LoggerInterface $logger, $id)
    {
        $logger->info("archivia intervento");
        $item = $this->getDoctrine()
            ->getRepository(Intervento::class)
            ->find($id);
	if (is_null($item)) {
	    return $this->redirectToRoute('homepage');
	} 
	$item->setIsCompletato(true);
	$em = $this->getDoctrine()->getManager();
	$em->persist($item);
	$em->flush();
	return $this->redirectToRoute('homepage');
    }


    /**
      * @Route("/cancella/intervento/{id}", name="cancellaintervento")
      */
    public function cancellaIntervento(Request $request, LoggerInterface $logger, $id=null)
    {
        $logger->info("cancella intervento");
        $item = $this->getDoctrine()
                ->getRepository(Intervento::class)
                ->find($id);
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($item);
        $em->flush();
        return $this->redirectToRoute('homepage');
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
