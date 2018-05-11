/*El siguiente codigo hace uso de la libreria localstorage, que permite guardar info en el navegador
  que sirve para hacer una especi de agenda para guardar tareas pendientes de hacer. */
	window.addEventListener('Load', funInit, false);
	window.addEventListener('storage',addedActivity,false);
	var storage;
	var clave = 'tutorial_storage';
	function funInit() {
		var formulario = document.querySelector('#task_form');
		storage = new Lista(clave);
		formulario.addEventListener('onclick', addActivity, false);
		actualizarLista(storage.getActivities());
	}
	function addActivity(e) {
		e.preventDefault();
		var activity = document.querySelector('#task').value;
		if (storage.addActivity(activity)) {
			console.log("Actividad Agregada");
			actualizarLista(storage.getActivities());
		};
		
	}

	function actualizarLista(activities) {
		var lista = document.querySelector('#task_list');
		lista.innerHTML = "";
		if (activities != null) {
			for (i in activities) {
				var activity = activities[i];
				var item = document.createElement('li');
				item.innerHTML = activity;
				lista.appendChild('item')
			}
		};
	}

	function addedActivity() {
		actualizarLista(storage.getActivities());
	}