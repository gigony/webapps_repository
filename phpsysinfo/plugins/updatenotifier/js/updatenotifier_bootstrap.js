function renderPlugin_UpdateNotifier(data) {

    var directives = {
        updateNotifierNbPackages: {
            text: function () {
                return this['packages'];
            }
        },
        updateNotifierNbSecPackages: {
            text: function () {
                return this['security'];
            }
        }
    };
    if ((data['Plugins']['Plugin_UpdateNotifier'] !== undefined) && (data['Plugins']['Plugin_UpdateNotifier']["UpdateNotifier"] !== undefined)){
        $('#updatenotifier').render(data['Plugins']['Plugin_UpdateNotifier']["UpdateNotifier"], directives);
        if ((data['Plugins']['Plugin_UpdateNotifier']["UpdateNotifier"]["packages"] == 0) &&
            (data['Plugins']['Plugin_UpdateNotifier']["UpdateNotifier"]["security"] == 0) ) {
            $("#updatenotifier-info").html("<strong>No updates available</strong>");
        }
        $('#block_updatenotifier').show();
    }
}