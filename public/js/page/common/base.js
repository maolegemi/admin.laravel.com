define(function() {
	function baseApp(env) {
		this.app_env = env;
	}
	baseApp.prototype = {
		path: {
			
		},
		debug: function(msg) {
			this.app_env !== 'live' ? console.log(msg) : '';
		},
		catchEx: function(e) {
			console.log(e.message, e.description, e.name);
		},
		getEnv: function() {
			return this.app_env;
		},
		getPath: function(uri) {
			return _.has(this.path, uri) ? this.path[uri] : uri;
		},
	}

	return baseApp;
});