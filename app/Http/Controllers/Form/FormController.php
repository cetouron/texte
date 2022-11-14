<?php

namespace App\Http\Controllers\Form;
use App\Http\Controllers\Controller;
use App\Models\Kanban\Task;
use Faker\Core\File;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFormRequest;
use App\Http\Resources\Form\FormResource;


class FormController extends Controller
{
    public function index()
    {
        return view('form.index');
    }

    public function store(StoreFormRequest $request)
    {
        $post = $request->validated();
        auth()->user()->formulaire()->create($post);
        return $post;
    }

    public function isEmail($email)
    {
        $alors = null;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $alors = true;
        }
        else {
            $alors = false;
        }
        return $alors;
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function fichierPHP()
    {

        $jsonString = file_get_contents("https://www.kepler-soft.net/api/v2.2/api-key/148f8d04546c675b58ec1632a29639fef0bf07370cdc47dd4903ef79664cee1320f6f839d19697bbeac5459f93b0ba0a3e2d163d0a586e2fddf9cfc2d65edeb8/vehicles/");
       //$jsonString = file_get_contents(__DIR__."/./fichier json");
          $data = json_decode($jsonString, true);

       $enre = " ";
       //$enre .= "oui";
/**/

        foreach( $data AS $clefd => $vald ) {
           $obj = $vald;
           $enre .= "{ Nouvel enregistrement ";
           if (is_array($obj)) {


               foreach( $obj AS $clefo => $valo ) {
               $enre .= "Nouvelle variable [".$clefo.": ";
               $info = $obj[$clefo];

               if (is_array($info)) {

                   foreach( $info AS $clefi => $vali ) {
                       $enre .= "Nouvelle sous-variable {".$clefi.": ";
                       $sous = $info[$clefi];

                       if (is_array($sous)) {
                           foreach( $sous AS $clefs => $vals ) {
                               $enre .= "NEW VAR [".$clefs.": ";
                               $encore= $sous[$clefs];

                               if (is_array($encore)) {

                                   foreach( $encore AS $clefe => $vale ) {
                                       $enre .= "NEW UN-VAR {".$clefe.": ";
                                       if (is_array($encore[$clefe])) {
                                           $enre .="ENCORE";
                                       }
                                       else
                                       {
                                           if (next($encore)) {
                                               $enre .= "".$vale."end un-var }, ";
                                           }
                                           else
                                           {
                                               $enre .= "".$vale."end un-var }";
                                           }
                                       }
                                   }
                                   if (next($sous)) {
                                       $enre .= "DERNIER end new var ], ";
                                   }
                                   else
                                   {
                                       $enre .= "DERNIER end new var ]";
                                   }
                               }
                               else
                               {
                                   if (next($sous)) {
                                       $enre .= "".$vals."end new var ], ";
                                   }
                                   else
                                   {
                                       $enre .= "".$vals."end new var ]";
                                   }

                               }
                           }
                           if (next($info)) {
                               $enre .= "FIN NEW SOUS-VAR }, ";
                           }
                           else
                           {
                               $enre .= "FIN NEW SOUS-VAR }";
                           }
                       }
                       else {
                           if (next($info)) {
                               $enre .= $vali." FIN NEW SOUS-VAR }, ";
                           }
                           else
                           {
                               $enre .= $vali." FIN NEW SOUS-VAR }";
                           }
                       }
                   }
                   if (next($obj)) {
                       $enre .= "FIN NEW VAR ], ";
                   }
                   else
                   {
                       $enre .= "FIN NEW VAR ]";
                   }
               }
               else {
                   if (next($obj)) {
                       $enre .= $valo." FIN NEW VAR ], ";
                   }
                   else
                   {
                       $enre .= $valo." FIN NEW VAR ]";
                   }
               }
           }
       }
            if (next($data)) {
                $enre .=' FIN DU NOUVEL ENREGISTREMENT }, ';
            }
            else
            {
                $enre .=' FIN DU NOUVEL ENREGISTREMENT }';
            }
       }
        return $enre;
    }

    public function fichierTXT(Request $request)
    {
        $info = $this->validate($request, [
            'file' => 'required',
        ]);

        $jsonString = file_get_contents($info['file']);
        $pieces = array();
        $pieces = preg_split("/[\\r\\t\\n]+/i", $jsonString);

        return $pieces;
    }

    public function ping(Request $pieces)
    {
        $info = $this->validate($pieces, [
            'site' => 'required',
        ]);
        $minipieces = preg_split("/[\s]+/", $info['site']);
        $site = rtrim($minipieces[8], '.conf');
        exec('ping -c1 '.$site, $output, $return_var);
        if ($return_var == 0) {
            $info = array();
            $info = preg_split("/[\s]+/", $output[1]);
            $ip = str_replace(array(':'), '' , $info[3]);
            $info = [$site, $ip];
            return $info;
        }
        else {
            return $info = [$site, 'erreur'];
        }

    }

    public function fichierHttpd(Request $request)
    {
        $info = $this->validate($request, [
            'file' => 'required',
        ]);

        $jsonString = file_get_contents($info['file']);
        preg_match_all('/<VirtualHost (.*?)<\/VirtualHost>/s', $jsonString, $match);
      /*  $pieces = array();
        $pieces = preg_split("/[\\r\\t\\n]+/i", $jsonString); */

        return $match;
    }

    public function pinghttpd(Request $pieces)
    {
        $info = $this->validate($pieces, [
            'site' => 'required',
        ]);
        $minipieces = preg_split("/[\\r\\t\\n]+/i", $info['site']);
        $long = sizeof($minipieces);
        for ($i=0; $i < $long; $i++) {
            if (str_contains($minipieces[$i], 'ServerName')) {
                $site = preg_replace("(ServerName )", "", $minipieces[$i]);
                $site = str_replace(array("#", "'", ";", " "), '', $site);
                break;
            }
        }

        exec('ping -c1 '.$site, $output, $return_var);
        if ($return_var == 0) {
        $info = array();
        $info = preg_split("/[\s]+/", $output[1]);
        $ip = str_replace(array(':'), '' , $info[3]);
        $info = [$site, $ip];
        return $info;
        }
        else {
            return $info = [$site, 'erreur'];
        }
    }

    public function envoieMail(StoreFormRequest $request)
    {
        $post = $request->validated();
        $recap = $this->isValid($post["recaptcha_response"], $_SERVER['REMOTE_ADDR']);
        //Si aucun champs du formulaire n'est vide
        if (!empty($post["description"]) && !empty($post["email"]) && !empty($post["objet"]) && !empty($post["nom"]) && $recap!=false) {
            //Si email valide
            $alors = null;
            if (filter_var($post["email"], FILTER_VALIDATE_EMAIL)) {
                $alors = true;
            }
            else {
                $alors = false;
            }

            if ($alors) {

//information recu par mail mais aussi pour répondre avec l'adresse
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'From:' . $post["nom"] . ' <' . $post["email"] . '>' . "\r\n" .
                    'Reply-To:' . $post["email"] . "\r\n";
                //Envoie du mail
                $retour = mail('cedric.touron@univ-lyon2.fr', $post["objet"], $post["description"], $headers);
                if ($retour) {
                    return 'Envoyé';
                }


            } else {
                //Mail invalide
                return 'mail invalide';
            }
        }
        else
        {
            return $post;
        }

    }

    function isValid($code, $ip = null)
    {
        if (empty($code)) {
            return false; // Si aucun code n'est entré, on ne cherche pas plus loin
        }
        $params = [
            'secret'    => CLEF_SECRETE,
            'response'  => $code
        ];
        if( $ip ){
            $params['remoteip'] = $ip;
        }
        $url = "https://www.google.com/recaptcha/api/siteverify?" . http_build_query($params);
        if (function_exists('curl_version')) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Evite les problèmes, si le ser
            $response = curl_exec($curl);
        } else {
            // Si curl n'est pas dispo, un bon vieux file_get_contents
            $response = file_get_contents($url);
        }

        if (empty($response) || is_null($response)) {
            return false;
        }

        $json = json_decode($response);
        return $json->success;
    }

    function facebook()
    {
        $json = json_decode(curl_get_file_contents('https://graph.facebook.com/105378905143856/feed?access_token=EAAHfsysUzroBAGxB2Gv2YMAac0yg3wI4jdbopGZCkSYrFmCZByvD7ZAHcjjZAn6LkKQPkrdiHAgzSZABi59ZBrMHOjL0qgH8eCEE8TQ8oyf7rGOv1ZCZBnvHMeELNZCAfAWncTiY9m6ZC3qaYkSVlf3QRpfBhlPeMsqQQ1jGFPN2ZAl7U1DWAp6nhyYTfFHBnkDfJQZD&limit=5&since=' . date('now')));
        foreach ($json->data as $item) {
            if ($item->message != "") {
                $days = abs(floor((strtotime(date('Y-m-dTH:i:s+0000')) - strtotime($item->created_time)) / (60 * 60 * 24)));
                //echo "<a href='http://www.facebook.com/".$item->from->id."' rel='nofollow' target='_blank'>".utf8_decode($item->from->name)."</a> : ";
                echo "@ " . utf8_decode($item->from->name) . " : ";
                echo htmlentities(utf8_decode(substr($item->message, 0, 100))) . "... <small>(<a href='" . $item->actions[0]->link . "' target='_blank'>il y a " . $days . " jour(s)</a>)</small><br />";
            }
        }
    }
}

