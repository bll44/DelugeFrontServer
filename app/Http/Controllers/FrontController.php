<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class FrontController extends Controller
{
	public function index()
	{
		$message = session()->get('status_ok');

		return view('main/index', ['message' => $message]);
	}

	public function addTorrent(Request $http)
	{
		$torrentUrl = $http->torrent_href;
		$responseHeaders = get_headers($torrentUrl, 1);
		$pos = strpos($responseHeaders['Content-Disposition'], '=') + 1; // +1 to not include the '=' in the substring
		$filename = str_replace(' ', '_', str_replace(['"', '\''], '', substr($responseHeaders['Content-Disposition'], $pos)));
		$fileLocation = storage_path() . '/torrents/' . $filename;
		$file = fopen($fileLocation, 'w+');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $torrentUrl);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FILE, $file);
		curl_exec($ch);
		curl_close($ch);
		fclose($file);

		// move the downloaded file to Deluge monitored directory
		$newFileLocation = '/mnt/torrent_files/' . $filename;
		if( ! rename($fileLocation, $newFileLocation))
		{
			return redirect('/')
						->with('file_move_error', 'Failed to move the (' . $filename . ') file to the monitored directory');

		}

		return redirect('/')->with('status_ok', 'I think it worked.');
	}

}