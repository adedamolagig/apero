<template>
	<li class = "dropdown" v-if="notifications.length">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<span class="glyphicon glyphicon-bell"></span>
		</a>

		<ul class="dropdown-menu">
			<li v-for="notification in notifications">
				<a href="#">Foobar</a>
			</li>
		</ul>
	</li>
</template>


<script>
export default{
	data(){
		return { notifications: ['asdf'] }
	},

	created(){
		axios.get(`/profiles/${window.App.user.name}/notifications/`)
			.then(response => this.notifications = response.data);
	}
}

</script>