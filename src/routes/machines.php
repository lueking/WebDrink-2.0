<?php



/*
*	Machines Endpoint
*
*	GET /machines/stock/:machine_id - Get the stock of one (or all) machines
*   GET /machines/info/:machine_id - Get the info of one (or all) machines
*	POST /machines/slot/:slot_num/:machine_id/:item_id/:available/:status - Update a machine slot (admin only)
*/

use Slim\Http\Request;
use Slim\Http\Response;


/**
 * list the drink machines.
 */
$app->get("/list", function (Request $request, Response $response, array $args) {
    $machineAPI = new \WebDrink\API\Machines();
    $machines = $machineAPI->getAllDrinkMachines();
    return $response->withJson($machines);
});

/**
 * get the info of the specific drink machine. returns a big old array of the slots of the machine.
 * required params: machine id
 */
$app->get("/info", function (Request $request, Response $response, array $args){
    $machineAPI = new \WebDrink\API\Machines();

    $machineid = $request->getParam("machineid");
    //todo: sanitize and error checking

    $machines = $machineAPI->getMachineInfo($machineid);
    return $response->withJson($machines);

});

/**
 * update the contents of the slot.
 * required params: machine id, slot id, item id, availible, status
 */
$app->post("/slot/update", function (Request $request, Response $response, array $args){

});
