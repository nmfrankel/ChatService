<script lang="ts">
	import { dev } from '$app/environment';
	import { inject } from '@vercel/analytics';
	import { page } from '$app/stores'
	import Header from '$lib/Header.svelte'
	import '../app.css'

	inject({ mode: dev ? 'development' : 'production' });
</script>

<Header path={$page.url.pathname} />
<main>
	<slot />
</main>

<style>
	main {
		display: flex;
		flex-direction: column;
		height: 100%;
		flex-grow: 1;
		padding-top: 1px;
	}
</style>
