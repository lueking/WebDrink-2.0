/*
*	General configuration
*/

define("API_BASE_URL", "api/index.php?request="); // The base URL of the Drink API
define("DRINK_SERVER_URL", "https://drink.csh.rit.edu:8080"); // Base URL for the Drink (websocket) server
define("LOCAL_DRINK_SERVER_URL", "http://localhost:3000"); // URL (and port) of test drink server (see /test directory)

/*
*	Rate limit delays (one call per X seconds)
*/

define("RATE_LIMIT_DROPS_DROP", 3); // Rate limit for /drops/drop

/*
*	Development configuration
*/

define("DEBUG", true); // true for test mode, false for production

define("DEBUG_USER_UID", "bencentra"); // If DEBUG is `true`, the UID of the test user (probably your own)
define("DEBUG_USER_CN", "Ben Centra"); // If DEBUG is `true`, the display name of the user (probably your own)

define("USE_LOCAL_DRINK_SERVER", true) // If set to `true` and DEBUG is `true`, will use a mock Drink server for developing

?>
