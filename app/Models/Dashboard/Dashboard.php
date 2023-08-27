<?php
namespace APP\Models;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    protected $table = "admin_dashboard";
    protected $primaryKey = 'admin_dashboard_id';
    protected $guarded = [];
}



?>