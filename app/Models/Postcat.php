<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postcat extends Model
{
  /**
   * Get the category relation values for the cat_relation table.
   */
  public function cat_relation()
  {
      return $this->hasMany('App\Models\Cat_relation', 'catid');
  }
}
