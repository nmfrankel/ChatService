<script lang="ts">
	import Button from "$lib/Button.svelte";

	let data: thread[] | Promise<thread[]> = []
	const loadThreads = () => data = fetch('messages_thread.json').then(res => res.json())
	const readableTime = (data: any) => data

	$: loadThreads()
</script>

<svelte:head>
	<title>Threads | ChatService</title>
	<meta name="description" content="See all the threads you have between your friends." />
</svelte:head>

<button on:click={loadThreads}>Reload</button>
<div class="container">
	{#await data}
		Loading...
	{:then threads}
		{#each threads as thread}
			{JSON.stringify(thread)}<br>

			<a href='.' class='{thread} unread' on:click|preventDefault={() => alert('This feature doesn\'t work yet.')}>
				<div class="imgContainer">
					<!-- {#if}<img src="" alt="" on:error={() => this.style.display = 'none'}>{/if} -->
					<div>{thread.sender.handle[0]}</div>
					<div>{thread.receiver.handle[0]}</div>
				</div>
				<div class="info">
					<div class="receiver">{thread.sender?.fullname} | {thread.receiver?.fullname} | Sender's name</div>
					<div class="content">
						{#if thread.msgType === 'text/plain'}
							{thread.content}
						{:else}
							\"You\": sent a {thread.msgType}
						{/if}
					</div>
					<div class="metaData">
						<div class="timestamp">{readableTime(thread.posted)}</div>
						<!-- <div class="unreadCount"></div> -->
					</div>
				</div>
			</a>
		{:else}
			No threads
		{/each}
	{:catch err}
		An error occured {err}
	{/await}
</div>

<style>

</style>