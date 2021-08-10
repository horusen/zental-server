<?php

namespace App\Shared\Models\Fichier;

use Illuminate\Database\Eloquent\Model;


class ExtensionFichier extends Model
{
    protected $table  = 'exp_extension_fichier';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle',
        'type',
        'description',
    ];

    public function type()
    {
        return $this->belongsTo(TypeExtensionFichier::class, 'type');
    }

    // Permet de recuperer la liste de tous les extensions sous format regex
    public static function getRegex()
    {
        // get tous les extensions sous formats array
        $extensions = self::all()->toArray();
        return self::getRegexedExtensions($extensions);
    }


    // Permet de recuperer la liste de tous les images sous format regex
    public static function getImageRegex()
    {
        $extensions =  self::where('type', 1)->get()->toArray();
        return  self::getRegexedExtensions($extensions);
    }


    // Permet de recuperer la liste de tous les images sous format regex
    public static function getDocumentRegex()
    {
        $extensions =  self::where('type', 2)->get()->toArray();
        return  self::getRegexedExtensions($extensions);
    }


    // Permet de recuperer la liste de tous les audios sous format regex
    public static function getAudioRegex()
    {
        // get tous les extensions sous formats array
        $extensions =  self::where('type', 3)->get()->toArray();
        return  self::getRegexedExtensions($extensions);
    }

    // Permet de recuperer la liste de tous les audios sous format regex
    public function getVideoRegex()
    {
        // get tous les extensions sous formats array
        $extensions =  self::where('type', 4)->get()->toArray();
        return  self::getRegexedExtensions($extensions);
    }


    // Transforme un tableux en regex
    private static function getRegexedExtensions($extensions)
    {
        // extraire tous les libelles des extensions dans un tableau
        $libelleExtensions = array_map(function ($extension) {
            return ((object) $extension)->libelle;
        }, $extensions);

        // Transformation du tableau précedent en une chaine de caractere séparée par '|'
        $stringyfiedExtensions = join('|',  $libelleExtensions);

        // Transformation de la chaine de caractère en regex
        $regexedExtensions = '/' . $stringyfiedExtensions . '$/';

        return $regexedExtensions;
    }
}
