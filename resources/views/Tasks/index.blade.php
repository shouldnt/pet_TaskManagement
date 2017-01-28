@extends('layout.layout')

@section('content')	
	<h1 class="title is-1">Task Management</h1>
	<form action="/tasks/store" method="post" class=section>
		{{csrf_field()}}
		<label for="" class="label">Body:</label>
		<p class="control">
			<textarea v-model="form.body" class="textarea" placeholder="Write your task here" name="body" ></textarea>
		</p>
		<p class="control">
			<button class="button is-primary" @click.prevent="addTask">Add Task</button>
		</p>	
	</form>

	<div class="section message is-warning" v-if="!isError">
		<div class="message-header">
			<p>Warning</p>
		</div>
		<div class="message-body">
			<ul>
				<li>@{{errors}}</li>
			</ul>
		</div>
	</div>
	
	<div class="section" v-if="tasks">
		<ul>
			<li v-for="(task,index) in tasks" class="columns notification " :class= "{'is-warning': !task.completed, 'is-primary': task.completed}">
				<p class="column">@{{task.body}}</p>
				<div class="column">
					<input type="checkbox" :checked="task.completed" @change="addToUpdateList(index, task.completed, $event)">
				</div>
				<div class="column">
					@{{task.created_at}}
				</div>
			</li>
		</ul>
		<button class="button is-primary" @click="updateTasks">Update</button>
	</div>
@stop

@section('script')
	<script src="{{ mix('js/app.js') }}"></script>
@stop