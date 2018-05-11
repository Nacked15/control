function Lista(clave) {
	this.clave = clave;
	this.addActivity = function (activity) {
		if (this.validarNavegador()) {
			if (localStorage.getItem(this.clave)) {
				var activities = JSON.parse(localStorage.getItem(this.clave));
			} else {
				var activities = [];
			}
			activities.push(activity);
			localStorage.setItem(this.clave, JSON.stringify(activities));
			return true;
		}
		return false;
	}

	this.getActivities = function() {
		if (localStorage.getItem(this.clave) != "undefined") {
				return JSON.parse(localStorage.getItem(this.clave));
		}
		return null;
	}

	this.deleteActivity = function(activity) {
		var activities = JSON.parse(localStorage.getItem(this.clave));
		activities = activities.filter(function(i) {
			return i != activity;
		});
		localStorage.setItem(this.clave, JSON.stringify(activities));
	}

	this.deleteActivity = function() {
		localStorage.removeItem(this.clave);
	}

	this.validarNavegador = function () {
		if(typeof(Storage) !== 'undefined') return true;
		return false;
	}
}