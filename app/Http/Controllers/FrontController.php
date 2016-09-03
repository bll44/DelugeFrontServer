<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Requests;
use App\Torrent;

class FrontController extends Controller
{
	public function index()
	{
		$message = session()->get('status_ok');

		return view('torrents.add', ['message' => $message]);
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
			
			// set location to copy/move .torrent file to
			$newFileLocation = env('TORRENT_WATCH_DIR') . $filename;

			// make a copy of the .torrent file before moving it
			if( ! copy($fileLocation, env('TORRENT_ARCHIVE_DIR') . $filename))
				Log::error('Failed to create archive copy of ' . $filename . ' in ' . env('TORRENT_ARCHIVE_DIR') . "\n");
			else
				Log::info('Successfully created archive copy of ' . $filename . ' in ' . env('TORRENT_ARCHIVE_DIR') . "\n");
			
			// move the downloaded file to Deluge monitored directory
			if( ! rename($fileLocation, $newFileLocation))
			{
				return redirect('/')
							->with('file_move_error', 'Failed to move the file ' . $filename . ' to the monitored directory');

			}
			
			$torrentobj->save();
		}

		return redirect('/')->with('status_ok', 'I think it worked.');
	}

}