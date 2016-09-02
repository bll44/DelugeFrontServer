<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Torrent extends Model
{
    protected $table = 'torrents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['link', 'domain', 'fs_location', 
    						'created_at', 'updated_at'];
    						

    public function parseUrlDomain($url)
    {
    	$hostAttrs = explode('.', parse_url($url)['host']);
		$this->domain = $hostAttrs[count($hostAttrs) - 2] . '.' . $hostAttrs[count($hostAttrs) - 1];
		return $this->domain;
    }
}
