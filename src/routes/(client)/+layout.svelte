<script lang="ts">
	import { userToken } from 'src/userToken'
	import { onMount } from 'svelte'

	onMount(() => {
		if (!$userToken || !$userToken.sub || $userToken.role === 'UNAUTHENTICATED')
			window.location.href = '/login'
	})
</script>

<slot />
