<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Torrent;
use DB;

class FrontController extends Controller
{
	public function index()
	{
		$message = session()->get('status_ok');

		$query = "SELECT domain, fs_archive_location, link, created_at 
					FROM torrents ORDER BY created_at DESC";
		$results = DB::select($query);

		return view('torrents.add', ['message' => $message, 'torrents' => $results]);
	}

	public function addTorrent(Request $http)
	{
		$torrentUrls = $http->torrent_href;
		foreach($torrentUrls as $tmpUrl)
		{
			$responseHeaders = get_headers($tmpUrl, 1);

			$torrentobj = new Torrent;
			// parseUrlDomain also sets the $domain property within the object
			$torrentobj->parseUrlDomain($tmpUrl);
			$torrentobj->link = $tmpUrl;

			// +1 to not include the '=' in the substring
			$pos = strpos($responseHeaders['Content-Disposition'], '=') + 1;
			$filename = str_replace(' ', '_', str_replace(['"', '\''], '', substr($responseHeaders['Content-Disposition'], $pos)));
			$fileLocation = storage_path() . '/torrents/' . $filename;
			$file = fopen($fileLocation, 'w+');
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $tmpUrl);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FILE, $file);
			curl_exec($ch);
			curl_close($ch);
			fclose($file);
			
			// set the filename in the torrent object for later use
			$torrentobj->filename = $filename;

			// copy and move the file to defined locations
			$torrentobj->createArchiveCopy($fileLocation);
			$torrentobj->moveToWatchDir($fileLocation);

			// save row to database for record keeping
			$torrent = Torrent::create([
				'domain' => $torrentobj->domain,
				'link' => $torrentobj->link,
				'fs_archive_location' => $torrentobj->fs_archive_location
			]);
		}

		return redirect('/')->with('status_ok', 'Torrent successfully downloaded.');
	}

}