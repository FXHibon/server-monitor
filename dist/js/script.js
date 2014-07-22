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
            var i;
            var dataToAdd;


            dataToAdd = "";
            i = 1;
            for (key in data) {
                dataToAdd += "<tr class=\"" + obj.status + "\">\n";
                dataToAdd += "<td>" + (i) + "</td>\n";
                dataToAdd += "<td>" + obj.key(i++) + "</td>\n";
                dataToAdd += "<td>" + (obj.status === "success" ? "Up" : "Down") + "</td>\n";
                dataToAdd += "<td>xx</td>\n";
                dataToAdd += '<td>\n\
                    <button onclick="reboot();" type="button" class="btn btn-default">\n\
                        <span class="glyphicon glyphicon-repeat"></span>\n\
                    </button>\n\
                </td>\n';
            }

            $('#tableBody').html("");
            $('#tableBody').html(dataToAdd);
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