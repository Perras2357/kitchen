<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetComponentController extends Controller
{
    public function getComponent(Request $request)
    {
        try
        {
            //requette qui recupère le nom,la description et le prix dans la table component et la position x , y et z dans la table kitchen_component
            $data_components = DB::table('component')
            ->join('kitchen_component', 'component.id_component', '=', 'kitchen_component.id_component')
            ->select('component.*', 'kitchen_component.*')
            ->get();

            $components = array();
            foreach($data_components as $data_component)
            {
                $component = array(
                    'name' => $data_component->name_component,
                    'path' => $data_component->description,
                    'price' => $data_component->price,
                    'position' => array(
                        'x' => $data_component->posittion_X,
                        'y' => $data_component->posittion_Y,
                        'z' => $data_component->posittion_Z
                    )
                );
                array_push($components, $component);
            }

            return response()->json([
                'message' => 'Liste des composants',
                'response' => 'true',
                'components' => $components
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'message' => 'Erreur lors de la récupération des composants',
                'response' => 'false',
                'error' => $e->getMessage()
            ]);
        }
    }
}
