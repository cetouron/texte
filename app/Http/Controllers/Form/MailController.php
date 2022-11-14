<?php

namespace App\Http\Controllers\Form;

use App\Models\Avis\Avis;
use App\Models\User;
use App\Models\Form\Form;
use App\Models\Actu\Actu;

use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Mail\MailTest;
use Goutte\Client;
use Symfony\Component\BrowserKit\HttpBrowser;

class MailController extends Controller
{

    public function formtest()
    {
        return view("form.test");
    }


    public function seize()
    {
        return view("form.deuxmileseize");
    }

    public function dixsept()
    {
        return view("form.deuxmiledixsept");
    }

    public function dixhuit()
    {
        return view("form.deuxmiledixhuit");
    }

    public function dixneuf()
    {
        return view("form.deuxmiledixneuf");
    }

    public function vingt()
    {
        return view("form.deuxmilevingt");
    }

    public function vingtun()
    {
        return view("form.deuxmilevingtun");
    }

    public function vingtdeux()
    {
        return view("form.deuxmilevingtdeux");
    }


    public function envoie(Request $request)
    {

            $retour = array();
            $delimiteurs = ' ';
            $tok = strtok($request->text, " ");
            while (strlen(join(" ", $retour)) != strlen($request->text)) {
                array_push($retour, $tok);
                $tok = strtok($delimiteurs);
            }

            $text_sortie = "";
            $phrase = "";
            $nbPhrase = 0;
            foreach ($retour as $mot) {

                if(strlen($phrase." ".$mot) < 24) {
                    $phrase.=" ".$mot;
                }
                else {
                    if($nbPhrase == 3) {
                        $text_sortie .= $phrase."<br><br>";
                        $nbPhrase = 0;
                    }
                    else {
                        $text_sortie .= $phrase."<br>";
                        $nbPhrase++;
                    }
                    $phrase = $mot;
                }
            }

        return view("form.test", compact("text_sortie"));
    }

    // Le formulaire du message
    public function formMessageGoogle()
    {
        // ddd('oui');
        return view("form.index");
    }

    // Envoi du mail aux utilisateurs
    public function sendMessageGoogle(Request $request)
    {

        #1. Validation de la requête
        /*  //VERSION 1 DEPUIS FORMULAIRE
            $post = $this->validate($request, [
                 'nom' => 'required',
                 'email' => 'required|email',
                 'description' => 'required',
                 'file' => 'sometimes'
             ]);

             $emails = array(
                 'nom' => $request->nom,
                 'description' => $request->description,
                 'file' => $request->file
             ); */

        //VERSION INSCRIPTION / RESERVATION
        $post = $this->validate($request, [
            'nom' => 'required',
            'email' => 'required|email',
            'prenom' => 'required',
            'title' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);

        $emails = array(
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'title' => $request->title,
            'end' => $request->end,
            'start' => $request->start,

        );
        return Mail::to($request->email)->send(new MailTest($emails));
        //Actu::search('re vol')->get();
        // return $post;
    }

}
