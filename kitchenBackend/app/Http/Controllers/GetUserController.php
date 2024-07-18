<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetUserController extends Controller
{
    //fontion qui recupère les utilisateurs de la table user avec user_type != 1
    public function getUser(Request $request)
    {
        try
        {
            $data_users = DB::table('user')
            ->where('user_type', '!=', 1)
            ->get();

            $users = array();
            foreach($data_users as $data_user)
            {
                $user = array(
                    'id' => $data_user->id_user,
                    'name' => $data_user->name_user,
                    'firstname' => $data_user->prenom,
                    'email' => $data_user->email,
                    'type_user' => $data_user->user_type
                );
                array_push($users, $user);
            }

            return response()->json([
                'message' => 'Liste des utilisateurs',
                'response' => 'true',
                'users' => $users
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'message' => 'Erreur lors de la récupération des utilisateurs',
                'response' => 'false',
                'error' => $e->getMessage()
            ]);
        }
    }
}
