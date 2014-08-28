<?php
use Symfony\Component\HttpFoundation\Response;

// GET / Home
$app->get('/', function() use($app) {
    $response = $app['twig']->render('templates/index.html.twig');
    return new Response($response, 200);
})->bind("index");
// GET /the-ugly
$app->get('/the-ugly', function() use($app) {
    $response = $app['twig']->render('templates/theugly.html.twig');
    return new Response($response, 200);
})->bind('the_ugly');
// GET /the-bad
$app->get('/the-bad', function() use($app) {
    $response = $app['twig']->render('templates/thebad.html.twig');
    return new Response($response, 200);
})->bind('the_bad');
// GET /the-good
$app->get('/the-good', function() use($app) {
    $response = $app['twig']->render('templates/thegood.html.twig');
    return new Response($response, 200);
})->bind('the_good');




// THE UGLY CONTROLLERS

// GET /api/versions
$app->get('/api/versions', function() use ($app) {
    $server_versions = $app['server_versions'];
    $response = '<option value="">Please select</option>';
    foreach($server_versions as $server_version => $device_by_types) {
        $response .= '<option value="' . $server_version . '">' .
                        $server_version .
                    '</option>';
    }
    
    return new Response($response, 200);
})->bind('api_versions');

// GET /api/type/{server_version_id}
$app->get('/api/type/{server_version_id}', function($server_version_id) use ($app) {
    $server_versions = $app['server_versions'];
    $response = '<option value="">Please select</option>';
    foreach($server_versions as $server_version => $device_by_types) {
        if ($server_version === $server_version_id) {
            foreach($device_by_types as $device_by_type => $urls) {
                $response .= '<option value="' . $device_by_type . '">' .
                                $device_by_type .
                            '</option>';
            }
        }
    }
    
    return new Response($response, 200);
})->bind('api_type_server_version');

// GET /api/url/{server_version_id}
$app->get('/api/urls/{server_version_id}/{type_id}', function($server_version_id, $type_id) use ($app) {
    $server_versions = $app['server_versions'];
    $response = '<div class="table-responsive">
                    <table class="table table-bordered table-striped table-condensed table-hover" id="table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>URL</th>
                            </tr>
                        </thead>
                        <tbody>';
    foreach($server_versions as $server_version => $device_by_types) {
        if ($server_version === $server_version_id) {
            foreach($device_by_types as $device_by_type => $urls) {
                if ($device_by_type === $type_id) {
                    foreach($urls as $url) {
                        $response .= "<tr><td>$url[0]</td><td>$url[1]</td></tr>";
                    }
                }
            }
        }
    }
    
    return new Response($response . '</tbody></table></div>', 200);
})->bind('api_urls_server_version');























// THE BAD CONTROLLERS

// GET /api/versions/list
$app->get('/api/versions/list', function() use ($app) {
    $server_versions = $app['server_versions'];
    $response = array();
    foreach($server_versions as $server_version => $device_by_types) {
        $response[] = $server_version;
    }
    
    return $app->json($response, 200);
})->bind('api_versions_list');

// GET /api/type/{server_version_id}/list
$app->get('/api/type/{server_version_id}/list', function($server_version_id) use ($app) {
    $server_versions = $app['server_versions'];
    $response = array();
    foreach($server_versions as $server_version => $device_by_types) {
        if ($server_version === $server_version_id) {
            foreach($device_by_types as $device_by_type => $urls) {
                $response[] = $device_by_type;
            }
        }
    }
    
    return $app->json($response, 200);
})->bind('api_type_server_version_list');

// GET /api/url/{server_version_id}/list
$app->get('/api/urls/{server_version_id}/{type_id}/list', function($server_version_id, $type_id) use ($app) {
    $server_versions = $app['server_versions'];
    $response = array();
    foreach($server_versions as $server_version => $device_by_types) {
        if ($server_version === $server_version_id) {
            foreach($device_by_types as $device_by_type => $urls) {
                if ($device_by_type === $type_id) {
                    foreach($urls as $url) {
                        $response[] = $url;
                    }
                }
            }
        }
    }
    
    return $app->json($response, 200);
})->bind('api_urls_server_version_list');























// THE GOOD CONTROLLERS

// GET /api/versions/json
$app->get('/api/versions/json', function() use ($app) {
    $server_versions = $app['server_versions'];
    $response = array();
    foreach($server_versions as $server_version => $device_by_types) {
        $response["option"][] = $server_version;
    }
    
    return $app->json($response, 200);
})->bind('api_versions_json');

// GET /api/type/{server_version_id}/json
$app->get('/api/type/{server_version_id}/json', function($server_version_id) use ($app) {
    $server_versions = $app['server_versions'];
    $response = array();
    foreach($server_versions as $server_version => $device_by_types) {
        if ($server_version === $server_version_id) {
            foreach($device_by_types as $device_by_type => $urls) {
                $response["option"][] = $device_by_type;
            }
        }
    }
    
    return $app->json($response, 200);
})->bind('api_type_server_version_json');

// GET /api/url/{server_version_id}/json
$app->get('/api/urls/{server_version_id}/{type_id}/json', function($server_version_id, $type_id) use ($app) {
    $server_versions = $app['server_versions'];
    $response = array();
    foreach($server_versions as $server_version => $device_by_types) {
        if ($server_version === $server_version_id) {
            foreach($device_by_types as $device_by_type => $urls) {
                if ($device_by_type === $type_id) {
                    foreach($urls as $url) {
                        $response["url"][] = array(
                            "type" => $url[0],
                            "url" => $url[1]
                        );
                    }
                }
            }
        }
    }
    
    return $app->json($response, 200);
})->bind('api_urls_server_version_json');