<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Changelog extends Model
{
    use HasFactory;

    protected $table = 'changelog';

    protected $fillable = [
        'versao',
        'data_lancamento',
        'categorias'
    ];

    protected $casts = [
        'categorias' => 'array'
    ];

    /**
     * Adicionar descrição a uma categoria
     */
    public function addCategoryDescription(int $categoryId, string $description)
    {
        // Verificar se a categoria existe
        if (!ChangelogCategory::find($categoryId)) {
            throw new \InvalidArgumentException("Categoria {$categoryId} não existe");
        }

        $description = trim($description);
        if (empty($description)) {
            return; // Não adiciona descrição vazia
        }

        $categorias = $this->categorias ?? [];

        if (!isset($categorias[$categoryId])) {
            $categorias[$categoryId] = [];
        }

        $categorias[$categoryId][] = $description;
        $this->categorias = $categorias;
        $this->save();
    }

    /**
     * Obter categorias formatadas para exibição
     */
    public function getFormattedCategories()
    {
        if (!$this->categorias) {
            return [];
        }

        $categories = ChangelogCategory::whereIn('id', array_keys($this->categorias))->get()->keyBy('id');
        $formatted = [];

        foreach ($this->categorias as $categoryId => $descriptions) {
            if (isset($categories[$categoryId])) {
                $formatted[] = [
                    'categoria' => $categories[$categoryId]->nome,
                    'categoria_id' => $categoryId,
                    'descricoes' => $descriptions
                ];
            }
        }

        return $formatted;
    }

    /**
     * Verificar se tem itens em uma categoria específica
     */
    public function hasCategory(int $categoryId): bool
    {
        return isset($this->categorias[$categoryId]) && !empty($this->categorias[$categoryId]);
    }

    /**
     * Contar total de itens
     */
    public function getTotalItemsAttribute(): int
    {
        if (!$this->categorias) {
            return 0;
        }

        return collect($this->categorias)->sum(fn($descriptions) => count($descriptions));
    }
}
