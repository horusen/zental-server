<?php

use App\Http\Controllers\AdresseController;
use App\Http\Controllers\AmbassadeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BureauController;
use App\Http\Controllers\ConjointController;
use App\Http\Controllers\ConsulatController;
use App\Http\Controllers\ContactUserController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\DiplomeController;
use App\Http\Controllers\DomaineController;
use App\Http\Controllers\DomaineInstitutionController;
use App\Http\Controllers\EmploieController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\FonctionController;
use App\Http\Controllers\IciMonPaysController;
use App\Http\Controllers\LiaisonController;
use App\Http\Controllers\MembreCabinetMinistreController;
use App\Http\Controllers\MinistereController;
use App\Http\Controllers\MinistreController;
use App\Http\Controllers\NiveauController;
use App\Http\Controllers\PasseFrontiereController;
use App\Http\Controllers\PasserelleController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\PieceConsulaireController;
use App\Http\Controllers\PosteController;
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
});




// Email verification
Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');



Route::middleware('auth:api')->group(function () {
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
    Route::patch('ministeres/{ministere}', [MinistereController::class, 'patch']);
    Route::apiResource('ministeres', 'MinistereController');


    // Membre Cabinet ministre
    Route::get('ministres/{ministre}/membre-cabinet-ministre', [MembreCabinetMinistreController::class, 'getByMinistre']);
    Route::get('ministres/{ministre}/membre-cabinet-ministre/not', [MembreCabinetMinistreController::class, 'getNonMembresCabinet']);
    Route::apiResource('membre-cabinets', 'EmployeController');

    // Ministres
    Route::get('ministeres/{ministere}/ministres/actuel', [ResponsableController::class, 'getActuelMinistre']);
    Route::get('ministeres/{ministere}/ministres/anciens', [ResponsableController::class, 'getAnciensMinistres']);
    Route::get('amabassades/{amabassade}/ambassadeurs/actuel', [ResponsableController::class, 'getActuelAmbassadeur']);
    Route::get('amabassades/{amabassade}/ambassadeurs/anciens', [ResponsableController::class, 'getAnciensAmbassadeurs']);
    Route::get('consulats/{consulat}/consules/actuel', [ResponsableController::class, 'getActuelConsule']);
    Route::get('consulats/{consulat}/consules/anciens', [ResponsableController::class, 'getAnciensConsules']);
    Route::get('ministres/{ministre}', [MinistreController::class, 'show']);
    // Route::get('ministres/describe', [MinistreController::class, 'describe']);
    // Route::apiResource('ministres', 'MinistreController');


    // Adresse
    Route::get('adresses/describe', [AdresseController::class, 'describe']);
    Route::get('ministeres/{ministere}/adresses', [AdresseController::class, 'getByMinistere']);
    Route::get('ambassades/{ambassade}/adresses', [AdresseController::class, 'getByAmbassade']);
    Route::get('consulats/{consulat}/adresses', [AdresseController::class, 're']);
    Route::apiResource('adresses', 'AdresseController');


    // Fonction
    Route::get('fonctions/all', [FonctionController::class, 'getAll']);
    Route::get('ministeres/{ministere}/fonctions', [FonctionController::class, 'getByMinistere']);
    Route::get('ambassades/{ambassade}/fonctions', [FonctionController::class, 'getByAmbassade']);
    Route::apiResource('fonctions', 'FonctionController');


    // Departement
    Route::get('ministeres/{ministere}/departements', [DepartementController::class, 'getByMinistere']);
    Route::get('ambassades/{ambassade}/departements', [DepartementController::class, 'getByAmbassade']);
    Route::get('domaines/{domaine}/departements', [DepartementController::class, 'getByDomaine']);
    Route::apiResource('departements', 'DepartementController');


    // Domaine Instititution
    Route::get('ministeres/{ministere}/domaines/institutions', [DomaineInstitutionController::class, 'getByMinistere']);
    Route::get('ambassades/{ambassade}/domaines/institutions', [DomaineInstitutionController::class, 'getByAmbassade']);
    Route::apiResource('domaines/institutions', 'DomaineInstitutionController');



    // Domaine
    Route::get('domaines/all', [DomaineController::class, 'getAll']);

    // Liaison
    Route::get('ministeres/{ministere}/liaisons', [LiaisonController::class, 'getByMinistere']);
    Route::get('ambassades/{ambassade}/liaisons', [LiaisonController::class, 'getByAmbassade']);
    Route::post('liaisons/affecter', [LiaisonController::class, 'affecter']);
    Route::apiResource('liaisons', 'LiaisonController');

    // Passerelle
    Route::get('pays/{pays}/passerelles', [PasserelleController::class, 'getByPays']);
    Route::post('passerelles/affecter', [PasserelleController::class, 'affecter']);
    Route::apiResource('passerelles', 'PasserelleController');


    // Bureau
    Route::get('ministeres/{ministere}/bureaux', [BureauController::class, 'getByMinistere']);
    Route::get('ambassades/{ambassade}/bureaux', [BureauController::class, 'getByAmbassade']);
    Route::post('bureaux/affecter', [BureauController::class, 'affecter']);
    Route::apiResource('bureaux', 'BureauController');




    // EMploye
    Route::get('ministeres/{ministere}/membre-cabinets', [EmployeController::class, 'getByMinistere']);
    Route::get('ambassades/{ambassade}/membre-cabinets', [EmployeController::class, 'getByAmbassade']);
    Route::get('consulats/{consulat}/membre-cabinets', [EmployeController::class, 'getByConsulat']);
    Route::get('departements/{departement}/employes', [EmployeController::class, 'getByDepartement']);
    Route::get('ministeres/{ministere}/employes', [EmployeController::class, 'getByMinistere']);
    Route::get('services/{service}/employes', [EmployeController::class, 'getByService']);
    Route::get('domaines/{domaine}/employes', [EmployeController::class, 'getByDomaine']);
    Route::get('postes/{poste}/employes', [EmployeController::class, 'getByPoste']);
    Route::get('fonctions/{fonction}/employes', [EmployeController::class, 'getByFonction']);
    Route::get('bureaux/{bureau}/employes', [EmployeController::class, 'getByBureau']);

    Route::apiResource('employes', 'EmployeController');


    // Consulat
    Route::get('ministeres/{ministere}/consulats', [ConsulatController::class, 'getByMinistere']);
    Route::get('ambassades/{ambassade}/consulats', [ConsulatController::class, 'getByAmbassade']);
    Route::apiResource('consulats', 'ConsulatController');

    // TypePasserelle
    Route::get('type-passerelles/all', [TypePasserelleController::class, 'getAll']);
    Route::apiResource('type-passerelles', 'TypePasserelleController');

    // PasseFrontiere
    Route::get('passe-frontieres/all', [PasseFrontiereController::class, 'getAll']);
    Route::apiResource('passe-frontieres', 'PasseFrontiereController');

    // Poste
    Route::get('ministeres/{ministere}/postes', [PosteController::class, 'getByMinistere']);
    Route::get('ambassades/{ambassade}/postes', [PosteController::class, 'getByAmbassade']);
    Route::get('postes/all', [PosteController::class, 'getAll']);
    Route::apiResource('postes', 'PosteController');





    // Ambassade
    Route::get('ministeres/{ministere}/ambassades', [AmbassadeController::class, 'getByMinistere']);
    Route::apiResource('ambassades', 'AmbassadeController');


    // Ici mon pays
    Route::post('ici-mon-pays', [IciMonPaysController::class, 'store']);
    Route::put('ici-mon-pays', [IciMonPaysController::class, 'updateElement']);
    Route::get('pays/{pays}/ici-mon-pays/{element}', [IciMonPaysController::class, 'showElement']);


    // Pays
    Route::get('pays/all', [PaysController::class, 'getAll']);


    // Responsable
    Route::post('responsables', [ResponsableController::class, 'store']);
    Route::get('responsables/{responsable}', [ResponsableController::class, 'show']);

    // Ville
    Route::get('pays/{pays}/villes', [VilleController::class, 'getByPays']);
    Route::get('villes/all', [VilleController::class, 'getAll']);


    // Service
    Route::get('ministeres/{ministere}/services', [ServiceController::class, 'getByMinistere']);
    Route::get('ambassades/{ambassade}/services', [ServiceController::class, 'getByAmbassade']);
    Route::get('departements/{departement}/services', [ServiceController::class, 'getByDepartement']);
    Route::get('domaines/{domaine}/services', [ServiceController::class, 'getByDomaine']);
    Route::apiResource('services', 'ServiceController');


    // Users
    Route::get('users/{user}/relations/not', [UserController::class, 'getByNonRelation']);
    Route::get('users/{user}/contacts/not', [UserController::class, 'getByNonContact']);
    Route::get('users/{user}/familles/not', [UserController::class, 'getNonMembresFamilles']);
    Route::get('ministres/{ministre}/users/membres-cabinet/not', [UserController::class, 'getNonMembresCabinetMinistre']);
    Route::get('services/{service}/users/employes/not', [UserController::class, 'getNonEmployesDansService']);
});
