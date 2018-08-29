<?php
use Slim\Http\Request;
use Slim\Http\Response;

/*
*	Items endpoint
*
* GET /items/list - Get a list of all items
* POST /items/add/:name/:price - Add a new item to the database (admin only)
* POST /items/update/:item_id/:name/:price/:status - Update an item (admin only)
* POST /items/delete/:item_id - Delete an item (admin only)
*/

//since we're in here, spawn an Items instance to use.

$items = new WebDrink\API\Items();

/**
 * returns a list of the available drink machines
 */
$app->get("/list", function (Request $request, Response $response, array $args){
    return $response->withStatus(200);
});

/**
 * add a new item to the item database
 * required params:
 *      string: name
 *      int: price
 */
$app->post("/add", function (Request $request, Response $response, array $args){

});

/**
 * update an item's name, price, or status
 * required params:
 *      ?: id
 *      string: name
 *      int: price
 *      bool: status
 */
$app->patch("/", function (Request $request, Response $response, array $args){

});

/**
 * remove an item from the database
 * required params:
 *      ?: id
 */
$app->delete("", function (Request $request, Response $response, array $args){

});



