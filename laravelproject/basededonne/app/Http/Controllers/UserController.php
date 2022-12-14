<?php

namespace App\Http\Controllers;
use Stripe\Stripe;
use App\Models\User;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

use Stripe\Checkout\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

  public function ressetPassword(){

   

  }

    public function store(Request $request)
    {

    //    cretation d'un utilisateur

        $request->validate([
    
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required',
            // , Password::min(8)->numbers(), Password::min(8)->symbols(), Password::min(8)->mixedCase(),Password::min(8)->letters()]
            // un mot de passe de minimum 8 caractères et comportant une lettre, un chiffre et un symbole. 
      
        ]); 
        


         $user=User::create([
                    
            'firstname'=>$request->firstname,          
            'lastname'=>$request->lastname,          
            'email'=> $request->email,          
            'password' =>Hash::make($request->password),
            // Hash::make($request->password),
            // Hash::make($request->password)

         ]);

        // creation compte stripe
         $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
          \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
          $customer = $stripe->customers->create([
            'email' => $request->email,          
            'description' => 'Premier fumeur motivé de la tête aux pieds',
                        
          ]);
          $intent=$stripe->setupIntents->create([
            'customer'=>$customer['id'],
          ]);
          $user= User::findOrFail($user['id']);
          $user->stripe_id=$customer['id'];
          $user->save();

          //a mettre dans la table user les deux $ stocker en bdd et recuperer en vue
      //$client_stripe_id=$customer['id']
      //$client_stripe_secret=$intent['client_secret']
          $session = Session::create([
            'payment_method_types' => ['card'],
            'customer' => $customer['id'],
            // "payment_method" => $stripe['setup_intent'],
            'mode' => 'setup',
            
            'success_url' => 'http://127.0.0.1:5173/',
            'cancel_url' => 'http://127.0.0.1:5173/profil',//PAGE DE PAIEMENT REFUSE
          ]);
         
          //retenir la payment method pour les debits

          //a mettre dans le controlleur du projet
          // $stripe->paymentIntents->create([
          //   'amount' => 2000,
          //   'currency' => 'eur',
          //   'payment_method_types' => ['card'],
          //   'customer' => $user->client_stripe_id,
          //   ['payment_method' => 'pm_card_visa'],
          // ]);
          // $stripe->paymentIntents->confirm(
          //   'pi_3MGSafGg161a08f00TAntVgt',
          //   ['payment_method' => 'pm_card_visa']
          // );

          

      

          // $stripe->paymentIntents->update(
          //   'pi_1JKS2Y2VYugoKSBzNHPFBNj9',
          //  );
        //   http://127.0.0.1:8000/clients/'. $user->id .'/success?session_id={CHECKOUT_SESSION_ID}
          $url = $session->url;
          return response()->json(['url' => $url]);
    } 

    public function edit(){

      //recuperation de donner d'un utilisateur
        $user= User::findOrFail(Auth::user()->id);

        return response()->json(['message'=>'user afficher','user'=>$user],200);

      

    }

    public function update(Request $request, $id)
    {

      //modfication des donner d'un utilisateur
        $request->validate([
           
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required',
            // , Password::min(8)->numbers(), Password::min(8)->symbols(), Password::min(8)->mixedCase(),Password::min(8)->letters()]
            // un mot de passe de minimum 8 caractères et comportant une lettre, un chiffre et un symbole. 
            
        ]); 

        $user=([
            // 'role'=>$request->role,           
            'firstname'=>$request->firstname,          
            'lastname'=>$request->lastname,          
            'email'=>$request->email,          
            'password' =>$request->password,
            // Hash::make($request->password)

         ]);
        
        $userModify= User::findOrFail($id);
      
        $userModify-> firstname =$request->firstname;
        $userModify-> lastname =$request->lastname;
        $userModify-> email =$request->email;
        $userModify-> password =$request->password;
        $userModify->save();




        return response()->json(['message'=>'user modifier','user'=>$user],201);

    }
    

    //
}
