<script lang="ts">
	import { userState } from '../userState'

	let data: Msg[] | Promise<Msg[]> = []
	const loadMsgs = () => (data = fetch('messages_unique.json').then((res) => res.json()))

	$: loadMsgs()
</script>

<!-- <div>User info: {JSON.stringify($userState.otherUser)}<br /></div> -->

<div class="container" on:dblclick={() => loadMsgs()}>
	{#await data}
		<div class="trueCenter" style="margin-top: 38vh;">Loading...</div>
	{:then msgs}
		{#each msgs as msg, id}
			<div
				class="msg {msg.sender.id == $userState.user.id ? 'outgoing' : 'incoming'}"
				class:first={msgs[id - 1]?.sender.id !== msg.sender.id}
				class:last={msgs[id + 1]?.sender.id !== msg.sender.id}
				on:click={() => false}
			>
				{#if msg.msgType === 'text/plain'}
					{msg.content}
				{:else}
					Invalid message type
				{/if}
			</div>

			<!-- <div>{JSON.stringify(msg)}</div> -->
		{:else}
			<!-- <div class="trueCenter">No threads, start chatting</div> -->
			No messages
		{/each}
	{:catch err}
		<div class="trueCenter">An error occured | {err}</div>
	{/await}
</div>

<style>
	:root {
		--edgePadding: 2.5rem;
		--defaultText: #202124;
		--disabledText: #94a2a8;
		--secondaryText: #5f6368;
		--primaryBackground: #fff;
		--hover: #f5f6f7;
		--primary: #2b56c6;
		--darkShadow: none;
		--lightShadow: 0 2px 6px 0 rgba(60, 64, 67, 0.15);

		--incomingBgColor: #f2f2f2;
		--incomingColor: var(--defaultText);
		--outgoingBgColor: #ecf3fe;
		--outgoingColor: var(--defaultText);
	}
	.container {
		display: flex;
		flex-direction: column;
		padding: 1rem;
	}
	.msg {
		align-self: flex-start;
		max-width: 450px;
		margin-top: 4px;
		padding: 10px 12px;
		border-radius: 4px;
		box-shadow: -1px 2px 10px 2px var(--lightShadow);

		background: var(--incomingBgColor);
		color: var(--incomingColor);
		border-radius: 0px 20px 20px 0px;
		font-size: 0.875rem;
	}
	.msg.first {
		border-top-left-radius: 20px;
	}
	.msg.last {
		border-bottom-left-radius: 20px;
	}
	.msg.outgoing {
		align-self: flex-end;
		background-color: var(--outgoingBgColor);
		color: var(--outgoingColor);
		border-radius: 20px 0px 0px 20px;
	}
	.msg.outgoing.first {
		border-top-right-radius: 20px;
	}
	.msg.outgoing.last {
		border-bottom-right-radius: 20px;
	}
</style>
