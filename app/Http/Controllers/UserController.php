<?php

namespace App\Http\Controllers;

use App\User;
use App\DocumentType;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    /**
     * Almacenar la informacion del Usuario
     *
     * @return view     
     **/
    public function store(Request $request, $return = 'redirect')
    {

        /*
        |---------------------------------------------------------------------------------------
        | Se Obtiene El Tipo De Documento Por El Nombre
        |---------------------------------------------------------------------------------------
        */

        $documentType = DocumentType::where('name', $request->document_type)->first();        

        /*
        |---------------------------------------------------------------------------------------
        | Obtener El Usuario Por El Correo Electronico 
        |---------------------------------------------------------------------------------------
        */

        $user = User::where('email_address', $request->email)->first();        
        
        /*
        |---------------------------------------------------------------------------------------
        | Si El Usuario No Existe, Se Crea Una Nueva Instancia 
        |---------------------------------------------------------------------------------------
        */

        if (!$user) {
            $user = new User;
        }

        /*
        |---------------------------------------------------------------------------------------
        | Se Prepara Los Datos Del Usuario Que Hace La Transaccion Para Almacenarlo En La BD
        |---------------------------------------------------------------------------------------
        */

        $user->document = $request->document;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->last_name = $request->last_name;
        $user->email_address = $request->email;
        $user->city = $request->city;
        $user->province = $request->province;
        $user->country = 'CO';
        
        /*
        |---------------------------------------------------------------------------------------
        | Se Asocia El Tipo De Documento Con El Usuario Y Se Almacena En La BD
        |---------------------------------------------------------------------------------------
        */

        $user->document_type()->associate($documentType);
        $user->save();

        /*
        |---------------------------------------------------------------------------------------
        | Si La Variable $return Es 'usuario' Se Devuelve El Usuario Almacenado, Si es 'reedirect
        | Se Redirecciona A La Pagina Anterior. Esto Es En Caso De Que Se Quiera Almacenar O
        | Actualizar Los Datos Del Usuario Por Fuera Del Formulario De Pago PSE.
        |---------------------------------------------------------------------------------------
        */

        if ($return == 'user') {
            return $user;
        }

        return back();
    }
}
