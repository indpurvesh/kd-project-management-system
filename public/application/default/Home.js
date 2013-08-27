var Default_Home = {

    init: function() {
        var self = Default_Home;
        self.initSetUp();
    },
    initSetUp: function() {
        application_url = "http://www.localhost.com/kd-step";
    }
}
jQuery(window).ready(Default_Home.init);
