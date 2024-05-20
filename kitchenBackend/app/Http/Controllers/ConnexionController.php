<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;

class ConnexionController extends Controller
{
    public function connexion(Request $request)
    {
        $login = $request->input('email');
        $password = $request->input('password');

        //retirer les injections sql
        $login = htmlspecialchars($login);
        $password = htmlspecialchars($password);

        if(empty($login) || empty($password))
        {
            return response()->json([
                'message' => 'Veuillez remplir tous les champs',
                'response' => 'false'   
            ]);
        }
        else
        {
            $login = trim($login);
            $password = trim($password);

            $user = UserModel::where('email', $login)->first();

            if ($user) 
            {
                if (password_verify($password, $user->password) == false)
                {
                    return response()->json([
                        'message' => 'Mot de passe incorrect',
                        'response' => 'false'   
                    ]);
                }
                else
                {
                     //on récupère les informations de l'utilisateur qu'on mets dans un tableau
                    $user_info = array(
                        'id_user' => $user->id_user,
                        'name_user' => $user->name_user,
                        'email' => $user->email,
                        'type_user' => $user->type_user
                    );
                    //on récupère le type de user pour rediriger vers la bonne page
                    $type_user = $user->type_user;

                        return response()->json([
                            'message' => 'Connexion réussie',
                            'response' => 'true',
                            'user'=> $user,
                        ]);
                }
            }
            else 
            {
                return response()->json([
                    'message' => 'Email incorrect',
                    'response' => 'false'   
                ]);
            }
        }
    }
}
