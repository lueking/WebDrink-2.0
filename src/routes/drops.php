<?php

use Slim\Http\Request;
use Slim\Http\Response;


/**
 * GET /drops/status/:ibutton - Check the Websocket connection to the drink server
 */
$app->get('/status/{ibutton}', function (Request $request, Response $response) {
    // Getting route attributes
    $ibutton = $request->getAttribute('ibutton');


    // Connect to the Drink Server through a websocket
    if (DEBUG && USE_LOCAL_DRINK_SERVER) {
        $elephant = new ElephantIO\Client(LOCAL_DRINK_SERVER_URL, "socket.io", 1, false, true, true);
    } else {
        $elephant = new ElephantIO\Client(DRINK_SERVER_URL, "socket.io", 1, false, true, true);
    }

    // Default output if failure
    $output = ["Unable to get a result from Server (/drops/status)", 500];

    try {
        $elephant->init();
        $elephant->emit('ibutton', ['ibutton' => $ibutton]);
        $elephant->on('ibutton_recv', function ($data) use ($response, $elephant, &$output) {
            $success = explode(":", $data);
            $success = $success[0];

            // Checks for a successful response from the websocket
            if ($success === "OK") {
                $output = ["Success! (/drops/status)", 200];
                $elephant->close();
            } else {
                $output = ["Invalid iButton (/drops/status)", 400];
                $elephant->close();
            }
        });
        // Keep Alive required
        $elephant->keepAlive();
    } catch (Exception $e) {
        $output = [$e->getMessage() . " (/drops/drop)", 500];
    }

    $elephant->close();
    return $response->withStatus($output[0], $output[1]);
});

/**
 * POST /drops/drop/:ibutton/:machine_id/:slot_num/:delay - Drop a drink by machine id and slot number, using the specified delay.
 */
$app->post('/drop/{ibutton}/{machine_id}/{slot_num}/{delay}', function (Request $request, Response $response) {
    // Getting route attributes
    $ibutton = $request->getAttribute('ibutton');
    $machine_id = $request->getAttribute('machine_id');
    $slot_num = $request->getAttribute('slot_num');
    $delay = $request->getAttribute('delay');

    $machines = [
        1 => 'ld',
        2 => 'd',
        3 => 's'
    ];

    // Check for machine_id and convert to machine_alias
    if (isset($machine_id)) {
        $machine_alias = $machines[$machine_id];
        if (is_null($machine_alias)){
            return $response->withStatus(400, "Invalid 'machine_id' (/drops/drop)");
        }
    } else {
        return $response->withStatus(400, "Invalid 'machine_id' (/drops/drop)");
    }

    // Check if rate limited
    $rateLimitDelay = RATE_LIMIT_DROPS_DROP;
    if ($this->_isRateLimited("/drops/drop", $rateLimitDelay, $machine_alias)) {
        return $response->withStatus(400, "Cannon exceed one call per {$rateLimitDelay} seconds (/drops/drop)");
    }

    // Connect to the Drink Server through a websocket
    if (DEBUG && USE_LOCAL_DRINK_SERVER) {
        $elephant = new ElephantIO\Client(LOCAL_DRINK_SERVER_URL, "socket.io", 1, false, true, true);
    } else {
        $elephant = new ElephantIO\Client(DRINK_SERVER_URL, "socket.io", 1, false, true, true);
    }

    // Default output if failure
    $output = ["Unable to get a result from Server (/drops/drop)", 500];

    try {
        $elephant->init();
        $elephant->emit('ibutton', ['ibutton' => $ibutton]);
        $elephant->on('ibutton_recv', function ($data) use ($machine_id, $machine_alias, $slot_num, $delay, $api, $response, $elephant, &$output) {
            $success = explode(":", $data);
            $success = $success[0];

            // Checks for a successful response from the websocket
            if ($success === "OK") {
                // Connect to the drink machine
                $elephant->emit('machine', ['machine_id' => $machine_alias]);
                $elephant->on('machine_recv', function ($data) use ($machine_id, $machine_alias, $response, $api, $slot_num, $delay, $elephant, &$output) {
                    $success = explode(":", $data);
                    $success = $success[0];

                    if ($success === "OK") {
                        // Drop the drink
                        $elephant->emit('drop', ['slot_num' => $slot_num, 'delay' => $delay]);
                        $elephant->on('drop_recv', function ($data) use ($machine_id, $slot_num, $machine_alias, $api, $response, $elephant, &$output) {
                            $success = explode(":", $data);
                            $success = $success[0];

                            if ($success === "OK") {
                                $output = ["Drink dropped!", 200];
                                $elephant->close();
                            } else {
                                $elephant->close();
                                $output = ["Error dropping drink: {$data} (/drops/drop)", 500];
                            }
                        });
                    } else {
                        $output = ["Error contacting machine: {$data} (/drops/drop)", 500];
                        $elephant->close();
                    }
                });
            } else {
                $output = ["Invalid iButton (/drops/status)", 400];
                $elephant->close();
            }
            $elephant->keepAlive();
        });
    } catch (Exception $e) {
        $output = [$e->getMessage() . " (/drops/drop)", 500];
    }

    $elephant->close();
    return $response->withStatus($output[0], $output[1]);
});

