<script lang="ts">
	import Header from '$lib/header.svelte'
	import '../app.css'
</script>

<Header />
<main style="padding-top: 1em;">
	<slot />
</main>