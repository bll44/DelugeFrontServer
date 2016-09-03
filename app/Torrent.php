<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Torrent extends Model
{
	protected $table = 'torrents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['link', 'domain', 'fs_archive_location', 
    						'created_at', 'updated_at'];

    public function parseUrlDomain($url)
    {
    	$hostAttrs = explode('.', parse_url($url)['host']);
    	$this->domain = $hostAttrs[count($hostAttrs) - 2] . '.' . $hostAttrs[count($hostAttrs) - 1];
    	return $this->domain;
    }

    public function createArchiveCopy($fileLocation)
    {
    	// make a copy of the file before moving it
    	if( ! copy($fileLocation, env('TORRENT_ARCHIVE_DIR') . $this->filename) )
    	{
    		Log::error('Failed to create archive copy of ' . $this->filename . ' in ' . env('TORRENT_ARCHIVE_DIR'));
    		return false;
    	}
    	Log::info('Created archive copy of ' . $this->filename . ' in ' . env('TORRENT_ARCHIVE_DIR'));
    	$this->fs_archive_location = env('TORRENT_ARCHIVE_DIR') . $this->filename;
    	return true;
    }

    public function moveToWatchDir($fileLocation)
    {
    	// move the downloaded file to Deluge monitored directory
		if( ! rename($fileLocation, env('TORRENT_WATCH_DIR') . $this->filename) )
		{
			Log::critical('Failed to move the file ' . $this->filename . ' to the monitored torrent directory. [' . env('TORRENT_WATCH_DIR') . ']');
			return false;
		}
		Log::info('Moved the file ' . $this->filename . ' to the monitored torrent directory. [' . env('TORRENT_WATCH_DIR') . ']');
		return true;
    }
}
