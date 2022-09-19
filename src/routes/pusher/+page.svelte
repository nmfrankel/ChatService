<script>
	import { onMount } from 'svelte'
	import Pusher from 'pusher-js'

	onMount(() => {
		// Enable pusher logging - don't include this in production
		// Pusher.logToConsole = true

		var pusher = new Pusher(import.meta.env.VITE_PUSHER_KEY, {
			cluster: 'eu',
			// userAuthentication: {
			// endpoint: "/api/pusher/auth_channel",
			// transport: "ajax",
			// },
			channelAuthorization: {
				endpoint: '/api/pusher/auth_channel',
				transport: 'ajax'
			}
		})

		pusher.signin()

		var channel = pusher.subscribe('private-chat-userId')
		channel.bind('message', (data) => {
			alert(JSON.stringify(data))
			console.log(JSON.stringify(data))
		})
	})
</script>
