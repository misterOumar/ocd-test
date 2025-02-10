<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Person extends Model
{
    protected $fillable = [
        'created_by',
        'first_name',
        'last_name',
        'birth_name',
        'middle_names',
        'date_of_birth',
    ];

    // une personne peut avoir plusieurs enfants
    public function children()
    {
        return $this->belongsToMany(Person::class, 'relationships', 'parent_id', 'child_id');
    }

    // une personne peut avoir plusieurs parents
    public function parents()
    {
        return $this->belongsToMany(Person::class, 'relationships', 'child_id', 'parent_id');
    }

    // une personne a un utilisateur createur
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getDegreeWith($target_person_id)
    {
        if ($this->id == $target_person_id) return 0;

        $start_id = $this->id;
        $visited_from_start = [$start_id => 0];
        $visited_from_end = [$target_person_id => 0];
        $queue_start = [$start_id];
        $queue_end = [$target_person_id];
        $max_degree = 25;

        while (!empty($queue_start) && !empty($queue_end)) {
            // Recherche depuis le début
            $degree = $this->bfsStep($queue_start, $visited_from_start, $visited_from_end, $max_degree);
            if ($degree !== false) return $degree;

            // Recherche depuis la fin
            $degree = $this->bfsStep($queue_end, $visited_from_end, $visited_from_start, $max_degree);
            if ($degree !== false) return $degree;
        }

        return false;
    }

    private function bfsStep(&$queue, &$visited, $other_visited, $max_degree)
    {
        $current_id = array_shift($queue);
        $current_degree = $visited[$current_id];

        if ($current_degree >= $max_degree) return false;

        $sql = "SELECT CASE 
                WHEN parent_id = ? THEN child_id 
                WHEN child_id = ? THEN parent_id 
            END AS related_id 
            FROM relationships 
            WHERE parent_id = ? OR child_id = ?";

        $related_ids = DB::select($sql, [$current_id, $current_id, $current_id, $current_id]);

        foreach ($related_ids as $relation) {
            $related_id = $relation->related_id;

            if (isset($other_visited[$related_id])) {
                return $current_degree + $other_visited[$related_id] + 1;
            }

            if (!isset($visited[$related_id])) {
                $visited[$related_id] = $current_degree + 1;
                $queue[] = $related_id;
            }
        }

        return false;
    }

}
