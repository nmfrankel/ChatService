<script lang="ts">
	import { page } from '$app/stores'
	import Chat from '../+page.svelte'

	export let handle = $page.params.handle
</script>

{handle}
<Chat />
