
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
//helper function
function getAllTask() {
	let tasks = [];
	axios.get('/tasks').then(response => {
		tasks = response.data.slice();
	} );
	return tasks;
}

Vue.component('example', require('./components/Example.vue'));
var TaskNeedUpdate = new Set();
const app = new Vue({
    el: '#app',
    data: {
    	'tasks': [],
    	'errors': {},
    	'form': {
    		body: '',
    		_token: ''
    	},
    	'AddTaskProcessing': false,
    	'editTaskProcessing': false
    },
    computed: {
    	isError() {
    		return Object.keys(this.errors).length === 0;
    	}
    },
    methods: {
    	addToUpdateList(taskIndex, completed, event){
    		let checkbox = event.target;

    		//check if task-completed is change
    		if(checkbox.checked != completed){
				TaskNeedUpdate.add(this.tasks[taskIndex].id);
				
    		} else {
    			TaskNeedUpdate.delete(this.tasks[taskIndex].id);
    		}
    		console.log(TaskNeedUpdate);
    	},
    	clearSet(){
    		TaskNeedUpdate.clear();
    	},
    	addTask(){
    		let token = document.getElementsByName("_token")[0].value;
    		this.form._token = token;
    		axios.post('/tasks/store', this.form)
    		.then(response => {
    			this.getAllTask();
    		})
    		.catch(error => {
				this.errors = error.response.data;
				setTimeout(() => {
					this.errors = {};
				}, 5000);
				this.getAllTask();
    		});
    	},
    	getAllTask() {
    		axios.get('/tasks').then(response => {
				this.tasks = response.data;
			} );
			TaskNeedUpdate.clear();
    	},
    	updateTasks(){
    		axios.post('/tasks/update', {tasks: [...TaskNeedUpdate]} )
    		.then(response => this.getAllTask());
    	}
    },
    created() {
    	this.getAllTask();
    }
});

