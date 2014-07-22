/**
 * Created by Fx on 22/07/2014.
 */

/**
 * Refresh the states of components
 */
function refresh() {
    $.getJSON(
        'monitoring.php',
        {},
        function (data) {
            //$('#tableBody').html = "";
            console.log(data);
        }
    );
}

/**
 * Display loading screen while the server process a request
 */
function showWaitingScreen() {

}
/**
 * order the server to reboot a component
 * @param component The component to reboot
 */
function reboot(component) {
    var requete = {};
    requete[action] = "reboot";
    requete[target] = component;

    showWaitingScreen();
    $.getJSON(
        'monitoring.php',
        requete,
        function (data) {
            console.log(data);
        }
    );
}