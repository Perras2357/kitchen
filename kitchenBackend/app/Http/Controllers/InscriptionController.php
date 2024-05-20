<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;

class InscriptionController extends Controller
{
    //inscription d'un client avec pour user_type = 3 dans la table user
    public function inscription(Request $request)
    {
        try
        {
            $name = $request->input('name');
            $prenom = $request->input('firstName');
            $email = $request->input('email');
            $password = $request->input('password');
            $password_confirm = $request->input('confirmPassword');


            //retirer les injections sql
            $name = htmlspecialchars($name);
            $prenom = htmlspecialchars($prenom);
            $email = htmlspecialchars($email);
            $password = htmlspecialchars($password);
            $password_confirm = htmlspecialchars($password_confirm);

            if(empty($name) || empty($email) || empty($password) || empty($password_confirm))
            {
                return response()->json([
                    'message' => 'Veuillez remplir tous les champs',
                    'response' => 'false',
                    'login' => $name,
                    'prenom' => $prenom,
                    'email' => $email,
                    'password' => $password,
                    'password_confirm' => $password_confirm
                ]);
            }
            else
            {
                $name = trim($name);
                $prenom = trim($prenom);
                $email = trim($email);
                $password = trim($password);
                $password_confirm = trim($password_confirm);

                //on vérifie si le mot de passe est supérieur à 4 caractères
                if(strlen($password) < 4)
                {
                    return response()->json([
                        'message' => 'Le mot de passe doit contenir au moins 4 caractères',
                        'response' => 'false'   
                    ]);
                }
                else
                {
                    if($password != $password_confirm)
                    {
                        return response()->json([
                            'message' => 'Les mots de passe ne correspondent pas',
                            'response' => 'false'   
                        ]);
                    }
                    else
                    {
                        $user = UserModel::where('email', $email)->first();

                        if($user != null)
                        {
                            return response()->json([
                                'message' => 'Email déjà utilisé',
                                'response' => 'false'   
                            ]);
                        }
                        else
                        {
                            $password = password_hash($password, PASSWORD_DEFAULT);

                            $user = new UserModel();
                            $user->name_user = $name;
                            $user->prenom = $prenom;
                            $user->email = $email;
                            $user->password = $password;
                            $user->user_type = 3;
                            // $user->date_create = date('Y-m-d H:i:s');
                            // $user->date_modification = date('Y-m-d H:i:s');
                            $user->save();



                            return response()->json([
                                'message' => 'Inscription réussie',
                                'response' => 'true'   
                            ]);
                        }
                    }

                }

                
            }
        }
        catch(Exception $e)
        {
            return response()->json([
                'message' => 'Erreur lors de l\'inscription',
                'response' => 'false'   
            ]);
        }
    }
}
