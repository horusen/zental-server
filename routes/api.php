<?php

use App\Http\Controllers\AdresseController;
use App\Http\Controllers\AmbassadeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BureauController;
use App\Http\Controllers\ChargerComController;
use App\Http\Controllers\CitoyenController;
use App\Http\Controllers\ConjointController;
use App\Http\Controllers\ConsulatController;
use App\Http\Controllers\ContactUserController;
use App\Http\Controllers\DemandeAdhesionController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\DiplomatieController;
use App\Http\Controllers\DiplomeController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\DomaineController;
use App\Http\Controllers\DomaineInstitutionController;
use App\Http\Controllers\EmploieController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\EvenementCalendrierPaysController;
use App\Http\Controllers\FonctionController;
use App\Http\Controllers\GroupeController;
use App\Http\Controllers\IciMonPaysController;
use App\Http\Controllers\InscriptionConsulaireController;
use App\Http\Controllers\LiaisonController;
use App\Http\Controllers\MembreCabinetMinistreController;
use App\Http\Controllers\MembreGroupeController;
use App\Http\Controllers\MinistereController;
use App\Http\Controllers\MinistreController;
use App\Http\Controllers\MinistreGouvernementController;
use App\Http\Controllers\NiveauController;
use App\Http\Controllers\PasseFrontiereController;
use App\Http\Controllers\PasserelleController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\PieceConsulaireController;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\PresidentController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\RelatedToUserController;
use App\Http\Controllers\RelationFamilialeController;
use App\Http\Controllers\RelationInterpersonnelleController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SituationMatrimonialController;
use App\Http\Controllers\TypeContactController;
use App\Http\Controllers\TypeContratController;
use App\Http\Controllers\TypePasserelleController;
use App\Http\Controllers\TypePieceConsulaireController;
use App\Http\Controllers\TypeRelationController;
use App\Http\Controllers\TypeRelationFamilialeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VilleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('signup', [AuthController::class, 'signup']);

    Route::post('login', [AuthController::class, 'login']);
    Route::get('user', [AuthController::class, 'getUser']);
    Route::get('logout', [AuthController::class, 'logout']);
});




// Email verification
Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
Route::get('user/{user}/email/resend', 'VerificationController@resend')->name('verification.resend');


// Liste des pays
Route::get('pays/all', [PaysController::class, 'getAll']);



// Ville
Route::get('pays/{pays}/villes', [VilleController::class, 'getByPays']);
Route::get('villes/all', [VilleController::class, 'getAll']);




Route::middleware(['auth:api', 'verified'])->group(function () {
    Route::post('auth/edit', [AuthController::class, 'edit']);

    Route::post('users', [AuthController::class, 'addUser']);
    Route::get('users/all', [UserController::class, 'getAll']);
    Route::put('users/{user}', [AuthController::class, 'update']);
    Route::get('users/{user}', [UserController::class, 'show']);
    Route::get('users/{user}/verify', [AuthController::class, 'verifyConfirmationToken']);


    // Relation familiale
    Route::get('users/{user}/relations-familiales/{type_relation_familiale}', [RelationFamilialeController::class, 'getByUserAndByType']);
    Route::get('users/{user}/relations-familiales/{type_relation_familiale}/list', [RelationFamilialeController::class, 'getByUserAndByTypeList']);

    Route::apiResource('relations-familiales', 'RelationFamilialeController');


    // Situation matrimonial
    Route::get('situations-matrimoniales/all', [SituationMatrimonialController::class, 'getAll']);
    Route::apiResource('situations-matrimoniales', 'SituationMatrimonialController');

    // Type relation familiale
    Route::get('relations-familiales/types/all', [TypeRelationFamilialeController::class, 'getAll']);


    Route::get('users/{user}/pieces-consulaires/{type}',  [PieceConsulaireController::class, 'getByUserAndType']);
    Route::apiResource('pieces-consulaires', 'PieceConsulaireController');


    // Type piece consulaire
    Route::get('types-pieces-consulaires/all', [TypePieceConsulaireController::class, 'getAll']);

    // Type contact
    Route::get('contacts/types/all', [TypeContactController::class, 'getAll']);


    // Type de contrat
    Route::get('type-contrats/all', [TypeContratController::class, 'getAll']);

    // Contact usr
    Route::get('users/{user}/contacts', [ContactUserController::class, 'getByUser']);
    Route::get('users/{user}/contacts/urgents', [ContactUserController::class, 'getContactUrgentByUser']);
    Route::apiResource('contacts/users', 'ContactUserController');

    // Conjoint
    Route::get('users/{user}/conjoints', [ConjointController::class, 'getByUser']);
    Route::get('conjoints/describe', [ConjointController::class, 'describe']);
    Route::apiResource('conjoints', 'ConjointController');


    // Diplome
    Route::get('users/{user}/diplomes', [DiplomeController::class, 'getByUser']);
    Route::apiResource('diplomes', 'DiplomeController');


    // Niveau
    Route::get('niveaux/all', [NiveauController::class, 'getAll']);
    Route::apiResource('niveaux', 'NiveauController');


    // Emploie
    Route::get('users/{user}/emploies', [EmploieController::class, 'getByUser']);
    Route::apiResource('emploies', 'EmploieController');


    // Type relation interpersonnelle
    Route::get('relations/types/all', [TypeRelationController::class, 'getAll']);

    // Relation interpersonnelle
    Route::get('users/{user}/relations/personnes', [RelationInterpersonnelleController::class, 'getByUser']);


    Route::apiResource('relations/personnes', 'RelationInterpersonnelleController');


    // Relation personne institution
    Route::apiResource('relations/institutions', 'RelationPersonneInstitutionController');


    // Ministere
    Route::get('ministeres/current-user', [MinistereController::class, 'getByCurrentUser']);
    Route::get('ministeres/describe', [MinistereController::class, 'describe']);
    Route::get('ministeres/all', [MinistereController::class, 'getAllData']);
    Route::patch('ministeres/{ministere}', [MinistereController::class, 'patch']);
    Route::apiResource('ministeres', 'MinistereController');


    // Membre Cabinet ministre
    Route::get('ministres/{ministre}/membre-cabinet-ministre', [MembreCabinetMinistreController::class, 'getByMinistre']);
    Route::get('ministres/{ministre}/membre-cabinet-ministre/not', [MembreCabinetMinistreController::class, 'getNonMembresCabinet']);
    Route::apiResource('membre-cabinets', 'EmployeController');

    // Ministres
    Route::get('ministeres/{ministere}/ministres/actuel', [ResponsableController::class, 'getActuelMinistre']);
    Route::get('ministeres/{ministere}/ministres/anciens', [ResponsableController::class, 'getAnciensMinistres']);
    Route::get('ambassades/{ambassade}/ambassadeurs/actuel', [ResponsableController::class, 'getActuelAmbassadeur']);
    Route::get('ambassades/{ambassade}/ambassadeurs/anciens', [ResponsableController::class, 'getAnciensAmbassadeurs']);
    Route::get('consulats/{consulat}/consules/actuel', [ResponsableController::class, 'getActuelConsule']);
    Route::get('consulats/{consulat}/consules/anciens', [ResponsableController::class, 'getAnciensConsules']);
    Route::get('ministres/{ministre}', [MinistreController::class, 'show']);
    // Route::get('ministres/describe', [MinistreController::class, 'describe']);
    // Route::apiResource('ministres', 'MinistreController');


    // Addresse
    Route::get('adresses/describe', [AdresseController::class, 'describe']);
    Route::get('users/{user}/adresses', [AdresseController::class, 'getByUser']);
    Route::get('ministeres/{ministere}/adresses', [AdresseController::class, 'getByMinistere']);
    Route::get('ambassades/{ambassade}/adresses', [AdresseController::class, 'getByAmbassade']);
    Route::get('consulats/{consulat}/adresses', [AdresseController::class, 'getByConsulat']);
    Route::get('bureaux/{bureau}/adresses', [AdresseController::class, 'getByBureau']);
    Route::apiResource('adresses', 'AdresseController');


    // President
    Route::get('pays/{pays}/president', [PresidentController::class, 'getByPays']);
    Route::post('presidents', [PresidentController::class, 'store']);
    Route::delete('presidents/{id}', [PresidentController::class, 'destroy']);
    Route::put('presidents/{id}', [PresidentController::class, 'update']);


    Route::apiResource('calendrier/evenements', 'EvenementCalendrierPaysController')->only(['store', 'update', 'delete']);
    Route::get('pays/{pays}/calendrier/evenements', [EvenementCalendrierPaysController::class, 'getByPays']);



    Route::get('pays/{pays}/gouvernement/ministres', [MinistreGouvernementController::class, 'getByPays']);
    Route::post('gouvernement/ministres', [MinistreGouvernementController::class, 'store']);
    Route::delete('gouvernement/ministres/{id}', [MinistreGouvernementController::class, 'destroy']);
    Route::put('gouvernement/ministres/{id}', [MinistreGouvernementController::class, 'update']);



    // Diplomatie
    Route::get('diplomaties/{pays}', [DiplomatieController::class, 'show']);
    Route::get('pays/{pays}/diplomaties', [DiplomatieController::class, 'getByPays']);
    Route::get('pays/{pays}/diplomaties/ailleurs', [DiplomatieController::class, 'getAilleursByPays']);


    // Fonction
    Route::get('fonctions/all', [FonctionController::class, 'getAll']);
    Route::get('ministeres/{ministere}/fonctions', [FonctionController::class, 'getByMinistere']);
    Route::get('services/{service}/fonctions', [FonctionController::class, 'getByService']);
    Route::get('consulats/{consulat}/fonctions', [FonctionController::class, 'getByConsulat']);
    Route::get('ambassades/{ambassade}/fonctions', [FonctionController::class, 'getByAmbassade']);
    Route::get('bureaux/{bureau}/fonctions', [FonctionController::class, 'getByBureau']);
    Route::apiResource('fonctions', 'FonctionController');


    // Departement
    Route::get('ministeres/{ministere}/departements', [DepartementController::class, 'getByMinistere']);
    Route::get('ambassades/{ambassade}/departements', [DepartementController::class, 'getByAmbassade']);
    Route::get('consulats/{consulat}/departements', [DepartementController::class, 'getByConsulat']);
    Route::get('bureaux/{bureau}/departements', [DepartementController::class, 'getByBureau']);
    Route::get('domaines/{domaine}/departements', [DepartementController::class, 'getByDomaine']);
    Route::apiResource('departements', 'DepartementController');


    // Inscription consulaire
    Route::get('ambassades/{ambassade}/inscriptions-consulaires', [InscriptionConsulaireController::class, 'getByAmbassade']);
    Route::get('consulats/{consulat}/inscriptions-consulaires', [InscriptionConsulaireController::class, 'getByConsulat']);
    Route::get('liaisons/{liaison}/inscriptions-consulaires', [InscriptionConsulaireController::class, 'getByLiaison']);
    Route::get('inscriptions-consulaires/eligibilites/{user}', [InscriptionConsulaireController::class, 'checkEligibility']);
    Route::get('inscriptions-consulaires/{inscription_consulaire}', [InscriptionConsulaireController::class, 'show']);
    Route::post('inscriptions-consulaires/etat/edit', [InscriptionConsulaireController::class,  'changerEtat']);
    Route::post('inscriptions-consulaires', [InscriptionConsulaireController::class,  'store']);


    // Groupe
    Route::get('users/{user}/groupes', [GroupeController::class, 'getByUserAsMembre']);
    Route::get('users/{user}/groupes/not', [GroupeController::class, 'getByUserAsNonMembre']);
    Route::apiResource('groupes', 'GroupeController')->only(['show', 'store', 'update', 'destroy']);

    // Membre groupe
    Route::get('groupes/{groupe}/membres', [MembreGroupeController::class, 'getByGroupe']);
    Route::apiResource('groupes/membres', 'MembreGroupeController')->only(['store', 'update', 'destroy']);


    // Demande adhesion groupe
    Route::get('groupes/{groupe}/demandes', [DemandeAdhesionController::class, 'getByGroupe']);
    Route::post('groupes/demandes', [DemandeAdhesionController::class, 'store']);
    Route::put('groupes/demandes/{demande}/valider', [DemandeAdhesionController::class, 'valider']);
    Route::delete('groupes/demandes/{demande}/annuler', [DemandeAdhesionController::class, 'annuler']);


    // Citoyen
    Route::get('ambassades/{ambassade}/citoyens', [CitoyenController::class, 'getByAmbassade']);
    Route::get('consulats/{consulat}/citoyens', [CitoyenController::class, 'getByConsulat']);
    Route::get('liaisons/{liaison}/citoyens', [CitoyenController::class, 'getByLiaison']);
    Route::get('pays/{pays}/citoyens', [CitoyenController::class, 'getByPays']);


    // Domaine Instititution
    Route::get('ministeres/{ministere}/domaines/institutions', [DomaineInstitutionController::class, 'getByMinistere']);
    Route::get('bureaux/{bureau}/domaines/institutions', [DomaineInstitutionController::class, 'getByBureau']);
    Route::get('ambassades/{ambassade}/domaines/institutions', [DomaineInstitutionController::class, 'getByAmbassade']);
    Route::get('consulats/{consulat}/domaines/institutions', [DomaineInstitutionController::class, 'getByConsulat']);
    Route::apiResource('domaines/institutions', 'DomaineInstitutionController');

    // Discussion
    Route::get('discussions/{discussion}', [DiscussionController::class, 'show']);
    Route::get('{type}/{id}/discussions/latest', [DiscussionController::class, 'getDernieresDiscussions']);
    Route::post('discussions', [DiscussionController::class, 'getDiscussion']);



    // Reaction
    Route::apiResource('reactions', 'ReactionController')->only(['store', 'destroy']);
    Route::get('discussions/{discussion}/reactions', [ReactionController::class, 'getByDiscussion']);



    // Domaine
    Route::get('domaines/all', [DomaineController::class, 'getAll']);

    // Liaison
    Route::get('ministeres/{ministere}/liaisons', [LiaisonController::class, 'getByMinistere']);
    Route::get('diplomaties/{pays}/liaisons', [LiaisonController::class, 'getByHasBureauxByPays']);
    Route::get('ambassades/{ambassade}/liaisons', [LiaisonController::class, 'getByAmbassade']);
    Route::get('consulats/{consulat}/liaisons', [LiaisonController::class, 'getByConsulat']);
    Route::get('ministeres/{ministere}/liaisons/non-affecte', [LiaisonController::class, 'getNonAffecteByMinistere']);
    Route::get('ambassades/{ambassade}/liaisons/non-affecte', [LiaisonController::class, 'getNonAffecteByAmbassade']);
    Route::get('consulats/{consulat}/liaisons/non-affecte', [LiaisonController::class, 'getNonAffecteByConsulat']);
    Route::post('liaisons/affecter', [LiaisonController::class, 'affecter']);
    Route::get('liaisons/all', [LiaisonController::class, 'getAllData']);
    Route::apiResource('liaisons', 'LiaisonController');

    // Passerelle
    Route::get('pays/{pays}/passerelles', [PasserelleController::class, 'getByPays']);
    Route::get('pays/{pays}/passerelles/non-affecte', [PasserelleController::class, 'getNonAffecteByPays']);

    Route::post('passerelles/affecter', [PasserelleController::class, 'affecter']);
    Route::get('passerelles/all', [PasserelleController::class, 'getAllData']);
    Route::apiResource('passerelles', 'PasserelleController');


    // Bureau
    Route::get('users/{user}/bureaux', [BureauController::class, 'getByUser']);
    Route::get('ministeres/{ministere}/bureaux', [BureauController::class, 'getByMinistere']);
    Route::get('ambassades/{ambassade}/bureaux', [BureauController::class, 'getByAmbassade']);
    Route::get('consulats/{consulat}/bureaux', [BureauController::class, 'getByConsulat']);
    Route::get('ministeres/{ministere}/bureaux/non-affecte', [BureauController::class, 'getNonAffecteByMinistere']);
    Route::get('ambassades/{ambassade}/bureaux/non-affecte', [BureauController::class, 'getNonAffecteByAmbassade']);
    Route::get('consulats/{consulat}/bureaux/non-affecte', [BureauController::class, 'getNonAffecteByConsulat']);
    Route::post('bureaux/affecter', [BureauController::class, 'affecter']);
    Route::get('bureaux/all', [BureauController::class, 'getAllData']);
    Route::apiResource('bureaux', 'BureauController');


    // Related to user
    Route::get('groupes/{groupe}/non-membres', [RelatedToUserController::class, 'getNonMembresGroupe']);


    // EMploye
    Route::get('ministeres/{ministere}/membre-cabinets', [EmployeController::class, 'getByMinistere']);
    Route::get('ambassades/{ambassade}/membre-cabinets', [EmployeController::class, 'getByAmbassade']);
    Route::get('ambassades/{ambassade}/employes', [EmployeController::class, 'getByAmbassade']);
    Route::get('consulats/{consulat}/membre-cabinets', [EmployeController::class, 'getByConsulat']);
    Route::get('consulats/{consulat}/employes', [EmployeController::class, 'getByConsulat']);
    Route::get('departements/{departement}/employes', [EmployeController::class, 'getByDepartement']);
    Route::get('ministeres/{ministere}/employes', [EmployeController::class, 'getByMinistere']);
    Route::get('services/{service}/employes', [EmployeController::class, 'getByService']);
    Route::get('domaines/{domaine}/employes', [EmployeController::class, 'getByDomaine']);
    Route::get('postes/{poste}/employes', [EmployeController::class, 'getByPoste']);
    Route::get('fonctions/{fonction}/employes', [EmployeController::class, 'getByFonction']);
    Route::get('bureaux/{bureau}/employes', [EmployeController::class, 'getByBureau']);


    Route::apiResource('employes', 'EmployeController');


    // Charger de communication
    Route::get('services/{service}/charger-com', [ChargerComController::class, 'getByService']);
    Route::put('services/charger-com/{id}', [ChargerComController::class, 'update']);


    // Consulat
    Route::get('ministeres/{ministere}/consulats', [ConsulatController::class, 'getByMinistere']);
    Route::get('ambassades/{ambassade}/consulats', [ConsulatController::class, 'getByAmbassade']);
    Route::get('pays/{pays}/consulats', [ConsulatController::class, 'getByPays']);
    Route::get('users/{user}/consulats', [ConsulatController::class, 'getByUser']);
    Route::get('consulats/all', [ConsulatController::class, 'getAllData']);
    Route::apiResource('consulats', 'ConsulatController');

    // TypePasserelle
    Route::get('type-passerelles/all', [TypePasserelleController::class, 'getAll']);
    Route::apiResource('type-passerelles', 'TypePasserelleController');

    // PasseFrontiere
    Route::get('passe-frontieres/all', [PasseFrontiereController::class, 'getAll']);
    Route::apiResource('passe-frontieres', 'PasseFrontiereController');

    // Poste
    Route::get('ministeres/{ministere}/postes', [PosteController::class, 'getByMinistere']);
    Route::get('services/{service}/postes', [PosteController::class, 'getByService']);
    Route::get('ambassades/{ambassade}/postes', [PosteController::class, 'getByAmbassade']);
    Route::get('consulats/{consulat}/postes', [PosteController::class, 'getByConsulat']);
    Route::get('bureaux/{bureau}/postes', [PosteController::class, 'getByBureau']);
    Route::get('postes/all', [PosteController::class, 'getAll']);
    Route::apiResource('postes', 'PosteController');





    // Ambassade
    Route::get('ministeres/{ministere}/ambassades', [AmbassadeController::class, 'getByMinistere']);
    Route::get('pays/{pays}/ambassades', [AmbassadeController::class, 'getByPays']);
    Route::get('users/{user}/ambassades', [AmbassadeController::class, 'getByUser']);
    Route::get('ambassades/all', [AmbassadeController::class, 'getAllData']);
    Route::apiResource('ambassades', 'AmbassadeController');


    // Ici mon pays
    Route::post('ici-mon-pays', [IciMonPaysController::class, 'store']);
    Route::put('ici-mon-pays', [IciMonPaysController::class, 'updateElement']);
    Route::get('pays/{pays}/ici-mon-pays/{element}', [IciMonPaysController::class, 'showElement']);


    // Pays


    // Responsable
    Route::post('responsables', [ResponsableController::class, 'store']);
    Route::put('responsables/{id}', [ResponsableController::class, 'update']);
    Route::get('responsables/{responsable}', [ResponsableController::class, 'show']);




    // Service
    Route::get('ministeres/{ministere}/services', [ServiceController::class, 'getByMinistere']);
    Route::get('bureaux/{bureau}/services', [ServiceController::class, 'getByBureau']);
    Route::get('ambassades/{ambassade}/services', [ServiceController::class, 'getByAmbassade']);
    Route::get('consulats/{consulat}/services', [ServiceController::class, 'getByConsulat']);
    Route::get('departements/{departement}/services', [ServiceController::class, 'getByDepartement']);
    Route::get('domaines/{domaine}/services', [ServiceController::class, 'getByDomaine']);

    Route::get('ministeres/{ministere}/services/communication', [ServiceController::class, 'getServiceCommunicationMinistere']);
    Route::get('ambassades/{ambassade}/services/communication', [ServiceController::class, 'getServiceCommunicationAmbassade']);
    Route::get('consulats/{consulat}/services/communication', [ServiceController::class, 'getServiceCommunicationConsulat']);
    Route::get('bureaux/{bureau}/services/communication', [ServiceController::class, 'getServiceCommunicationBureau']);
    Route::put('services/{service}/communication', [ServiceController::class, 'updateServiceCommunication']);

    Route::apiResource('services', 'ServiceController');


    // Users
    Route::get('users/{user}/relations/not', [UserController::class, 'getByNonRelation']);
    Route::get('users/{user}/contacts/not', [UserController::class, 'getByNonContact']);
    Route::get('users/{user}/familles/not', [UserController::class, 'getNonMembresFamilles']);
    Route::get('ministres/{ministre}/users/membres-cabinet/not', [UserController::class, 'getNonMembresCabinetMinistre']);
    Route::get('services/{service}/users/employes/not', [UserController::class, 'getNonEmployesDansService']);
});
