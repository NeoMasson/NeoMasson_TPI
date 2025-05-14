<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modèle représentant un utilisateur du système
 * 
 * Ce modèle gère les comptes utilisateurs de l'application, incluant :
 * - Les informations d'identification (email, mot de passe)
 * - Les informations personnelles (nom)
 * - La gestion des sessions et de l'authentification
 * - Les tokens de rappel pour la fonction "Se souvenir de moi"
 * 
 * Il utilise le système d'authentification Laravel intégré et inclut
 * des fonctionnalités de sécurité comme le hachage automatique
 * des mots de passe.
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Liste des attributs qui peuvent être assignés en masse
     * Seuls ces champs peuvent être remplis via User::create()
     * 
     * @var list<string>
     */
    protected $fillable = [
        'name',        // Nom de l'utilisateur
        'email',       // Adresse email (utilisée pour l'identification)
        'password',    // Mot de passe (sera automatiquement haché)
    ];

    /**
     * Liste des attributs qui doivent être cachés lors de la sérialisation
     * Ces champs ne seront pas inclus lors de la conversion en JSON/array
     * 
     * @var list<string>
     */
    protected $hidden = [
        'password',       // Mot de passe haché
        'remember_token', // Token pour la fonction "Se souvenir de moi"
    ];

    /**
     * Définition des conversions de type pour certains attributs
     * Spécifie comment les attributs doivent être convertis lors des
     * opérations de lecture/écriture
     * 
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Conversion en objet DateTime
            'password' => 'hashed',           // Assure le hachage du mot de passe
        ];
    }
}
