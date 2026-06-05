<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

/**
 * Trait HasUniqueSlug
 *
 * Garante que o atributo `slug` seja único na tabela, acrescentando
 * um sufixo incremental (-2, -3, ...) caso já exista um registro com
 * o mesmo slug.
 *
 * Uso:
 *  - Defina a propriedade `$slugSource` com o nome do atributo de origem
 *    (ex: 'nome' ou 'titulo'). Se não for definida, será usado 'nome'.
 *  - O model precisa ter o campo `slug` no $fillable.
 */
trait HasUniqueSlug
{
    /**
     * Boot do trait: aplica a geração automática do slug no creating.
     */
    public static function bootHasUniqueSlug(): void
    {
        static::creating(function ($model) {
            $model->ensureUniqueSlug();
        });

        static::updating(function ($model) {
            // Garante unicidade apenas se o slug (ou a fonte) foi alterado.
            if ($model->isDirty($model->getSlugSource()) || $model->isDirty('slug')) {
                $model->ensureUniqueSlug();
            }
        });
    }

    /**
     * Retorna o nome do atributo de origem usado para gerar o slug.
     */
    public function getSlugSource(): string
    {
        return property_exists($this, 'slugSource') && $this->slugSource
            ? $this->slugSource
            : 'nome';
    }

    /**
     * Garante que o slug do model seja único na tabela.
     * Caso vazio, gera a partir da fonte. Se já existir,
     * anexa um sufixo incremental até encontrar um livre.
     */
    public function ensureUniqueSlug(): void
    {
        $source = $this->getSlugSource();
        $base = $this->slug ?: ($this->{$source} ?? '');

        $base = Str::slug((string) $base);

        if ($base === '') {
            $base = Str::random(8);
        }

        $slug = $base;
        $suffix = 2;

        $query = static::query()
            ->where('slug', $slug)
            ->where($this->getKeyName(), '!=', $this->getKey() ?? 0);

        while ($query->exists()) {
            $slug = $base . '-' . $suffix;
            $query = static::query()
                ->where('slug', $slug)
                ->where($this->getKeyName(), '!=', $this->getKey() ?? 0);
            $suffix++;
        }

        $this->slug = $slug;
    }
}
