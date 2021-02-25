<?php

namespace AndreaMarelli\ModularForms\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;


/**
 * Class Animal
 *
 * @property string $name
 * @property string $common_names
 * @property string $iucn_redlist_category
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package AndreaMarelli\ModularForms\Models
 */
class Animal extends BaseModel
{
    protected $primaryKey = 'id';

    protected $appends = [
        'name',
    ];
    protected $classes = ['amphibians', 'birds', 'butterflies', 'fishes', 'mammals', 'reptiles'];

    /**
     * Accessor for "scientific_name" (binomial)
     *
     * @return mixed
     */
    public function getNameAttribute(): string
    {
        return $this->attributes['genus'] . ' ' . $this->attributes['species'];
    }

    /**
     * Accessor for common_names
     *
     * @return mixed
     */
    public function getCommonNamesAttribute(): string
    {
        return $this->attributes['common_name_fr'] . ' ' .
            $this->attributes['common_name_en'] . ' ' .
            $this->attributes['common_name_sp'];
    }

    /**
     * Scope a query to filter by class
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $class
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterClass(Builder $query, $class = null): Builder
    {
        if ($class !== null) {
            if ($class == 'fishes') {
                return $query
                    ->where('class', 'Sarcopterygii')
                    ->orWhere('class', 'Actinopterygii')
                    ->orWhere('class', 'Chondrichthyes');
            }
            $class = ($class == 'mammals') ? 'Mammalia' : $class;
            $class = ($class == 'birds') ? 'Aves' : $class;
            $class = ($class == 'reptiles') ? 'Reptilia' : $class;
            $class = ($class == 'amphibians') ? 'Amphibia' : $class;
            $class = ($class == 'butterflies') ? 'Insecta' : $class;
            $query = $query->where('class', $class);
        }
        return $query;
    }

    /**
     * Scope a query to filter by taxonomy
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $class
     * @param string $order
     * @param string $family
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterTaxonomy(Builder $query, string $class, string $order, string $family): Builder
    {
        return $query
            ->filterClass($class)
            ->where('order', $order)
            ->where('family', $family);
    }

    /**
     * Scope a query to search by string
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search_key
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchName(Builder $query, string $search_key): Builder
    {
        return $query
            ->whereRaw('unaccent(species) ILIKE unaccent(?)', ['%'.$search_key.'%'])
            ->orWhereRaw('unaccent(genus) ILIKE unaccent(?)', ['%'.$search_key.'%'])
            ->orWhereRaw('unaccent(family) ILIKE unaccent(?)', ['%'.$search_key.'%'])
            ->orWhereRaw('unaccent(\'order\') ILIKE unaccent(?)', ['%'.$search_key.'%'])
            ->orWhereRaw('unaccent(class) ILIKE unaccent(?)', ['%'.$search_key.'%'])
            ->orWhereRaw('unaccent(phylum) ILIKE unaccent(?)', ['%'.$search_key.'%'])
            ->orWhereRaw('unaccent(common_name_en) ILIKE unaccent(?)', ['%'.$search_key.'%'])
            ->orWhereRaw('unaccent(common_name_fr) ILIKE unaccent(?)', ['%'.$search_key.'%'])
            ->orWhereRaw('unaccent(common_name_sp) ILIKE unaccent(?)', ['%'.$search_key.'%']);
    }

    /**
     * Get the number of species for the given class
     *
     * @param string $class
     * @return integer
     */
    public static function getNumByClass(string $class): int
    {
        return static::filterClass($class)->count();
    }

    /**
     * Get a 2-dimension array with order/family structure
     *
     * @param string $class
     * @return array
     */
    public static function getTaxonomyStructure(string $class): array
    {
        $species = static::select(DB::raw('DISTINCT("family"), "order"'))
            ->filterClass($class)
            ->orderBy('order')
            ->orderBy('family')
            ->get();

        $taxonomy = [];
        foreach ($species as $item) {
            if (!isset($taxonomy[$item['order']])) {
                $taxonomy[$item['order']] = array();
            }
            $taxonomy[$item['order']][] = $item['family'];
        }
        return $taxonomy;
    }

    /**
     * Search Species by given string
     *
     * @param string $search_key
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function searchSpecies(string $search_key): Collection
    {
        return static::searchName($search_key)
            ->orderBy('phylum')
            ->orderBy('class')
            ->orderBy('order')
            ->orderBy('family')
            ->orderBy('genus')
            ->orderBy('species')
            ->get();
    }

    /**
     * Retrieve species by taxonomy
     *
     * @param string $binomial
     * @param string $family
     * @param string $order
     * @return \AndreaMarelli\ModularForms\Models\Animal
     */
    public static function getByTaxonomy(string $binomial, string $family, string $order): Animal
    {
        list($genus, $species) = explode(' ', $binomial);
        return static::where('species', '=', $species)
            ->where('genus', '=', $genus)
            ->where('family', '=', $family)
            ->where('order', '=', $order)
            ->firstOrFail();
    }

    /**
     * Check if the given string contains taxonomy (parts divided by |)
     *
     * @param string $taxonomy
     * @return bool
     */
    private static function isTaxonomy(string $taxonomy): bool
    {
        return substr_count($taxonomy, '|') === 5;
    }

    /**
     * Extract the scientific name from the taxonomy
     *
     * @param string $taxonomy
     * @return string|null
     */
    private static function getScientificName(string $taxonomy): ?string
    {
        $binomial = null;
        if($taxonomy!==null){
            $taxonomy_array = explode('|', $taxonomy);
            $binomial =  $taxonomy_array[4] . ' ' . $taxonomy_array[5];
        }
        return $binomial;
    }

    /**
     * Extract the plain name from the taxonomy
     *
     * @param string $taxonomy
     * @return string|null
     */
    public static function getPlainNameByTaxonomy(string $taxonomy): ?string
    {
        return $taxonomy != null && static::isTaxonomy($taxonomy)
            ? static::getScientificName($taxonomy)
            : $taxonomy;
    }

    /**
     * Retrieve common names from
     *
     * @param string $taxonomy
     * @return string
     */
    public static function getCommonName(string $taxonomy): ?string
    {
        if(static::isTaxonomy($taxonomy)){
            $taxonomy_array = explode('|', $taxonomy);
            $model = static::getByTaxonomy(
                $taxonomy_array[4] . ' ' . $taxonomy_array[5],
                $taxonomy_array[3],
                $taxonomy_array[2]);
            return $model->common_names;
        }
        return null;
    }

    /**
     * @param string $taxonomy
     * @return mixed|null
     */
    public static function getIUCNCategory(string $taxonomy): ?string
    {
        if(static::isTaxonomy($taxonomy)){
            $taxonomy_array = explode('|', $taxonomy);
            $model = static::getByTaxonomy(
                $taxonomy_array[4] . ' ' . $taxonomy_array[5],
                $taxonomy_array[3],
                $taxonomy_array[2]);
            return $model->iucn_redlist_category;
        }
        return null;
    }

}
