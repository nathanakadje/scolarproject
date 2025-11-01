<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class AssignmentAttachment extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'attachment_type',
    ];

    /**
     * 🔗 Relation : la pièce jointe appartient à un devoir
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * 🧾 Type de pièce jointe formaté
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->attachment_type) {
            'instruction' => 'Consigne',
            'resource' => 'Ressource',
            'template' => 'Modèle',
            'example' => 'Exemple',
            default => ucfirst($this->attachment_type),
        };
    }

    /**
     * 💾 Taille du fichier formatée (en Ko/Mo)
     */
    public function getFormattedSizeAttribute(): string
    {
        $size = $this->file_size;
        if ($size < 1024) {
            return $size . ' o';
        } elseif ($size < 1048576) {
            return round($size / 1024, 2) . ' Ko';
        }
        return round($size / 1048576, 2) . ' Mo';
    }

    /**
     * 📂 Retourne l’URL publique du fichier
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }
}
