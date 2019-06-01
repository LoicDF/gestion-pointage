<?php
namespace App\Repository;
use App\Demande;
use App\User;
use Illuminate\Support\Request;
use Illuminate\Support\Response;
use Illuminate\Support\Facades\DB;
//use App\Entreprise;

class DemandeRepository {

   public function __construct()
    {
  
    }

      public function getAllDemande(){
      //     //$entreprise = Entreprise ::find(1);
      //     $demandes = Demande::paginate(10);
      // //  $demandes = DB:: table('demandes');
      //   return $demandes;
        $id_entrep=5;
        $demandes= Demande::whereHas('user', function($q) use ($id_entrep)
        {
           $q->whereHas('service', function($q) use ($id_entrep)
           {
               $q->where("entreprise_id", $id_entrep);   
           });
        })->paginate(10);
        return $demandes;
    }

       //Fonction qui permet d'afficher une demande
       public function showDemande($id){
           $demandes = Demande::where('id',$id)->first();
           $user = User ::find($demandes->user_id);
           return $demandes;


       }
       //Methode d'envoi du formulaire
       public function createDemande(Demande $demandes,  $user_id){
        //    $this->validate($request, [
        //        'dateDebut' => 'required',
        //        'dateFin' => 'required',
        //        'status' => 'required',
        //        'typeDemande' => 'required',
        //        'motif' => 'required',

        //    ]);

        //   $demandes = new Demande();
        //     //'id', 'users_id', 'dateDebut', 'dateFin', 'statut','typeDemande', 'motif'
        //    $demandes->dateDebut = $request->request->all();
        //    $demandes>save();

        //    //return redirect()->route()


        //    $demandes->dateDebut = $request['dateDebut'];
        //    $demandes->dateFin = $request['dateFin'];
        //   // $demandes->dateDebut = $inputs['status'];
        //    $demandes->typeDemande = $request['typeDemande'];
        //    $demandes->motif = $request['motif'];
          $demandes->save();
        //  //  return $demandes;
       }

       public function saveDemande(Demande $demandes){
        // $this->validate($inputs, [
        //     'dateDebut' => 'required',
        //     'dateFin' => 'required',
        //     'status' => 'required',
        //     'typeDemande' => 'required',
        //     'motif' => 'required',

        // ]);
           return $this->demandes->save();
       }

       // demande approuver
       public function demandeApprouve(){
        $id_entrep=5;
        $demandes= Demande::where('status', '=', 1)->
        whereHas('user', function($q) use ($id_entrep)
        {
           $q->whereHas('service', function($q) use ($id_entrep)
           {
               $q->where("entreprise_id", $id_entrep);   
           });
        })->paginate(10);
        return $demandes;

       }
       //demande refuser

       public function demandeRefuser(){
        $id_entrep=5;
        $demandes= Demande::where('status', '=', -1)->
        whereHas('user', function($q) use ($id_entrep)
        {
           $q->whereHas('service', function($q) use ($id_entrep)
           {
               $q->where("entreprise_id", $id_entrep);   
           });
        })->paginate(10);
        return $demandes;
       }
       //demande en attente
       public function demandeEnAttente(){
        $id_entrep=5;
        $demandes= Demande::where('status', '=', 0)->
        whereHas('user', function($q) use ($id_entrep)
        {
           $q->whereHas('service', function($q) use ($id_entrep)
           {
               $q->where("entreprise_id", $id_entrep);   
           });
        })->paginate(10);
        return $demandes;
       }

       //Fonction qui permet d'approuver une demande
       public function approuverUneDemande($id){
         $demande = Demande::find($id);
          if($demande->status == 0 ){
                $demande->status = 1;
          }

         $demande->save();
         return $demande;

       }

       //Refuser une Demande
       public function refuserUneDemande($id){
        $demande = Demande::find($id);
        $user = User::find($id);
        if($demande->status == 0 ){
              $demande->status = -1;
        }

        return $demande->save($demande);

       }

}
