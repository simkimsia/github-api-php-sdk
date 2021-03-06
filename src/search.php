<?php
/**
 * GitHub API v3 to search.
 *
 * Currently using BASIC auth
 *
 * Copyright 2013, Kim Stacks
 * Singapore
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2013, Kim Stacks.
 * @link http://stacktogether.com
 * @author Kim Stacks <kim@stacktogether.com>
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package GitHubAPI
 * @version 0.1.0-alpha
 */
if (!function_exists('curl_init')) {
  throw new Exception('GitHub API SDK needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
  throw new Exception('GitHub API SDK needs the JSON PHP extension.');
}

// fetch search data
function curl($path, $options = []) {
    $domain = 'https://api.github.com/';
    $url = $domain . $path;

    return execute_curl($url, $options);
}

function execute_curl($url, $options = []) {
    $username = $options['username'];
    $password = $options['password'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10);
    curl_setopt($ch, CURLOPT_TIMEOUT,60);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_USERAGENT, "$username");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}

function search_repositories($querystring, $options = []) {
    $action = 'search/repositories';
    $path = $action . '?' . $querystring;

    return curl($path, $options);
}

// example:
// $result = json_decode(curl('q=php'),true);