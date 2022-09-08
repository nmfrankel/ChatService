<script lang="ts">
	import Button from '$lib/Button.svelte'
	import { userState } from '../userState'

	export let title = 'ChatService',
		path: string

	$: title = path.startsWith('/chat')
		? `${$userState.otherUser.first} ${$userState.otherUser.last}`
		: 'ChatService'
</script>

<header>
	<nav class="row">
		<div class="row">
			<Button
				icon="back"
				classes={path.startsWith('/chat') ? 'minimal' : 'hidden'}
				style="margin-right: .25em;border-radius:50%;padding: 6px;width: 1em;height: 1em;font-size: 2.1em;"
				on:click={() => (window.location.href = '/threads')}
			/>
			<div id="pageTitle">{title}</div>
		</div>
		<div class="row">
			{#if path === '/'}
				<Button
					classes="link small"
					text="Login"
					on:click={() => (window.location.href = 'login')}
				/>
			{:else if path === '/login'}
				&nbsp;
			{:else}
				<Button
					icon="search"
					classes="minimal"
					style="margin-right: 0;border-radius:50%;padding: 6px;width: 1em;height: 1em;font-size: 2.1em;"
				/>
				<Button
					icon="more"
					classes="minimal"
					style="margin-right: 0;border-radius:50%;padding: 6px;width: 1em;height: 1em;font-size: 2.1em;"
				/>
			{/if}
		</div>
	</nav>
</header>

<style>
	header {
		height: var(--headerHeight);
		height: 60px;
		width: 100%;
		padding: 0 1em;
		box-sizing: border-box;
		box-shadow: var(--lightShadow);
		box-shadow: 0 2px 6px 0 rgba(60, 64, 67, 0.12);
		z-index: 1;
	}
	nav {
		height: 100%;
		justify-content: space-between;
	}
	#pageTitle {
		font-size: 1.3125em;
	}
</style>
