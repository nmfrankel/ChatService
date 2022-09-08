<script lang="ts">
	import Button from '$lib/Button.svelte'
	let showLogin = true
</script>

<div class="container row">
	<div class="support" class:hide={showLogin}>
		<div class="title">Our service guarantee</div>
		<ul>
			<li>Never compromising on <b>user privacy</b></li>
			<li><b>Never selling user data</b> to third parties</li>
			<li>Use <b>industry encryption standards</b> when applicable</li>
			<li />
		</ul>
	</div>
	<div class="form">
		{#if showLogin}
			<h1>Login to continue chatting</h1>
			<p>Catch up from where you left off.</p>

			<!-- <input type="text"> -->

			<Button
				text="Login"
				style="width: 348px;justify-content: center"
				on:click={() => (window.location.href = '/threads')}
			/>
			<Button
				text="Signup"
				classes="link"
				style="display:block;margin-top: 1rem;width: 348px;justify-content: center"
				on:click={() => (showLogin = false)}
			/>
		{:else}
			<h1>Start chatting with your friends</h1>
			<p>Get on the platform that everyone moved to and claim your handle before it gets taken.</p>

			<!-- <input type="text"> -->

			<Button text="Signup" style="width: 348px;justify-content: center" />
			<Button
				text="Login"
				classes="link"
				style="display:block;margin-top: 1rem;width: 348px;justify-content: center"
				on:click={() => (showLogin = true)}
			/>
		{/if}
	</div>
	<div class="support" class:hide={!showLogin}>
		<div class="title">Our service guarantee</div>
		<ul>
			<li>Never compromising on <b>user privacy</b></li>
			<li><b>Never selling user data</b> to third parties</li>
			<li>Use <b>industry encryption standards</b> when applicable</li>
			<li />
		</ul>
	</div>
</div>

<style>
	.container {
		flex-grow: 1;
		align-items: stretch;
		overflow-x: hidden;
	}
	.form,
	.support {
		padding: 6rem 0 0 6rem;
	}
	.form {
		flex-grow: 1;
	}
	.form > * {
		width: 348px;
	}
	.support {
		min-height: 100%;
		width: 40%;
		box-sizing: border-box;
		background-color: #f7fafc;
		font-size: 0.875rem;
		color: #718096;
		transition: all ease-out 200ms;
	}
	.support.hide {
		width: 0px;
		padding: 6rem 0 0 0;
		overflow: hidden;
		color: #f7fafc;
	}
	.support.hide * {
		width: 0px;
		overflow-x: hidden;
		white-space: nowrap;
		white-space: pre;
	}
	h1 {
		font-size: 1.875rem;
		line-height: 2.25rem;
		margin: 0 0 0.5rem;
	}
	p {
		margin-bottom: 3rem;
		color: #9ca3af;
		color: #50545a;
		font-size: 0.875rem;
		line-height: 1.25rem;
	}
	.title {
		font-size: 0.75rem;
		text-transform: uppercase;
	}
	ul {
		/* list-style-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' name='check' lens-role='icon' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline stroke='%23718096' points='20 6 9 17 4 12'%3E%3C/polyline%3E%3C/svg%3E%0A"); */
		transition: all linear 300ms;
		list-style-type: '✔';
	}
	.support.hide ul {
		opacity: 0;
	}
	li {
		padding-left: 0.5rem;
		transition: none;
		line-height: 1.75rem;
	}
</style>
