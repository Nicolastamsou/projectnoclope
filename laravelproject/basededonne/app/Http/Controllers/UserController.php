<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function store(Request $request)
    {

    //    cretation d'un utilisateur

        $request->validate([
            'role' => 'required|string|max:255',
            'numbercard' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required',
            // , Password::min(8)->numbers(), Password::min(8)->symbols(), Password::min(8)->mixedCase(),Password::min(8)->letters()]
            // un mot de passe de minimum 8 caractères et comportant une lettre, un chiffre et un symbole. 
      
        ]); 
        

        // $infosuser=[

        //     'role'=>$request->role,           
        //     'numbercard'=>$request->numbercard,          
        //     'firstname'=>$request->firstname,          
        //     'lastname'=>$request->lastname,          
        //     'email'=>$request->email,          
        //     'password' =>$request->password,
        //     // Hash::make($request->password)
        // ];

         $user=User::create([
            'role'=>$request->role,           
            'numbercard'=>$request->numbercard,          
            'firstname'=>$request->firstname,          
            'lastname'=>$request->lastname,          
            'email'=>$request->email,          
            'password' =>Hash::make($request->password),
            // Hash::make($request->password),
            // Hash::make($request->password)

         ]);

        
        return response()->json(['message'=>'user created','user'=>$user],201);
    } 

    public function edit($id){

        $user= User::findOrFail($id);

        return response()->json(['message'=>'user afficher','user'=>$user],201);

        // $listeperso= Personnage::where('user_id', Auth::user()->id)->get();
        
        
        // return view('groupe.edit', [ 'truc' => $truc ], [ 'listeperso' => $listeperso ]) ;

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string|max:255',
            'numbercard' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required',
            // , Password::min(8)->numbers(), Password::min(8)->symbols(), Password::min(8)->mixedCase(),Password::min(8)->letters()]
            // un mot de passe de minimum 8 caractères et comportant une lettre, un chiffre et un symbole. 
            
        ]); 

        $user=([
            'role'=>$request->role,           
            'numbercard'=>$request->numbercard,          
            'firstname'=>$request->firstname,          
            'lastname'=>$request->lastname,          
            'email'=>$request->email,          
            'password' =>$request->password,
            // Hash::make($request->password)

         ]);
        
        $userModify= User::findOrFail($id);
        $userModify-> role =$request->role;
        $userModify-> numbercard =$request->numbercard;
        $userModify-> firstname =$request->firstname;
        $userModify-> lastname =$request->lastname;
        $userModify-> email =$request->email;
        $userModify-> password =$request->password;
        $userModify->save();




        return response()->json(['message'=>'user modifier','user'=>$user],201);

    }
    

    //
}
