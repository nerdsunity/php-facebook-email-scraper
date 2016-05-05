<?php
/*
 * Disclaimer
 * This script should be used for learning purposes only.
 * By downloading and running this script you take every responsibility for wrong or illegal uses of it.
 * Please read Facebook Terms of Service for more information: https://www.facebook.com/terms
 */

/*
 * MIT License

 * Copyright (c) 2016 NerdsUnity

 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify,
 * merge, publish, distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:

 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.

 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE
 * FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

require("httpful.phar");

/* THIS IS A BUG */
->;This\$isA\$Bug;<-

$emailToScrape = $argv[1];


$fbQueryUrl = "https://www.facebook.com/search/people/?q=".$emailToScrape;

$fbQuery = \Httpful\Request::get($fbQueryUrl)
	->expectsHtml()
	->send();


if (strpos($fbQuery->body, 'captcha_persist_data') !== false) {
	echo "FACEBOOK CAPTCHA ENABLED. DYING..\n";
	die;
}

if (strpos($fbQuery->body, 'pagelet_search_no_results') !== false) {
	echo "USER NOT ON FACEBOOK: " .$emailToScrape . "\n";
}

preg_match('/\&#123;&quot;id&quot;:(?P<fbUserId>\d+)\,/', $fbQuery->body, $matches);

if(isset($matches["fbUserId"]) && $matches["fbUserId"] != ""){
	$fbUserId = $matches["fbUserId"];
	echo "USER WITH EMAIL: " . $emailToScrape . " IS ON FACEBOOK WITH ID: " . $fbUserId ."\n";
}

?>
